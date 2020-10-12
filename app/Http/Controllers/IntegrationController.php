<?php

namespace App\Http\Controllers;

use App\Integrations\shep\ShepUtil;
use App\Integrations\shep\ShepXmlUtil;
use Illuminate\Http\Request;
use App\Integrations\shep\sender\ShepRequestSender;
use Illuminate\Support\Facades\Storage;

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

    public function receive(Request $request)
    {
        $sXml = $request->getContent();
        Storage::disk('local')->put('async_responses/' . time(), $sXml);
        $aResponseData = ShepUtil::getSoapBody($sXml);
        if (isset($aResponseData['request'])) {
            $sCorrelationId = $aResponseData['request']['messageInfo']['correlationId'];
            $sUnsignedXml = ShepXmlUtil::getSoapAsyncResponse($sCorrelationId);
            header('Content-Type: application/soap+xml; charset=utf-8');
            echo ShepUtil::signXml($sUnsignedXml);
            exit;
        }
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
