<?php

namespace shep\receiver;

class ServiceRequestRouter
{
    public function __construct() {}

    public function __call($sFunction, $aArguments)
    {
        try {
            $postdata = file_get_contents("php://input");
            file_put_contents(TMP_PATH . '/shep_request_' . time() . '.xml', $postdata);
            $aArguments = \app\tsoed\ShepUtil::getSoapBody($postdata);
            preg_match('/(<serviceId[^>]*>)(.*?)(<\/serviceId>)/', $postdata, $aServiceIdMatches);
            $sServiceId = $aServiceIdMatches[2];
            preg_match('/xsi:type="([a-zA-Z0-9]+:)?([^"]+)/', $postdata, $aDocumentTypeMatches);
            $sDocumentType = a($aDocumentTypeMatches, 2, null);
            switch ($sServiceId) {
                case 'DocumentologExpertiseSED':
                    $oShepServiceExecutor = new \shep\receiver\ShepServiceExecutor(new \shep\receiver\services\ServiceExpertiseStrategy($sDocumentType));
                    break;
                case 'ApostilPEPServiceSync':
                    $oShepServiceExecutor = new \shep\receiver\ShepServiceExecutor(new \shep\receiver\services\ServiceSyncApostilPEPStrategy($sDocumentType));
                    break;
                case 'ApostilPEPServiceAsync':
                    $oShepServiceExecutor = new \shep\receiver\ShepServiceExecutor(new \shep\receiver\services\ServiceAsyncApostilPEPStrategy($sDocumentType));
                    break;
                default:
                    throw new \SoapFault(0, 'No service found');
            }
            $aUnsignedResponse = $oShepServiceExecutor->execute($aArguments);
            header('Content-Type: application/soap+xml; charset=utf-8');
            echo \app\tsoed\ShepUtil::signXml($aUnsignedResponse);
            exit;
        } catch (\Exception $e) {
            \app\system\Logger::log($e);
            return new \SoapFault('0', 'Внутренняя ошибка сервиса. Свяжитесь с поставщиком сервиса.');
        }
    }
}