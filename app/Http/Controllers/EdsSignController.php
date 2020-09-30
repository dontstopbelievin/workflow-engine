<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Malikzh\PhpNCANode;

class EdsSignController extends Controller
{
    public function loginByCert(Request $request)
    {
        $data = $request->data;
        $oDate = new \DateTime('now');
        preg_match('|<ds\:X509Certificate[^>]*?>(.*?)</ds\:X509Certificate>|si', $data, $x509Info);
        $replacedXml = str_replace("\r\n", '', $x509Info[1]);

        $oNca = new PhpNCANode\NCANodeClient('http://95.59.124.164:14579');
        $oPkcs12Info = $oNca->x509Info($replacedXml);

        if ($oPkcs12Info->isLegalFix() === true) {
            if ($oPkcs12Info->isExpiredFix($oDate) === false) {
                $aCertRaws = $oPkcs12Info->getRaw();
                if (isset($aCertRaws['subject']['iin'])) {
                    $sIin = $aCertRaws['subject']['iin'];
                    $aUser = User::where('iin', $sIin)->first();
                } else if (isset($aCertRaws['subject']['bin'])) {
                    $sBin = $aCertRaws['subject']['bin'];
                    $aUser = User::where('bin', $sBin)->first();
                }
                if (isset($aUser)) {
//                    dd($aUser);
                  Auth::login($aUser);
                  return redirect('/home')->with('status','you are not allowed to Admin Dashboard');
                } else {
                    return response(['message'=>'Пользователь не существует в системе! Обратитесь администратору!'], 409);
                }
            } else {
                return response(['message'=>'Ваш сертификат просрочен! Пожалуйста обновите сертификат!'], 401);
            }
        } else {
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
                header('Content-Type: application/xml');
                $bodyContent  = file_get_contents(base_path('app/wsdl/result_wsdl.xml'));
                echo $bodyContent;
                break;
            default:
                echo 'no route for integration';
                break;
        }
    }
}
