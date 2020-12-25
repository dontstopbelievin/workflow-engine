<?php

namespace App\Integrations\shep;

class ShepXmlUtil
{
    public static function getUploadFileXml($sFileId, \app\media\File $oFile)
    {
        $sXml = '<tempStorageRequest><uploadRequest><fileUploadRequests><fileProcessIdentifier>' . $sFileId . '</fileProcessIdentifier><name>' . v($oFile['name']) . '</name><content>' . $oFile->getBase64Content() . '</content><mime>' . $oFile['mime_type'] . '</mime><lifeTime>28800000</lifeTime><needToBeConfirmed>false</needToBeConfirmed></fileUploadRequests></uploadRequest><credentials><senderId>' . v(\app\system\Registry::get('config')->get('shep_hed_login')) . '</senderId><password>' . v(\app\system\Registry::get('config')->get('shep_hed_password')) . '</password></credentials><type>UPLOAD</type></tempStorageRequest>';
        return self::getSoapRequest('EDS_TEMP_FILES', $sXml);
    }

    public static function getDownloadFileXml($sFileId)
    {
        $sXml = '<tempStorageRequest><downloadRequest><fileIdentifiers>' . $sFileId . '</fileIdentifiers></downloadRequest><credentials><senderId>' . v(\app\system\Registry::get('config')->get('shep_hed_login')) . '</senderId><password>' . v(\app\system\Registry::get('config')->get('shep_hed_password')) . '</password></credentials><type>DOWNLOAD</type></tempStorageRequest>';
        return self::getSoapRequest('EDS_TEMP_FILES', $sXml);
    }

    public static function getSoapResponse($sCode, $sSuccess, $sXml)
    {
        return '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:typ="http://bip.bee.kz/SyncChannel/v10/Types"><soapenv:Body><typ:SendMessageResponse><response><responseInfo><messageId>' . Uuid::generateV4() . '</messageId><responseDate>' . date('Y-m-d').'T'. date('H:i:sP') . '</responseDate><status><code>' . $sCode . '</code><message>' . $sSuccess . '</message></status></responseInfo><responseData><data>' . $sXml . '</data></responseData></response></typ:SendMessageResponse></soapenv:Body></soapenv:Envelope>';
    }

    public static function getSoapRequest($sServiceId, $sXml)
    {
        $sDataTag = '<data>';
        return '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:typ="http://bip.bee.kz/SyncChannel/v10/Types" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xenc="http://www.w3.org/2001/04/xmlenc#"><soapenv:Body><typ:SendMessage><request><requestInfo><messageId>' . Uuid::generateV4() . '</messageId><correlationId></correlationId><serviceId>' . $sServiceId . '</serviceId><messageDate>' . ShepUtil::getTimestampWithTimeZone() . '</messageDate><routeId></routeId><sender><senderId>' . config('shep.login') . '</senderId><password>' . config('shep.password') . '</password></sender><properties></properties><sessionId></sessionId></requestInfo><requestData>' . $sDataTag . $sXml . '</data></requestData></request></typ:SendMessage></soapenv:Body></soapenv:Envelope>';
    }

    public static function getSoapAsyncRequest($sServiceId, $sXml, $sMessageType = 'REQUEST', $sCorrelationId = '')
    {
        $sCorrelationIdTag = '';
        if (mb_strlen($sCorrelationId) > 0) {
            $sCorrelationIdTag = '<correlationId>' . $sCorrelationId . '</correlationId>';
        }
        return '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><soapenv:Body><typ:sendMessage xmlns:typ="http://bip.bee.kz/AsyncChannel/v10/Types"><request><messageInfo>' . $sCorrelationIdTag . '<serviceId>' . $sServiceId . '</serviceId><messageType>' . $sMessageType . '</messageType><messageDate>' . ShepUtil::getTimestampWithTimeZone() . '</messageDate><sender><senderId>' . config('shep.login') . '</senderId><password>' . config('shep.password') . '</password></sender></messageInfo><messageData><data>' . $sXml . '</data></messageData></request></typ:sendMessage></soapenv:Body></soapenv:Envelope>';
    }

    public static function getSoapAsyncResponse($sCorrelationId)
    {
        return '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"><soapenv:Body><typ:sendMessageResponse xmlns:typ="http://bip.bee.kz/AsyncChannel/v10/Types"><response><messageId>' . Uuid::generateV4() . '</messageId><correlationId>' . $sCorrelationId . '</correlationId><responseDate>' . date('Y-m-d').'T'. date('H:i:sP') . '</responseDate></response></typ:sendMessageResponse></soapenv:Body></soapenv:Envelope>';
    }
}
