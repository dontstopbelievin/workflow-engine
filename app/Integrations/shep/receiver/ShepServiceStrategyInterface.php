<?php
/**
 * Created by PhpStorm.
 * User: a.aitymov
 * Date: 29.05.2019
 * Time: 18:21
 */

namespace shep\receiver;

interface ShepServiceStrategyInterface
{
    public function receive(array $aArguments);
}