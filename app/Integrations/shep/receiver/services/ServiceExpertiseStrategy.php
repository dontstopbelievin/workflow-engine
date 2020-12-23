<?php

namespace shep\receiver\services;

class ServiceExpertiseStrategy extends \shep\receiver\DocumentCreator implements \shep\receiver\ShepServiceStrategyInterface
{
    private $sIngoingDoctypeId = '9a21cb85-660d-464b-b6ad-5b5563e6003c';
    private $sExpertiseTypesDoctypeId = '98269d17-c7d7-454a-a84e-5b5567190070';
    private $sOrganizationsDoctypeId = '00000000-0000-0000-0000-000000000004';
    private $aReferenceInfo = array(
        '98269d17-c7d7-454a-a84e-5b5567190070' => array(
            'primary_key' => 'f_code_2',
            'record_name' => 'ExpertiseTypes',
            'map' => array(
                'f_code' => 'code',
                'f_code_2' => 'code_2',
                'f_name_ru' => 'name_ru',
                'f_name_kz' => 'name_kz',
                'f_name_specialty_ru' => 'name_specialty_ru',
                'f_name_specialty_kz' => 'name_specialty_kz'
            )
        ),
        '00000000-0000-0000-0000-000000000004' => array(
            'primary_key' => 'index',
            'record_name' => 'ForensicAuthorities',
            'map' => array(
                'index' => 'code',
                'display_name' => 'name_ru',
                'display_name_kz' => 'name_kz',
                'f_region_code' => 'region_code',
                'f_region_ru' => 'region_ru',
                'f_region_kz' => 'region_kz'
            )
        )
    );
    private $aDoctypeFieldsMap = array(
        '9a21cb85-660d-464b-b6ad-5b5563e6003c' => array(
            'outgoing_number' => array(
                'value' => 'f_719abfc',
                'type' => 'string'
            ),
            'region' => array(
                'value' => 'f_11141e9',
                'type' => 'reference',
                'reference_id' => '44428a93-d3bb-4b65-8379-5c9cc77700b4',
                'primary_key' => 'f_d1f3642',
                'display_name_field' => 'f_41a1107'
            ),
            'forensic_authority' => array(
                'value' => 'f_2172929',
                'type' => 'reference',
                'reference_id' => '00000000-0000-0000-0000-000000000004',
                'primary_key' => 'index',
                'display_name_field' => 'display_name'
            ),
            'forensic_authority_id' => array(
                'value' => 'f_f12c1fd',
                'type' => 'string'
            ),
            'created_at' => array(
                'value' => 'f_create_date',
                'type' => 'timestamp'
            ),
            'court' => array(
                'value' => 'f_9182879',
                'type' => 'reference',
                'reference_id' => '20fb3df5-c56f-48ea-8bdc-5c9e00a102e9',
                'primary_key' => 'f_7169e45',
                'display_name_field' => 'f_c14ef10'
            ),
            'judge_fullname' => array(
                'value' => 'f_name_of_the_judge',
                'type' => 'string'
            ),
            'case_number' => array(
                'value' => 'f_7134dfd',
                'type' => 'string'
            ),
            'proceedings_type' => array(
                'value' => 'f_proceeding_type',
                'type' => 'string'
            ),
            'forensic_order' => array(
                'value' => 'f_d180879',
                'type' => 'file'
            ),
            'forensic_order_eds' => array(
                'task' => 't_a1378d2',
                'type' => 'eds'
            ),
            'judicial_act_date' => array(
                'value' => 'f_date_of_judicial_act',
                'type' => 'date'
            ),
            'send_type' => array(
                'value' => 'f_send_type',
                'type' => 'string',
            ),
            'related_materials_in_electronic_form' => array(
                'value' => 'f_d180879',
                'type' => 'file'
            ),
            'description_of_related_materials' => array(
                'value' => 'f_number_of_sheets',
                'type' => 'string'
            ),
            'expertise_complexity' => array(
                'value' => 'f_expertise_complexity',
                'type' => 'reference',
                'reference_id' => '1b5226de-749c-442f-8ab3-5b56bbca0042',
                'primary_key' => 'f_code',
                'display_name_field' => 'f_display_name'
            ),
            'expertise_mode' => array(
                'value' => 'f_a11978f',
                'type' => 'reference',
                'reference_id' => '98269d17-c7d7-454a-a84e-5b5567190070',
                'primary_key' => 'f_code_2',
                'display_name_field' => 'f_name_ru'
            ),
            'expertise_type' => array(
                'value' => 'f_7151ec9',
                'type' => 'reference',
                'reference_id' => 'ffc0339c-ab86-4d22-bfcb-5b556a2700b0',
                'primary_key' => 'f_code',
                'display_name_field' => 'f_display_name'
            ),
            'forensic_expert_conclusion' => array(
                'value' => 'f_d180879',
                'type' => 'file'
            ),
            'forensic_expert_conclusion_id' => array(
                'value' => 'f_0146166',
                'type' => 'string'
            ),
            'forensic_expert_conclusion_date' => array(
                'value' => 'f_conclusion_date',
                'type' => 'date'
            ),
            'request_text' => array(
                'value' => 'f_request_text',
                'type' => 'string'
            ),
            'answer_outgoing_number' => array(
                'value' => 'f_answer_outgoing_number',
                'type' => 'string'
            ),
            'ingoing_number_petition' => array(
                'value' => 'f_ingoing_number_petition',
                'type' => 'string'
            ),
            'sender_name' => array(
                'value' => 'f_sender_name',
                'type' => 'string'
            ),
            'answer_text' => array(
                'value' => 'f_answer_text',
                'type' => 'string'
            ),
            'expertise_appointment_doc' => array(
                'value' => 'f_expertise_appointment_doc',
                'type' => 'document',
                'doctype_id' => '9a21cb85-660d-464b-b6ad-5b5563e6003c'
            ),
            'covering_letter' => array(
                'value' => 'f_d180879',
                'type' => 'file'
            ),
            'sender_eds' => array(
                'task' => 't_a1378d2',
                'type' => 'eds'
            ),
            'erdr_number' => array(
                'value' => 'f_e108943',
                'type' => 'string'
            ),
            'eud_forensic_order_id' => array(
                'value' => 'f_51e040f',
                'type' => 'string'
            ),
            'one_object_system_id' => array(
                'value' => 'f_61bdd65',
                'type' => 'string'
            ),
            'one_code' => array(
                'value' => 'f_9182879',
                'type' => 'reference',
                'reference_id' => '20fb3df5-c56f-48ea-8bdc-5c9e00a102e9',
                'primary_key' => 'f_7169e45',
                'display_name_field' => 'f_c14ef10'
            ),
            'one_name' => array(
                'value' => '',
                'type' => 'string'
            ),
            'forensic_authority_kato' => array(
                'value' => 'f_413a9ac',
                'type' => 'string'
            ),
            'fabula' => array(
                'value' => 'f_8164b93',
                'type' => 'string'
            ),
            'forensic_order_date' => array(
                'value' => 'f_c1030b6',
                'type' => 'date'
            ),
            'involved_specialists' => array(
                'value' => 'f_813dab6',
                'type' => 'string'
            ),
            'questions' => array(
                'value' => 'f_61964a1',
                'type' => 'string'
            ),
            'data_send_date' => array(
                'value' => 'f_4166704',
                'type' => 'string'
            ),
            'data_send_status' => array(
                'value' => 'f_911fc72',
                'type' => 'date'
            ),
            'number_of_questions' => array(
                'value' => 'f_31c81bd',
                'type' => 'string'
            ),
            'category_of_case' => array(
                'value' => 'f_e1062c8',
                'type' => 'reference',
                'reference_id' => 'cec7af38-4b4c-4575-befe-5b56a2110334',
                'primary_key' => 'f_code',
                'display_name_field' => 'f_display_name'
            ),
            'article' => array(
                'value' => 'f_61be740',
                'type' => 'string'
            ),
            'part' => array(
                'value' => 'f_91d782e',
                'type' => 'string'
            ),
            'expertise_objects' => array(
                'value' => 'f_31d03fa',
                'type' => 'string'
            ),
            'user_id' => array(
                'value' => 'f_155fdf',
                'type' => 'string'
            ),
            'answer_send_date' => array(
                'value' => 'f_611f48f',
                'type' => 'date'
            )
        )
    );

