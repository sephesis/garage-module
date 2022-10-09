<?php

namespace ORC\Garage\IblockHelper;

use ORC\Garage\Config;
use Bitrix\Main\UI\PageNavigation;


class IblockHelper
{
    const DEFAULT_PAGE_SIZE = 15;
    
    public static function deleteIBlockElement($id) {
        if (!\CIBlockElement::Delete($id)) {
            return false;
        } else {
            return true;
        }
    }

    public static function updateProps($arFilter = [], $arProps = [], $iblockId) {
        $arSelect = ['ID'];
        $arOrder = array("SORT" => "ASC");
        $rsElement = \CIBlockElement::GetList($arOrder, $arFilter, false, false, $arSelect);
        if ($arElement = $rsElement->fetch()) {
            foreach ($arProps as $code => $value) {
                \CIBlockElement::SetPropertyValues(intval($arElement["ID"]), $iblockId, $value, $code);
            }
            return true;
        }
        return false;
    }

    public static function getIblockElements($arSelect, $fields, $groupByUser = false, $pagination = false) {
        $res = [];
        $default = [
            'ACTIVE' => 'Y',
            'IBLOCK_ID' => Config::GARAGE_IBLOCK,
        ];
        if ($pagination) {
            $nav = new PageNavigation('garage_stat');
            $total = self::getTotal(Config::GARAGE_IBLOCK);
            $nav->allowAllRecords(true)->setPageSize(self::DEFAULT_PAGE_SIZE)->initFromUri();
            $nav->setRecordCount($total);
            $limit = $nav->getLimit();
            $offset = $nav->getOffset();
            $arNavStartParams = [
                'iNumPage' => intval($offset/$limit+1), 
                'nPageSize' => $nav->getPageSize(),
                'checkOutOfRange' => false
            ];
        }else{
            $arNavStartParams = false;
        }
        $arFilter = array_merge($default, $fields);
        $arOrder = array("SORT" => "ASC");
        $rsElement = \CIBlockElement::GetList($arOrder, $arFilter, false, $arNavStartParams, $arSelect);
        while ($arElement = $rsElement->fetch()) {
            if ($groupByUser) {
                $res[$arElement['PROPERTY_USER_VALUE']][] = $arElement;
            }else{
                $res[] = $arElement;
            }
        }
        $result['nav'] = $pagination ? $nav : [];
        $result['result'] = $res;
        return  $result;
    }

    public static function getTotal($id) {
        $arFilter = array("IBLOCK_ID"=>$id, "ACTIVE"=>"Y");
        return (int) \CIBlockElement::GetList(array(), $arFilter, array(), false, array());
    }

    public static function addIblockElement($iblockId, $arFields) {
        $rsElement = new \CIBlockElement;
        $arDefault = array(
            'IBLOCK_ID' => $iblockId,
            'ACTIVE' => 'Y',
            "IBLOCK_SECTION_ID" => false,
            "ACTIVE_FORM" => date('d.m.Y H:i:s'),
        );
        if (isset($arFields)) {
            if(!$id = $rsElement->Add(array_merge($arFields, $arDefault))) {
                return false;
            }else{
                return true;
            }
        }
        return false;
    }

}