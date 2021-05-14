<?php

namespace App\Http\Controllers;

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
        \DB::table('dictionaries')->where('name', 'construction_name_before')->update(['input_type_id' => 3]);
        \DB::table('dictionaries')->where('name', 'construction_name_after')->update(['input_type_id' => 3]);
        return 'done';
        $processes = Process::all();
        dd($processes);
        $fields = ['name', 'surname', 'address', 'attachment'];
        $request = new \Illuminate\Http\Request();
        $request->replace(['fields' => $fields]);
        // foreach ($processes as $process) {
        //     app('App\Http\Controllers\ProcessController')->createProcessTable($request, $process);
        // }
        return view('test');
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
