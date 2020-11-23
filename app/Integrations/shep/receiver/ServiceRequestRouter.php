<?php

namespace App\Integrations\shep\receiver;

use App\Integrations\shep\receiver\services\EgknGeoportalActualizationStrategy;
use App\Integrations\shep\receiver\services\GeoportalPEPAsyncRequestStrategy;
use App\Integrations\shep\ShepUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceRequestRouter
{
    public static function route(Request $request)
    {
        try {
            $sXml = $request->getContent();
            Storage::disk('local')->put('async_responses/' . time(), $sXml);
            $aResponseData = ShepUtil::getSoapBody($sXml);
            preg_match('/(<serviceId[^>]*>)(.*?)(<\/serviceId>)/', $sXml, $aServiceIdMatches);
            $sServiceId = $aServiceIdMatches[2];
            switch ($sServiceId) {
                case 'EgknGeoportalActualization':
                    $oShepServiceStrategy = new EgknGeoportalActualizationStrategy($aResponseData);
                    break;
                case 'get_ZU_RGIS_UniversalService':
                    $oShepServiceStrategy = new GeoportalPEPAsyncRequestStrategy($aResponseData);
                    break;
                default:
                    throw new \SoapFault(0, 'No service found');
            }
            $sUnsignedResponse = (new ShepServiceExecutor($oShepServiceStrategy))->execute();
            header('Content-Type: application/soap+xml; charset=utf-8');
            echo ShepUtil::signXml($sUnsignedResponse);
            exit;
        } catch (\Exception $e) {
            logger($e->getMessage());
            return new \SoapFault('0', 'Внутренняя ошибка сервиса. Свяжитесь с поставщиком сервиса.');
        }
    }
}
