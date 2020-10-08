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

    }
}
