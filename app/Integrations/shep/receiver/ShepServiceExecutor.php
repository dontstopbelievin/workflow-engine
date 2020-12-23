<?php

namespace App\Integrations\shep\receiver;


class ShepServiceExecutor
{
    /**
     * @var ShepServiceStrategyInterface
     */
    private $oShepServiceStrategy;

    public function __construct(ShepServiceStrategyInterface $oShepServiceStrategy)
    {
        $this->oShepServiceStrategy = $oShepServiceStrategy;
    }

    public function execute()
    {
        return $this->oShepServiceStrategy->receive();
    }
}
