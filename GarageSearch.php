<?php
namespace ORC\Garage;

use ORC\Garage\Acat\AcatSelectQuery;
use ORC\Garage\Config as GarageConfig;

class GarageSearch
{
    public static function searchByModel($search, $year = '', $mark = '', $type = '') {
        $arAcatItems = $arInfoblockItems = array();
        $searchString = strtoupper(trim($search));
        $arAcatItems = (new AcatSelectQuery())->getAcatSearchModelsResults($searchString, $year, $mark, $type);
        $container = '<div style="position:absolute; z-index: 100;" class="search_result"><table class="unstriped">';
        if (count($arAcatItems) > 0) {
            foreach ($arAcatItems as $element) {
                $container .= '<tr><td style="font-weight:bold" class="search_result-name"><a data-year="'.$element['ACTUAL'].'" data-mark="'.$element['IDMARK'].'"  data-type="'.$element["TYPEAUTO"].'" data-id="'.$element['ID'].'" href="javascript:void();">';
                $container .= $element["NAME"];
                $container .= '</a></td></tr>';
            }
        }else{
            $container .= '<p class="search_result-name">По вашему запросу ничего не найдено. Добавьте <a data-year="" data-mark="" data-type="" data-id="" href="javascript:void();"> '. $searchString .' </a> вручную</p>';
        }
        $container .= '</table></div>';
        return $container;
    }

    public static function searchByVin($search) {
        $arInfo = [];
        $rsElement = \CIBlockElement::GetList(
            $arOrder  = array("SORT" => "ASC"),
            $arFilter = array(
                "ACTIVE"    => "Y",
                "IBLOCK_ID" => GarageConfig::GARAGE_IBLOCK,
                "=PROPERTY_VIN"    => $search,
            ),
            false,
            false,
            $arSelectFields = array("NAME", "PROPERTY_MARK", "PROPERTY_YEAR", "PROPERTY_CHASSI", "PROPERTY_TYPEAUTO")
        );
        if ($arElement = $rsElement->fetch()) {
            $arInfo = [
                "result" => true,
                "CHASSI" => $arElement["PROPERTY_CHASSI_VALUE"],
                "NAME" => $arElement["NAME"],
                "YEAR" => $arElement["PROPERTY_YEAR_VALUE"],
                "MARK" => $arElement["PROPERTY_MARK_VALUE"],
                "TYPEAUTO" => $arElement["PROPERTY_TYPEAUTO_VALUE"]
            ];
        }else{
            $arInfo = [
                "result" => false,
            ];
        }
        return $arInfo;
    }
   
}
