<?php

namespace App\Integrations\shep\sender\services;


class EdsTempFilesService extends ShepService implements \App\Integrations\shep\sender\XmlBuilderInterface
{
    const SERVICE_TYPE = 'sync';
    const SERVICE_ID = 'EDS_TEMP_FILES';

    public function __construct($sShepUrl = null)
    {
        parent::__construct(self::SERVICE_TYPE, $sShepUrl);
    }

    public function buildXml(array $aArguments)
    {
        //TODO: use real data from $aArguments param
        include_once app_path('Integrations/shep/arrays/eds-temp-files.php');
        $sUnsignedXml = ShepUtil::arrayToXML($aData);
        $sRequestXml = ShepXmlUtil::getSoapRequest(self::SERVICE_ID, $sUnsignedXml);
        
        return $sRequestXml;
    }
}
