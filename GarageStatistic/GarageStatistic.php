<?php

namespace ORC\Garage\GarageStatistic;

use ORC\Garage\Config;
use ORC\Garage\IblockHelper\IblockHelper;
use ORC\Garage\UserHelper\UserHelper;
use Bitrix\Main\UI\PageNavigation;

class GarageStatistic
{
    public static function getSearchList($params = array()) 
    {
        $fields = [];
        if (isset($_GET['default_settings'])) {
            $url = explode('?', $_SERVER['REQUEST_URI']);
            LocalRedirect($url[0]);
        }
        if (!empty($params) && isset($_GET['apply_garage_search'])) {
            if (isset($params['search_by_model']) && isset($params['search'])) {
                $fields['NAME'] = strtoupper($params['search']) . '%';
            }
            if (isset($params['search_by_user']) && isset($params['search'])) {
                $arFilter = [ "LOGIN" => $params['search'] . "%",];
                $userIds = UserHelper::getList($arFilter, true);
                if (!empty($userIds)) {
                    $fields['PROPERTY_USER'] = $userIds;
                }
            }
            if (isset($params['acat_cats']) && $params['acat_cats'] !== 'default_val_cat') {
                switch($params['acat_cats']) {
                    case '2': $typeauto = '262'; break;
                    case '3': $typeauto = '263'; break;
                    case '4': $typeauto = '264'; break;
                    case '5': $typeauto = '265'; break;
                }
                $fields['PROPERTY_TYPEAUTO'] = $typeauto;
            }
            if (isset($params['acat_years']) && $params['acat_years'] !== 'default_val_year') {
                $fields['PROPERTY_YEAR'] = $params['acat_years'];
            }
            if (isset($params['acat_marks']) && $params['acat_marks'] !== 'default_val_mark') {
                $fields['PROPERTY_MARK'] = $params['acat_marks'];
            }
        }
        $arSelect = [
            "ID",
            "NAME",
            'DATE_CREATE',
            'PROPERTY_USER',
            'PROPERTY_CHASSI',
            'PROPERTY_VIN',
            'PROPERTY_MARK',
            'PROPERTY_TYPEAUTO',
            'PROPERTY_YEAR',
            'PROPERTY_DRIVER_NAME',
            'PROPERTY_DRIVER_SURNAME',
            'PROPERTY_DRIVER_SECOND_NAME'
        ];

        $arOrder = [];


        $arInfo = IblockHelper::getIblockElements($arSelect, $fields, true, true);
      
        return $arInfo;
    }

}