    public function __construct($sDocumentType)
    {
        parent::__construct($sDocumentType);
        if ($this->sDocumentType == null) {
            return 'Undefined document type';
        }
    }

    public function receive(array $aArguments)
    {
        $aData = a($aArguments['request']['requestData'], 'data', array());
        $aResult = array();
        switch ($this->sDocumentType) {
            case 'ArrayOfExpertiseTypes':
                //$this->addReferenceRecord($this->sExpertiseTypesDoctypeId, $aData['ExpertiseTypes']);
                break;
            case 'GetDictionaryRecords':
                if (trim($aData['referenceName']) == 'expertiseTypes') {
                    $sDictionaryId = $this->sExpertiseTypesDoctypeId;
                } elseif ($aData['referenceName'] == 'organizations') {
                    $sDictionaryId = $this->sOrganizationsDoctypeId;
                } else {
                    return 'Dictionary not found!';
                }
                $aReferenceRecords = \app\reference\Util::getReferenceRecordsByCondition($sDictionaryId);
                foreach ($aReferenceRecords as $sRowId => $aV) {
                    $aRecord = array();
                    foreach ($this->aReferenceInfo[$sDictionaryId]['map'] as $sDocumentField => $sOuterField) {
                        $aRecord[$sOuterField] = $aV[$sDocumentField];
                    }
                    $aResult[$this->aReferenceInfo[$sDictionaryId]['record_name']][] = $aRecord;
                }
                return \app\tsoed\ShepXmlUtil::getSoapResponse(1, 'success', \app\tsoed\ShepUtil::arrayToXML($aResult));
                break;
            case 'ForensicOrder':
            case 'PetitionAnswer':
                $oDoctype = new \app\workflow\doctype\Doctype($this->sIngoingDoctypeId);
                if ($oDoctype->isExisted()) {
                    $oDoctype->load();
                    $oDocument = $oDoctype->getDocument();
                    $oDocument->blank();

                    //немного костыль
                    switch ($this->sDocumentType) {
                        case 'ForensicOrder':
                            $oDocument['f_f1f4daf'] = array('1' => 'Постановление/Определение');
                            break;
                        case 'PetitionAnswer':
                            $oDocument['f_f1f4daf'] = array('3' => 'Ответ на ходатайство');
                            break;
                    }

                    $oDocument = $this->mapDocumentFields($oDoctype, $oDocument, $aData, $this->aDoctypeFieldsMap);
                    if ($this->routeDocument($oDoctype, $oDocument)) {
                        $sStatus = 1;
                        $sMessage = 'success';
                    } else {
                        $sStatus = 0;
                        $sMessage = 'error';
                    }
                    return \app\tsoed\ShepXmlUtil::getSoapResponse($sStatus, $sMessage, \app\tsoed\ShepUtil::arrayToXML($aResult));
                }
                break;
            default:
                echo 'No type found';
                exit;
                break;
        }
    }
}