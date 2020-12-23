<?php

namespace shep\receiver\services;


class ServiceSyncApostilPEPStrategy implements \shep\receiver\ShepServiceStrategyInterface
{
    private $aMap = array(
        'countries' => '7d64c868-09d8-11e1-8fe1-0030487e5776',
        'regions' => 'f4cd4e4a-a458-4718-b421-5c872f620044',
        'notary_signer_posts' => '04ac0389-017b-416b-af63-5c908c1b0349',
        'document_types' => '967717dd-56cb-4b0e-a0df-524d31f7025f'
    );
    private $aReferenceInfo = array(
        '7d64c868-09d8-11e1-8fe1-0030487e5776' => array(
            'map' => array(
                'code' => 'f_code',
                'name' => array(
                    'ru' => 'f_display_name',
                    'kz' => 'f_display_name_kz'
                )
            )
        ),
        'f4cd4e4a-a458-4718-b421-5c872f620044' => array(
            'map' => array(
                'code' => 'f_code',
                'name' => array(
                    'ru' => 'f_display_name',
                    'kz' => 'f_display_name_kz'
                )
            )
        ),
        '04ac0389-017b-416b-af63-5c908c1b0349' => array(
            'map' => array(
                'code' => 'f_code',
                'name' => array(
                    'ru' => 'f_display_name',
                    'kz' => 'f_display_name_kz'
                )
            )
        ),
        '967717dd-56cb-4b0e-a0df-524d31f7025f' => array(
            'map' => array(
                'code' => 'f_code',
                'name' => array(
                    'ru' => 'f_display_name',
                    'kz' => 'f_display_name_kz'
                )
            )
        )
    );

    private $sDocumentType = '';

    public function __construct($sDocumentType)
    {
        $this->sDocumentType = $sDocumentType;
    }

    public function receive(array $aArguments)
    {
        $aData = a($aArguments['request']['requestData'], 'data', array());
        $aResult = array();
        switch (key($aData)) {
            case 'GetDictionaryRecords':
                $aData = current($aData);
                if (!isset($aData['referenceName'])) {
                    throw new \Exception('в запросе отсуствует referenceName');
                }
                if (!isset($aData['language'])) {
                    $sLang = 'ru';
                } else {
                    $sLang = $aData['language'];
                }
                if (!empty($aData['referenceName']) && array_key_exists(trim($aData['referenceName']), $this->aMap)) {
                    $sRefId = $this->aMap[trim($aData['referenceName'])];
                    $sCondition = '1=1';
                    if (isset($aData['request']) && !empty($aData['request'])) {
                        $sRecordName = htmlspecialchars(trim($aData['request']));
                        $sRecordName = mb_strtolower($sRecordName);
                        $sField = $sLang === "ru" ? "f_display_name" : "f_display_name_kz";
                        $sCondition = "LOWER(" . $sField . ") LIKE '%" . $sRecordName . "%'";
                    }
                    $aReferenceRecords = \app\reference\Util::getReferenceRecordsByCondition($sRefId, $sCondition);
                    foreach ($aReferenceRecords as $sRowId => $aV) {
                        $aRecord = array();
                        foreach ($this->aReferenceInfo[$sRefId]['map'] as $sOuterField => $mDocumentField) {
                            if (is_array($mDocumentField)) {
                                $aRecord[$sOuterField] = $aV[$mDocumentField[$sLang]];
                            } else {
                                $aRecord[$sOuterField] = $aV[$mDocumentField];
                            }
                        }
                        $aResult['GetDictionaryResponse'][]['record'] = $aRecord;
                    }
                    return \app\tsoed\ShepXmlUtil::getSoapResponse(1, 'success', \app\tsoed\ShepUtil::arrayToXML($aResult));
                } else {
                    throw new \Exception('Справочник не найден');
                }
            default:
                throw new \Exception('Не найден запрашиваемый метод');
        }
    }
}