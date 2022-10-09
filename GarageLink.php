<?php

namespace ORC\Garage;

use ORC\Garage\Acat\AcatSelectQuery,
    ORC\Garage\Tools;

class GarageLink
{
    private static $acatQuery;

    const ACAT_BASE_LINK = '/acat';

    public static function getAutoCatalogLink($typeAuto, $acatmodelId = '', $acatmarkId) {
        $acatQuery = new AcatSelectQuery();
        $link = self::ACAT_BASE_LINK;
        $html = '.html';
        if (empty($acatmarkId) && empty($acatmodelId) && empty($typeAuto)) {
            return $link;
        }
        if ($acatmodelId !== '') {
            $typeId = Tools::getAutotypeId($typeAuto);
            $markHRU = $acatQuery->getUrlPartById('marks', $acatmarkId);
            $modelHRU = $acatQuery->getUrlPartById('models', $acatmodelId);
            $cat = Tools::getAcatAutotypeValue($typeId);
            if ($modelHRU["hru"] !== false && $markHRU["hru"] !== false && $cat !== false) {
                $link .= '/' . $cat . '/' . $markHRU['hru'] . '/' . $modelHRU['hru'] .$html;
            }elseif($modelHRU['hru'] == false && $markHRU['hru'] !== false && $cat !== false) {
                $link .= '/'. $cat .'/' .$markHRU['hru'] . $html;
            }elseif($cat !== false){
                $link .= '/' . $cat .$html;
            }else{
                $link .= '/';
            }
        }else{
            $link .= '/';
        }
        return $link;
    }

    public static function getArticleLinkByMark($mark, $model = '', $arMarks = array()) {
        $groupBy = false;
        $link = '/press/articles/';
        if (!empty($model) || !empty($mark)) {
            if (!empty($mark) && !empty($arMarks)) {
                if (in_array($mark, $arMarks)) {
                    $link .= 'search/index.php?tags=' .$mark;
                }
            }
        }
        return $link;
    }
}