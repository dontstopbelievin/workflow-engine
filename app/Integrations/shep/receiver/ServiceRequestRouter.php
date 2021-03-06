<?php

namespace App\Integrations\shep\receiver;

use App\Integrations\shep\receiver\services\EgknGeoportalActualizationStrategy;
use App\Integrations\shep\receiver\services\GeoportalGzkGetDataStrategy;
use App\Integrations\shep\receiver\services\GeoportalGzkGetRelevanceStrategy;
use App\Integrations\shep\receiver\services\GeoportalPEPAsyncRequestStrategy;
use App\Integrations\shep\receiver\services\GetGeoDataFromGzkToGeoportalStrategy;
use App\Integrations\shep\receiver\services\EgknUniversalReceiveOrder;
use App\Integrations\shep\ShepUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceRequestRouter
{
    public static function route(Request $request)
    {
        try {
            $sXml = $request->getContent();
            $sFileName = time();
            $aResponseData = ShepUtil::getSoapBody($sXml);
            preg_match('/(<serviceId[^>]*>)(.*?)(<\/serviceId>)/', $sXml, $aServiceIdMatches);
            $sServiceId = $aServiceIdMatches[2];
            if ($sServiceId) {
                $sFolder = $sServiceId;
            } else {
                $sFolder = 'Unknown';
            }
            Storage::disk('local')->put('received/' . $sFolder . '/' . $sFileName . '.xml', $sXml);
            switch ($sServiceId) {
                case 'EgknGeoportalActualization':
                    $oShepServiceStrategy = new EgknGeoportalActualizationStrategy($aResponseData);
                    break;
                case 'get_ZU_RGIS_UniversalService':
                    $oShepServiceStrategy = new GeoportalPEPAsyncRequestStrategy($aResponseData);
                    break;
                case 'GetGeoDataFromGzkToGeoportal':
                    $oShepServiceStrategy = new GetGeoDataFromGzkToGeoportalStrategy($aResponseData);
                    break;
                case 'GeoportalGzkGetData':
                    $oShepServiceStrategy = new GeoportalGzkGetDataStrategy($aResponseData);
                    break;
                case 'GeoportalGzkGetRelevance':
                    $oShepServiceStrategy = new GeoportalGzkGetRelevanceStrategy($aResponseData);
                    break;
                case 'EgknUniversalReceiveOrder':
                    $oShepServiceStrategy = new EgknUniversalReceiveOrder($aResponseData);
                    break;
                default:
                    throw new \SoapFault('Server', 'No service found');
            }
            $sUnsignedResponse = (new ShepServiceExecutor($oShepServiceStrategy))->execute();
            $sSignedResponse = ShepUtil::signXml($sUnsignedResponse);
            // $sSignedResponse = $sUnsignedResponse;
            Storage::disk('local')->put('responses/'. $sFolder . '/' . $sFileName . '.xml', $sSignedResponse);
            header('Content-Type: application/soap+xml; charset=utf-8');
            echo $sSignedResponse;
            exit;
        } catch (\Exception $e) {
            logger($e->getMessage());
            return new \SoapFault('Server', '???????????????????? ???????????? ??????????????. ?????????????????? ?? ?????????????????????? ??????????????.');
        }
    }
}
