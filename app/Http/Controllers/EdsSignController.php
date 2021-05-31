<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\File;
use App\FileCategory;
use App\Libs\PhpNCANode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Traits\dbQueries;
use Illuminate\Support\Carbon;

class EdsSignController extends Controller
{
    use dbQueries;

    public function loginByCert(Request $request)
    {
//        dd($request->all());
        $data = $request->data;
        $oDate = new \DateTime('now');
        preg_match('|<ds\:X509Certificate[^>]*?>(.*?)</ds\:X509Certificate>|si', $data, $x509Info);

        $replacedXml = str_replace("\r\n", '', $x509Info[1]);

        $oNca = new PhpNCANode\NCANodeClient(env('NCA_NODE_IP', 'http://95.59.124.162:14579')); //95.59.124.162 когда локально
        $oPkcs12Info = $oNca->x509Info($replacedXml);

        if ($oPkcs12Info->isLegal() === true) {
            if ($oPkcs12Info->isExpired($oDate) === false) {
                $aCertRaws = $oPkcs12Info->getRaw();
                if (isset($aCertRaws['subject']['iin'])) {
                    $sIin = $aCertRaws['subject']['iin'];
                    $user = User::where('iin', $sIin)->first();
                } else if (isset($aCertRaws['subject']['bin'])) {
                    $sBin = $aCertRaws['subject']['bin'];
                    $user = User::where('bin', $sBin)->first();
                }
                if (isset($user)) {
                    Auth::login($user);
                    $new_sessid   = \Session::getId(); //get new session_id after user sign in

                    if ($user->session_id != '') {
                        $last_session = \Session::getHandler()->read($user->session_id);

                        if ($last_session) {
                            if (\Session::getHandler()->destroy($user->session_id)) {
                                $user = auth()->guard('web')->user();
                                $mytime = Carbon::now()->toDateTimeString();

                                $txt = $mytime . ' ' . $user->sur_name.' '.$user->first_name.' '.$user->middle_name. ' '. $user->email . ' ' . "Попытка параллельного входа в систему\r\n";
                                file_put_contents(storage_path('logs/logfile.txt'), $txt, FILE_APPEND | LOCK_EX);
                            }
                        }
                    }

                    \DB::table('users')->where('id', $user->id)->update(['session_id' => $new_sessid]);

                    $user = auth()->guard('web')->user();
                    $mytime = Carbon::now()->toDateTimeString();

                    $txt = $mytime . ' ' . $user->sur_name.' '.$user->first_name.' '.$user->middle_name. ' ' . $user->email . ' ' . "Успешный вход в систему\r\n";
                    file_put_contents(storage_path('logs/logfile.txt'), $txt, FILE_APPEND | LOCK_EX);

                    $user->update([
                        'last_login_at' => $user->current_login_at,
                        'current_login_at' => Carbon::now()->toDateTimeString(),
                        'last_login_ip' => $request->getClientIp(),
                    ]);
                    if($user->new_password){
                        session()->put('new_password', 1);
                    }
                    if($user->role->name == "Заявитель"){
                        return response()->json(['redirect' => 'docs'], 200);
                    }else{
                        return response()->json(['redirect' => 'docs/services/incoming'], 200);
                    }
                } else {
                    return response()->json(['name' => explode(' ', $aCertRaws['subject']['commonName'])[1], 'surname' => $aCertRaws['subject']['surname'], 'lastname' => $aCertRaws['subject']['lastName'], 'iin' => $aCertRaws['subject']['iin'], 'email' => $aCertRaws['subject']['email']], 200);
                }
            } else {
                return response(['message'=>'Ваш сертификат просрочен! Пожалуйста обновите сертификат!'], 401);
            }
        }else{
            return response(['message'=>'Ваш сертификат не актуален! Пожалуйста обновите сертификат!'], 400);
        }
    }

    public function get_include_contents($filename) {
        if (is_file($filename)) {
            ob_start();
            include $filename;
            $contents = ob_get_contents();
            ob_end_clean();
            return $contents;
        }
        return false;
    }

    public function example($wsdl)
    {
        switch ($wsdl) {
            case 'shep':
                header('Content-Type: text/xml');
                $bodyContent  = file_get_contents(base_path('app/wsdl/result_wsdl.xml'));
                echo $bodyContent;
                break;
            default:
                echo 'no route for integration';
                break;
        }
    }

    public function receive()
    {
        header('Content-Type: text/xml');
        $bodyContent  = file_get_contents(base_path('app/wsdl/responce_wsdl.xml'));
        echo $bodyContent;
        exit;
    }

    public function getEgknRaws($id)
    {
        $query = \DB::table('egkn_services')
                    ->select('*')
                    ->where('id',$id)
                    ->get()
                    ->first();
        return json_decode(json_encode($query), true);
    }

    public function viewsign(Request $request)
    {
        $aEgknRaws = $this->getEgknRaws($request->id);
        $aEgknXmlRows = $this->xmlGenerator($aEgknRaws);
        return view('test.testpage', compact('aEgknRaws', 'aEgknXmlRows'));
    }

    public function signVerify(Request $request)
    {
        $oNca = new PhpNCANode\NCANodeClient(env('NCA_NODE_IP', 'http://95.59.124.162:14579'));
        $signedXml = $request->signedXml;
        $xmlVerification = $oNca->xmlVerify($signedXml);
        if ($xmlVerification->isValid() === true) {
            $oCertInfo = $xmlVerification->getCert();
            if (!empty($oCertInfo)) {
                if ($oCertInfo->isLegal() === true) {
                    if ($oCertInfo->isExpired() === false) {
                        $signSave = $this->signSave($request);
                    } else {
                        return response(['message' => 'Ваш сертификат просрочен! Пожалуйста обновите сертификат!'], 403);
                    }
                } else {
                    return response(['message' => 'Ваш сертификат не актуален! Пожалуйста обновите сертификат!'], 402);
                }
            } else {
                return response(['message'=>'Не найден сертификат!'], 401);
            }
        } else {
            return response(['message'=>'Не валидный подпись!'], 400);
        }
    }

    public function signSave(Request $request)
    {
        $input = $request->all();
        $application_id = $request->applicationId;
        $process_id =  $request->processId;
        $role_id = Auth::user()->role_id;
        $path = 'sign_files/' . $process_id . '/' . $application_id;
        $file = File::addXmlItem($role_id, FileCategory::XML, $path, $input['signedXml']);

        if (!$file) {
            throw new \Exception('Не удалось сохранить модель File');
        }
        return response (['message'=>'Документ подписан!'], 200);
    }



}
