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

    public static function getSoapResponse_egkn_actualization($sCode, $sSuccess, $sXml)
    {
        return '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><soap:Body><ns2:SendMessageResponse xmlns:ns2="http://bip.bee.kz/SyncChannel/v10/Types" xmlns:ns3="http://egov.bee.kz/eds/tempstorage/v2/"><response><responseInfo><messageId>' . Uuid::generateV4() . '</messageId><responseDate>' . date('Y-m-d').'T'. date('H:i:sP') . '</responseDate><status><code>' . $sCode . '</code><message>' . $sSuccess . '</message></status></responseInfo><responseData><data>' . $sXml . '</data></responseData></response></ns2:SendMessageResponse></soap:Body></soap:Envelope>';
    }

    public static function getSoapRequest($sServiceId, $sXml)
    {
        $sDataTag = '<data>';
        return '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:typ="http://bip.bee.kz/SyncChannel/v10/Types" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xenc="http://www.w3.org/2001/04/xmlenc#"><soapenv:Body><typ:SendMessage><request><requestInfo><messageId>' . Uuid::generateV4() . '</messageId><correlationId></correlationId><serviceId>' . $sServiceId . '</serviceId><messageDate>' . ShepUtil::getTimestampWithTimeZone() . '</messageDate><routeId></routeId><sender><senderId>' . config('shep.login') . '</senderId><password>' . config('shep.password') . '</password></sender><properties></properties><sessionId></sessionId></requestInfo><requestData>' . $sDataTag . $sXml . '</data></requestData></request></typ:SendMessage></soapenv:Body></soapenv:Envelope>';
    }

    public static function getSoapRequest_egkn_rec_layer($sServiceId, $sXml)
    {
        $sDataTag = '<data>';
        return '<soap:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><SOAP-ENV:Header xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"/><SOAP-ENV:Body><ns4:SendMessage xmlns:ns2="http://newshep.geoportal.free.gbdrn.tamur.kz" xmlns:ns3="http://www.w3.org/2000/09/xmldsig#" xmlns:ns4="http://bip.bee.kz/SyncChannel/v10/Types"><request><requestInfo><messageId>' . Uuid::generateV4() . '</messageId><serviceId>' . $sServiceId . '</serviceId><messageDate>' . ShepUtil::getTimestampWithTimeZone() . '</messageDate><sender><senderId>' . config('shep.login') . '</senderId><password>' . config('shep.password') . '</password></sender><sessionId></sessionId></requestInfo><requestData>' . $sDataTag . $sXml . '</data></requestData></request></ns4:SendMessage></SOAP-ENV:Body></soap:Envelope>';
    }

    public static function getSoapAsyncRequest($sServiceId, $sXml, $sMessageType = 'REQUEST', $sCorrelationId = '')
    {
        $sCorrelationIdTag = '';
        if (mb_strlen($sCorrelationId) > 0) {
            $sCorrelationIdTag = '<correlationId>' . $sCorrelationId . '</correlationId>';
        }
        return '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><soapenv:Body><typ:sendMessage xmlns:typ="http://bip.bee.kz/AsyncChannel/v10/Types"><request><messageInfo>' . $sCorrelationIdTag . '<serviceId>' . $sServiceId . '</serviceId><messageType>' . $sMessageType . '</messageType><messageDate>' . ShepUtil::getTimestampWithTimeZone() . '</messageDate><sender><senderId>' . config('shep.login') . '</senderId><password>' . config('shep.password') . '</password></sender></messageInfo><messageData><data>' . $sXml . '</data></messageData></request></typ:sendMessage></soapenv:Body></soapenv:Envelope>';
    }

    public static function getSoapRequest_egkn_status($sServiceId, $sXml)
    {
        return '<soap:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><SOAP-ENV:Header xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"/><SOAP-ENV:Body><ns4:SendMessage xmlns:ns2="http://newshep.geoportal.free.gbdrn.tamur.kz" xmlns:ns3="http://www.w3.org/2000/09/xmldsig#" xmlns:ns4="http://bip.bee.kz/SyncChannel/v10/Types"><request><requestInfo><messageId>' . Uuid::generateV4() . '</messageId><serviceId>' . $sServiceId . '</serviceId><messageDate>' . ShepUtil::getTimestampWithTimeZone() . '</messageDate><sender><senderId>' . config('shep.login') . '</senderId><password>' . config('shep.password') . '</password></sender></requestInfo><requestData><data>' . $sXml . '</data></requestData></request></ns4:SendMessage></SOAP-ENV:Body></soap:Envelope>';
    }

    public static function getSoapAsyncRequest_egkn_order($sServiceId, $sXml, $sMessageType = 'REQUEST')
    {
        return '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><soap:Header/><soap:Body><ns:sendMessage xmlns:ns="http://bip.bee.kz/AsyncChannel/v10/Types"><request><messageInfo><messageId>' . Uuid::generateV4() . '</messageId><serviceId>' . $sServiceId . '</serviceId><messageType>' . $sMessageType . '</messageType><routeId/><messageDate>' . ShepUtil::getTimestampWithTimeZone() . '</messageDate><sender><senderId>' . config('shep.login') . '</senderId><password>' . config('shep.password') . '</password></sender></messageInfo><messageData><data>' . $sXml . '</data></messageData></request></ns:sendMessage></soap:Body></soap:Envelope>';
    }

    public static function getSoapAsyncRequest_pep($sServiceId, $sXml, $sMessageType = 'REQUEST', $sCorrelationId = '')
    {
        $sCorrelationIdTag = '';
        if (mb_strlen($sCorrelationId) > 0) {
            $sCorrelationIdTag = '<correlationId>' . $sCorrelationId . '</correlationId>';
        }
        return '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/"><SOAP-ENV:Header xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"/><soap:Body><ns2:sendMessage xmlns:ns2="http://bip.bee.kz/AsyncChannel/v10/Types"><request><messageInfo><messageId>' . Uuid::generateV4() . '</messageId>' . $sCorrelationIdTag . '<serviceId>' . $sServiceId . '</serviceId><routeId>R_NurSultan</routeId><messageDate>' . ShepUtil::getTimestampWithTimeZone() . '</messageDate><messageType>' . $sMessageType . '</messageType><sender><senderId>' . config('shep.login') . '</senderId><password>' . config('shep.password') . '</password></sender></messageInfo><messageData><data>' . $sXml . '</data></messageData></request></ns2:sendMessage></soap:Body></soap:Envelope>';
    }

    public static function getSoapAsyncRequest_pep_res($sServiceId, $sXml, $sMessageType = 'REQUEST', $sCorrelationId = '')
    {
        $sCorrelationIdTag = '';
        if (mb_strlen($sCorrelationId) > 0) {
            $sCorrelationIdTag = '<correlationId>' . $sCorrelationId . '</correlationId>';
        }
        return '<S:Envelope xmlns:S="http://schemas.xmlsoap.org/soap/envelope/" xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"><SOAP-ENV:Header/><S:Body><ns2:sendMessage xmlns:ns2="http://bip.bee.kz/AsyncChannel/v10/Types"><request><messageInfo><messageId>' . Uuid::generateV4() . '</messageId>' . $sCorrelationIdTag . '<serviceId>' . $sServiceId . '</serviceId><messageType>' . $sMessageType . '</messageType><messageDate>' . ShepUtil::getTimestampWithTimeZone() . '</messageDate><sender><senderId>' . config('shep.login') . '</senderId><password>' . config('shep.password') . '</password></sender></messageInfo><messageData><data>' . $sXml . '</data></messageData></request></ns2:sendMessage></S:Body></S:Envelope>';
    }

    public static function getSoapAsyncResponse2($sCorrelationId = '')
    {
        return '<soap:Envelope xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/" xmlns:typ="http://bip.bee.kz/AsyncChannel/v10/Types"><soapenv:Header xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"/><soap:Body><typ:sendMessageResponse xmlns:ns2="http://bip.bee.kz/AsyncChannel/v10/Types"><response><messageId>' . Uuid::generateV4() . '</messageId><correlationId>' . $sCorrelationId . '</correlationId><responseDate>' . date('Y-m-d').'T'. date('H:i:sP') . '</responseDate></response></typ:sendMessageResponse></soap:Body></soap:Envelope>';
    }

    public static function getSoapAsyncResponse($sCorrelationId)
    {
        return '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/"><soapenv:Body><typ:sendMessageResponse xmlns:typ="http://bip.bee.kz/AsyncChannel/v10/Types"><response><messageId>' . Uuid::generateV4() . '</messageId><correlationId>' . $sCorrelationId . '</correlationId><responseDate>' . date('Y-m-d').'T'. date('H:i:sP') . '</responseDate></response></typ:sendMessageResponse></soapenv:Body></soapenv:Envelope>';
    }
}
