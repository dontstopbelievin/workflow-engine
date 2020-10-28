<?php

namespace shep\receiver\services;


class ServiceAsyncApostilPEPStrategy extends \shep\receiver\DocumentCreator implements \shep\receiver\ShepServiceStrategyInterface
{
    private $sApostilleApplicationDoctypeId = '950fff8d-b9a4-4920-8fff-5285deb002c8';
    private $aMap = array(
        '950fff8d-b9a4-4920-8fff-5285deb002c8' => array(
            'applicant' => array(
                'type' => 'complex',
                'value' => array(
                    'surname' => array(
                        'value' => 'f_a1f3ac6',
                        'type' => 'string'
                    ),
                    'name' => array(
                        'value' => 'f_a1e1636',
                        'type' => 'string'
                    ),
                    'patronymic' => array(
                        'value' => 'f_310ec29',
                        'type' => 'string'
                    ),
                    'iin' => array(
                        'value' => 'f_61d605e',
                        'type' => 'string'
                    ),
                    'address' => array(
                        'value' => 'f_e11399d',
                        'type' => 'string'
                    ),
                    'region' => array(
                        'value' => 'f_510e530',
                        'type' => 'reference',
                        'reference_id' => 'f4cd4e4a-a458-4718-b421-5c872f620044',
                        'primary_key' => 'f_display_name',
                        'display_name_field' => 'f_display_name'
                    ),
                    'document' => array(
                        'type' => 'complex',
                        'value' => array(
                            'document_type' => array(
                                'value' => 'f_514469c',
                                'type' => 'enumeration'
                            ),
                            'number' => array(
                                'value' => 'f_b19d4f6',
                                'type' => 'string'
                            ),
                            'date_of_issue' => array(
                                'value' => 'f_d10d5cd',
                                'type' => 'date'
                            ),
                            'authority' => array(
                                'value' => 'f_610f26e',
                                'type' => 'enumeration'
                            )
                        )
                    ),
                    'phone_number' => array(
                        'value' => 'f_116f164',
                        'type' => 'string'
                    ),
                    'email' => array(
                        'value' => 'f_f1abdba',
                        'type' => 'string'
                    )
                )
            ),
            'document_to_apostille' => array(
                'type' => 'complex',
                'value' => array(
                    'document_type' => array(
                        'value' => 'f_a1a0501',
                        'type' => 'reference',
                        'reference_id' => '967717dd-56cb-4b0e-a0df-524d31f7025f',
                        'primary_key' => 'f_code',
                        'display_name_field' => 'f_display_name'
                    ),
                    'document_owner_fio' => array(
                        'value' => 'f_b1a8600',
                        'type' => 'string'
                    ),
                    'date_of_issue' => array(
                        'value' => 'f_514e3c7',
                        'type' => 'date'
                    ),
                    'number' => array(
                        'value' => 'f_61ba32d',
                        'type' => 'string'
                    ),
                    'authority' => array(
                        'value' => 'f_c16d407',
                        'type' => 'string'
                    ),
                    'authority_region' => array(
                        'value' => 'f_314cbb7',
                        'type' => 'reference',
                        'reference_id' => 'f4cd4e4a-a458-4718-b421-5c872f620044',
                        'primary_key' => 'f_code',
                        'display_name_field' => 'f_display_name'
                    ),
                    'signer' => array(
                        'type' => 'complex',
                        'value' => array(
                            'surname' => array(
                                'value' => 'f_01c3f2a',
                                'type' => 'string'
                            ),
                            'name' => array(
                                'value' => 'f_918439c',
                                'type' => 'string'
                            ),
                            'patronymic' => array(
                                'value' => 'f_21ac5ca',
                                'type' => 'string'
                            ),
                            'post' => array(
                                'value' => 'f_51877ae',
                                'type' => 'reference',
                                'reference_id' => '04ac0389-017b-416b-af63-5c908c1b0349',
                                'primary_key' => 'f_code',
                                'display_name_field' => 'f_display_name'
                            ),
                        )
                    ),
                    'country_to_send' => array(
                        'value' => 'f_2125260',
                        'type' => 'reference',
                        'reference_id' => '7d64c868-09d8-11e1-8fe1-0030487e5776',
                        'primary_key' => 'f_code',
                        'display_name_field' => 'f_display_name'
                    ),
                    'file' => array(
                        'value' => 'f_d180879',
                        'type' => 'file'
                    )
                )
            ),
            'related_documents_to_apostille' => array(
                'value' => 'f_513abc0',
                'type' => 'file'
            ),
            'payment' => array(
                'type' => 'complex',
                'value' => array(
                    'file' => array(
                        'value' => 'f_513abc0',
                        'type' => 'file'
                    ),
                    'number' => array(
                        'value' => 'f_6150490',
                        'type' => 'string'
                    ),
                    'date' => array(
                        'value' => 'f_a1f74da',
                        'type' => 'date'
                    ),
                    'amount' => array(
                        'value' => 'f_1133424',
                        'type' => 'string'
                    )
                )
            ),
            'application_eds' => array(
                'task' => 't_a1378d2',
                'type' => 'eds'
            )
        )
    );
    public function __construct($sDocumentType)
    {
        parent::__construct($sDocumentType);
    }

    public function receive(array $aArguments)
    {
        $aInfo = $aArguments['request']['messageInfo'];
        $aData = a($aArguments['request']['messageData'], 'data', array());
        switch (key($aData)) {
            case 'ApostilleApplication':
                $aData = current($aData);
                $oDoctype = new \app\workflow\doctype\Doctype($this->sApostilleApplicationDoctypeId);
                if (!$oDoctype->isExisted()) {
                    throw new \Exception('Не найден тип документа');
                }
                $oDoctype->load();
                $oDocument = $oDoctype->getDocument();
                $oDocument->blank();

                $oDocument = $this->mapDocumentFields($oDoctype, $oDocument, $aData, $this->aMap);
                if ($this->routeDocument($oDoctype, $oDocument)) {
                    return \app\tsoed\ShepXmlUtil::getSoapAsyncResponse($aInfo['correlationId']);
                } else {
                    throw new \Exception('Невалидный документ');
                }
                break;
            default:
                throw new \Exception('Не найден запрашиваемый метод');
        }
    }
}