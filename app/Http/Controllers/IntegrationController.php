<?php

namespace App\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Http\Request;
use App\Integrations\shep\sender\ShepRequestSender;
use App\Integrations\shep\receiver\ServiceRequestRouter;

use App\Process;

class IntegrationController extends Controller
{
    public function index($type)
    {
        $response = array();
        switch ($type) {
            case 'shep':
                if (isset($_GET['service'])) {
                    $response = ShepRequestSender::send($_GET['service'], $_GET);
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
        $client = new \GuzzleHttp\Client(['verify' => false, 'http_errors' => false, 'CURLOPT_SSLVERSION' => 3]);
         $url = env('DJANGO_URL_LOGIN', 'https://sacral.openlayers.kz/login/');
         $hash = hash('sha512', '123123123123'.'123'.'why_so_ez?');

         $request_param = [
             'first_name' => 'asd',
             'last_name' => 'asd',
             'username' => '123123123123',
             'password' => '123',
             'role' => 'admin',
             'city' => 'astana',
             'hash' => $hash,
         ];

         $request_data = json_encode($request_param);
         $response = $client->request(
             'POST',
             $url,
             [
                 'headers' => [
                     'Accept' => 'application/json',
                     'Content-Type'=> 'application/json'
                 ],
                 'body'   => $request_data
             ]
         );

         $result = json_decode($response->getBody(), true);

        return response()->json([$request_param, $result, $response], 501);
        return view('test');
        // return Carbon::now()->toDateTimeString();
        // return hash('sha512', 'admin@gmail.com123ETO_SOL');
        $response = array();
        $response['egkn_receive_status'] = ShepRequestSender::send('egkn_receive_status', $_GET);
        $response['egkn_receive_order'] = ShepRequestSender::send('egkn_receive_order', $_GET);
        $response['geoportal_egkn_receive_layer'] = ShepRequestSender::send('geoportal_egkn_receive_layer', $_GET);
        $response['egkn_geoportal_actualization'] = ShepRequestSender::send('egkn_geoportal_actualization', $_GET);
        $response['eds_temp_files'] = ShepRequestSender::send('eds_temp_files', $_GET);
        $data = [];
        $data['correlationId'] = '-1';
        $data['messageType'] = '-1';
        $data['data'] = [];
        $response['geoportal_pep_async'] = ShepRequestSender::send('geoportal_pep_async', $data);
        $response['ais_gzk_get_data'] = ShepRequestSender::send('ais_gzk_get_data', $_GET);
        $response['ais_gzk_get_relevance'] = ShepRequestSender::send('ais_gzk_get_relevance', $_GET);
        return view('test')->with('data', $response);
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
