<?php

namespace App\Integrations\shep\sender;

interface XmlBuilderInterface
{
    public function buildXml(array $aArguments);
}
