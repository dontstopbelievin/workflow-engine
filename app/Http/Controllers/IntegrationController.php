<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Integrations\shep\sender\ShepRequestSender;
use App\Integrations\shep\receiver\ServiceRequestRouter;
use App\Integrations\shep\ShepUtil;
use App\Process;

class IntegrationController extends Controller
{
    public function index(Request $request, $type)
    {
        $array_data = [];
        foreach($request['data'] as $key => $value){
            $array_data[$key] = $value;
        }
        // $sUnsignedXml = ShepUtil::arrayToXML($array_data);
        // return $sUnsignedXml;
        // return $array_data['request']['RequestData'][0]['ServicesType'][0];
        $response = array();
        switch ($type) {
            case 'shep':
                if (isset($request['service'])) {
                    $response = ShepRequestSender::send($request['service'], $array_data);
                } else {
                    echo 'no service found';
                }
                break;
            default:
                echo 'no integration found';
                break;
        }
        print_r($response);
        exit;
    }

    public function test() // HERE!!!
    {
       // return 'asdf';
        // return Carbon::now()->toDateTimeString();
        // return hash('sha512', 'admin@gmail.com123ETO_SOL');
        try {
            $response = array();
            // $response['egkn_receive_status'] = ShepRequestSender::send('egkn_receive_status', $_GET);
            // $response['egkn_receive_order'] = ShepRequestSender::send('egkn_receive_order', $_GET);
            // $response['geoportal_egkn_receive_layer'] = ShepRequestSender::send('geoportal_egkn_receive_layer', $_GET);
            // $response['egkn_geoportal_actualization'] = ShepRequestSender::send('egkn_geoportal_actualization', $_GET);
            // $response['eds_temp_files'] = ShepRequestSender::send('eds_temp_files', $_GET);
            // $data = [];
            // $data['correlationId'] = '-1999';
            // $data['messageType'] = '-1999';
            // $data['data'] = ['test' => 'test'];

            $system_info = [];
            $system_info["RequestNumber"] = "10000000000000005764";
            $system_info["ChainId"] = "10000000000000005764";
            $system_info["RequestDate"] = "2020-06-23T14:22:54.719+06:00";
            $response_data = [];
            $response_data["RequestNumber"] = "10000000000000005764";
            $response_data["CurrentStatus"] = "001";
            $response_data["CurrentStatusText"] = "???????????? ?????????????? ??????????????";
            $data = [];
            $response_message = [];
            $response_message["SystemInfo"] = $system_info;
            $response_message["ResponseData"] = $response_data;
            $data["responseMessage"] = $response_message;
            $to_send = [];
            $to_send["correlationId"] = "3376387";
            $to_send["data"] = $data;
            $to_send["messageType"] = "NOTIFICATION";
            $response['geoportal_pep_async'] = ShepRequestSender::send('geoportal_pep_async', $to_send);
            // $response['ais_gzk_get_data'] = ShepRequestSender::send('ais_gzk_get_data', $_GET);
            // $response['ais_gzk_get_relevance'] = ShepRequestSender::send('ais_gzk_get_relevance', $_GET);
            return view('test')->with('data', $response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function pep_send_notification(Request $request){
        try{
            $aData = array(
                'responseMessage' => array(
                    'SystemInfo' => array(
                        'RequestNumber' => $request['RequestNumber'],
                        'ChainId' => $request['ChainId'],
                        'RequestDate' => $request['RequestDate']
                    ),
                    'ResponseData' => array(
                        'RequestNumber' => $request['RequestNumber'],
                        'CurrentStatus' => '001',
                        'CurrentStatusText' => '???????????? ?????????????? ??????????????'
                    )
                )
            );
            $aPreparedData = array(
                'correlationId' => $request['sCorrelationId'],
                'data' => $aData,
                'messageType' => 'NOTIFICATION'
            );

            $response['geoportal_pep_async'] = ShepRequestSender::send('geoportal_pep_async', $aPreparedData);
            return $response;
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function pepaResponseData_send_response(Request $request){
        try{
            $aData = array(
                'responseMessage' => array(
                    'SystemInfo' => array(
                        'RequestNumber' => '10000000000000005764',
                        'ChainId' => '10000000000000005764',
                        'RequestDate' => '2020-06-23T14:22:54.719+06:00'
                    ),
                    'ResponseData' => array(
                        'RequestNumber' => 'request number here',
                        'CurrentStatus' => '001',
                        'FirstStepResponse' => array(
                            'Act' => array(
                                'CodeType' => 'ZKR4',
                                'FileName' => '?????? ???????????? ?????????????????????????? ???????? ??????????.pdf',
                                'FileId' => '00000000-0000-7071-6571-dc6e265c080b',
                                'DocNumber' => '115',
                                'DocDate' => '2020-07-23+06:00',
                                'FileType' => 'ActReconcilation_or_RefuseAct'
                            )
                        )
                    )
                )
            );
            $aPreparedData = array(
                'correlationId' => 'Correlation Id here',
                'data' => $aData,
                'messageType' => 'RESPONSE'
            );
            $response['geoportal_pep_async'] = ShepRequestSender::send('geoportal_pep_async', $aPreparedData);
            return view('test')->with('data', $response);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function json_to_array($json_obj)
    {

        return 'asd';
    }

    public function receive(Request $request)
    {
        ServiceRequestRouter::route($request);
    }

    public function sync(Request $request)
    {
        return true;
    }

    public function async(Request $request)
    {
        return true;
    }
}
