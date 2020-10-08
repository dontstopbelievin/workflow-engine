<?php

namespace shep\receiver;


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

    public function execute(array $aArguments)
    {
        return $this->oShepServiceStrategy->receive($aArguments);
    }
}