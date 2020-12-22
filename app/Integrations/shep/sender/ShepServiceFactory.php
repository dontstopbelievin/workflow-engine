<?php

namespace App\Integrations\shep\sender;

use App\Integrations\shep\sender\services\AisGzkGetDataService;
use App\Integrations\shep\sender\services\AisGzkGetRelevanceService;
use App\Integrations\shep\sender\services\EdsTempFilesService;
use App\Integrations\shep\sender\services\EgknUniversalReceiveOrderService;
use App\Integrations\shep\sender\services\EgknUniversalReceiveStatusService;
use App\Integrations\shep\sender\services\GeoportalEgknReceiveLayerService;
use App\Integrations\shep\sender\services\EgknGeoportalActualizationService;
use App\Integrations\shep\sender\services\GeoportalPEPAsyncService;

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
            case 'egkn_geoportal_actualization':
                return new EgknGeoportalActualizationService();
            case 'eds_temp_files':
                return new EdsTempFilesService();
            case 'geoportal_pep_async':
                return new GeoportalPEPAsyncService();
            case 'ais_gzk_get_data':
                return new AisGzkGetDataService();
            case 'ais_gzk_get_relevance':
                return new AisGzkGetRelevanceService();
            default:
                throw new \Exception('Не найден сервис ' . $sServiceName);
        }
    }
}
