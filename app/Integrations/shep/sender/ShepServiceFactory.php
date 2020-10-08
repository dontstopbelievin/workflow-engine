<?php

namespace App\Integrations\shep\sender;

use App\Integrations\shep\sender\services\EdsTempFilesService;
use App\Integrations\shep\sender\services\EgknUniversalReceiveOrderService;
use App\Integrations\shep\sender\services\EgknUniversalReceiveStatusService;
use App\Integrations\shep\sender\services\GeoportalEgknReceiveLayerService;

class ShepServiceFactory
{
    public static function create($sServiceName)
    {
        switch ($sServiceName) {
            case 'egkn_receive_status':
                return new EgknUniversalReceiveStatusService();
            case 'egkn_receive_order':
                return new EgknUniversalReceiveOrderService();
            case 'geoportal_egkn_receive_layer':
                return new GeoportalEgknReceiveLayerService();
            case 'eds_temp_files':
                return new EdsTempFilesService();
            default:
                throw new \Exception('Не найден сервис ' . $sServiceName);
        }
    }
}
