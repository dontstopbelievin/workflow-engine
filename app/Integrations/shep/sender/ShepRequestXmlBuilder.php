<?php

namespace App\Integrations\shep\sender;

class ShepRequestXmlBuilder
{
    /**
     * @var XmlBuilderInterface
     */
    private $oShepSendRequestStrategy;

    public function __construct(XmlBuilderInterface $oShepSendRequestStrategy)
    {
        $this->oShepSendRequestStrategy = $oShepSendRequestStrategy;
    }

    public function build(array $aArguments)
    {
        return $this->oShepSendRequestStrategy->buildXml($aArguments);
    }
}
