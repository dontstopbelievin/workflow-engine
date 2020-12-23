<?php

namespace shep\receiver;


abstract class DocumentCreator
{
    protected $sDocumentType;

    public function __construct($sDocumentType)
    {
        $this->sDocumentType = $sDocumentType;
    }

    protected function mapDocumentFields(\app\workflow\doctype\Doctype $oDoctype, \app\workflow\document\Document $oDocument, $aArguments, $aMap)
    {
        foreach ($aMap[$oDoctype['id']] as $sOuterFieldId => $aField) {
            if (isset($aArguments[$sOuterFieldId])) {
                switch ($aField['type']) {
                    case 'complex':
                        $oDocument = $this->mapDocumentFields($oDoctype, $oDocument, $aArguments[$sOuterFieldId], array($oDoctype['id'] => $aField['value']));
                        break;
                    case 'string':
                    case 'date':
                    case 'timestamp':
                        $oDocument[$aField['value']] = $aArguments[$sOuterFieldId];
                        break;
                    case 'file':
                        if (!empty($aArguments[$sOuterFieldId]['base64'])) {
                            $oFile = new \app\media\File();
                            $sFileName = 'document';
                            $sFileExtension = '';
                            if (isset($aArguments[$sOuterFieldId]['name'])) {
                                $sFileName = $aArguments[$sOuterFieldId]['name'];
                            }
                            if (isset($aArguments[$sOuterFieldId]['extension'])) {
                                $sFileExtension = '.' . $aArguments[$sOuterFieldId]['extension'];
                            }
                            $oFile->blankNameAndBase64AndMsfId($sFileName . $sFileExtension, $aArguments[$sOuterFieldId]['base64'], 'workflow' . ':' . $oDoctype['id'] . ':' . $oDocument['id']);
                            if ($oFile->isValid()) {
                                $oFile->save();
                            } else {
                                return 'Files error';
                            }
                            $oFile->deleteTmpFile();
                            $oDocument[$aField['value']] = array_merge($oDocument[$aField['value']], array($oFile['id'] => $oFile['name']));
                        }
                        break;
                    case 'reference':
                        $oDocument[$aField['value']] = \app\reference\Util::getReferenceByCode($aField['reference_id'], $aArguments[$sOuterFieldId], $aField['primary_key'], $aField['display_name_field']);
                        break;
                    case 'document':
                        $oDocument[$aField['value']] = \app\workflow\util\Util::getDocumentValueById($aField['doctype_id'], $aArguments[$sOuterFieldId]);
                        break;
                    case 'eds':
                        if (!empty($aArguments[$sOuterFieldId])) {
                            $oDocument['decision'] = \app\esedo\UtilModel::addNutsDecision($oDoctype['tasks'], $oDocument['decision'], $aField['task'], $aArguments[$sOuterFieldId], $oDocument->getFields());
                        }
                        break;
                    case 'enumeration':
                        $aFields = $oDoctype->getFields();
                        $aEnumValues = $aFields[$aField['value']]['values'];
                        $aFlippedEnumValues = array_flip($aEnumValues);
                        $sKey = $aFlippedEnumValues[$aArguments[$sOuterFieldId]];
                        $oDocument[$aField['value']] = array($sKey => $aArguments[$sOuterFieldId]);
                        break;
                }
            }
        }
        return $oDocument;
    }

    protected function routeDocument($oDoctype, \app\workflow\document\Document $oDocument)
    {
        if ($oDocument->isValid()) {
            $oR = new \app\workflow\document\Router($oDoctype, $oDocument);
            $oR->move(0);
            $oR->route();
            $oDocument->save();
            return true;
        }
        return false;
    }
}