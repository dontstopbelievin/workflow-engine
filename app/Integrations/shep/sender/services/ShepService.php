<?php

namespace App\Integrations\shep\sender\services;


abstract class ShepService
{
    public $sShepUrl = '';

    public function __construct($sServiceType, $sShepUrl = null)
    {
        if ($sShepUrl !== null) {
            $this->sShepUrl = $sShepUrl;
        } elseif ($sServiceType == 'sync') {
            $this->sShepUrl = config('shep.sync_url');
        } elseif ($sServiceType == 'async') {
            $this->sShepUrl = config('shep.async_url');
        }
    }
}
