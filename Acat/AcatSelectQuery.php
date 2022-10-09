<?php

namespace ORC\Garage\Acat;

use ORC\Garage\Tools;
use ORC\Garage\Config;
use ORC\Acat\Tools as AcatTools;

class AcatSelectQuery extends \ORC\Acat\Config
{
    private $connection;

    public function __construct()
    {
        $this->connection = parent::getConn();
    }

    public function getAcatCategories()
    {
        $categories = array();
        $res = $this->connection->query("SELECT * from typeauto WHERE ID IN ('2','3','4','5') ");
        while ($row = $res->fetch_array()) {
            $categories[] = $row;
       }
       return $categories;
    }

    public function getYears() {
        $years = array();
        $res = $this->connection->query("SELECT DISTINCT ACTUAL FROM models WHERE ACTUAL <> '' ORDER BY ACTUAL DESC");
        if ($res) {
            while ($row = $res->fetch_array()) {
                $years[] = $row["ACTUAL"];
            }
            $arYears = Tools::validate($years);
            return $arYears;
        }
    }

    public function getUrlPartById($table, $id) {
        $result = [];
        if ($table == 'models') {
            $query = "SELECT hru, typeauto FROM $table WHERE ID = '{$id}'";
        }else{
            $query = "SELECT hru FROM $table WHERE ID = '{$id}'";
        }
        $res = $this->connection->query($query);
        if ($res) {
            $row = $res->fetch_array();
            $result['hru'] =  isset($row['hru']) ? $row['hru'] : false;
            return $result;
        }
        return false;
    }

    public function getAcatMarks() {
        $marks = array();
        $res = $this->connection->query("SELECT ID, NAMESHORT FROM marks ORDER BY NAMESHORT");
        while ($row = $res->fetch_array()) {
            $marks[] = array(
                "ID" => $row["ID"],
                "NAME" => $row["NAMESHORT"],
            );
        }
        return $marks;
    }

    public function getAcatImage($id) {
        $res = $this->connection->query("SELECT PATHICON FROM models WHERE ID = '{$id}'");
        if ($res){
            $row = $res->fetch_array();
            $exploded = explode('.', $row["PATHICON"]);
            $exploded[1] = "png";
            if (!empty($exploded[0])) {
                $regExp = "/[А-Яа-яЁё]/iu";
                if (preg_match($regExp, $exploded[0])) {
                    return mb_strtolower(trim(AcatTools::lat_translate($exploded[0]) . '.' .$exploded[1]));
                }
                return mb_strtolower(trim($exploded[0] . '.' .$exploded[1]));
            }else{
                return false;
            }
        }
    }

    public function getAcatSearchModelsResults($searchString, $year = '', $mark = '', $type = '') {
        $query = "SELECT * FROM models";
        $query .= " LEFT JOIN s_models ON  s_models.idmodel = models.ID";
        $query .= " WHERE NAMESHORT LIKE '{$searchString}%'";
        if ($type == '' && $mark == '' && $year == '') {
            $query .= " AND idtypeauto in ('2','3','4','5')";
        }
        if ($year !== '') { $query .= " AND ACTUAL = '{$year}'"; }
        if ($mark !== '') { $query .= " AND IDMARK = {$mark}"; }
        if ($type !== '') { $query .= " AND TYPEAUTO = {$type}"; }
        $query .= " ORDER BY NAMESHORT";
        $query .= " LIMIT 10";
        $res = $this->connection->query($query);
        $arAcatItems = [];
        if ($res){
            while ($row = $res->fetch_array()) {
                    $arAcatItems[] = array(
                        "ID" => $row["ID"],
                        "NAME" => $row["NAMESHORT"],
                        "TYPEAUTO" => $row["idtypeauto"],
                        "IDMARK" => $row["IDMARK"],
                        "ACTUAL" => isset($row["ACTUAL"]) ? trim(preg_replace("/[^0-9]/", '', $row["ACTUAL"])) : '',
                    );
            }
            $temp = [];
           foreach ($arAcatItems as &$value) {
               if (!isset($temp[$value["NAME"]])) {
                   $temp[$value["NAME"]] =& $value;
               }
           }
           $arAcatItems = array_values($temp);
        }
        return $arAcatItems;
    }
}