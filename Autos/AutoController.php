<?php

namespace ORC\Garage\Autos;

use ORC\Garage\Acat\AcatSelectQuery;
use ORC\Garage\IblockHelper\IblockHelper;
use ORC\Garage\Tools;
use ORC\Garage\Config as GarageConfig;

class AutoController
{
    private $userId;
    private $avto;

    public function __construct(Auto $avto = null, $userId = '') {
        $this->userId = $userId;
        $this->avto = $avto;
    }

    public function createNewAuto() {
        if (!empty($this->userId) && $this->avto !== null) {
            $arProps = array(
                "VIN" => $this->avto->getVin(),
                "TYPEAUTO" => $this->avto->getType(),
                "CHASSI" => $this->avto->getChassis(),
                "YEAR" => $this->avto->getYear(),
                "MARK" => $this->avto->getMark(),
                "USER" => $this->userId,
                "ACAT_ID" => $this->avto->getAcatId(),
                "DRIVER_NAME" => $this->avto->getDriverName(),
                "DRIVER_SURNAME" => $this->avto->getDriverSurname(),
                "DRIVER_SECOND_NAME" => $this->avto->getDriverSecondName(),
                "MARK_ACAT_ID" => $this->avto->getAcatMarkId(),
            );
            $arFields = array(
                "NAME"              => trim($this->avto->getModel()),
                "CODE"              => Tools::translit(trim($this->avto->getModel())),
                "MODIFIED_BY"       => $this->userId,
                "PROPERTY_VALUES"   => $arProps,
             );
            return IblockHelper::addIblockElement(GarageConfig::GARAGE_IBLOCK, $arFields);
        }
        return false;
    }

    public function updateAuto() {
        if ($this->avto !== null) {
            $arFilter = array(
                "ACTIVE"    => "Y",
                "IBLOCK_ID" => GarageConfig::GARAGE_IBLOCK,
                "ID" => intval($this->avto->getId()),
           );
           $arProps = array(
                "VIN" =>  $this->avto->getVin(),
                "CHASSI" => $this->avto->getChassis(),
                "YEAR" => $this->avto->getYear(),
                "DRIVER_NAME" => $this->avto->getDriverName(),
                "DRIVER_SURNAME" => $this->avto->getDriverSurname(),
                "TYPEAUTO" => $this->avto->getType(),
                "MARK" => $this->avto->getMark(),
                "MARK_ACAT_ID" => $this->avto->getAcatMarkId(),
                "DRIVER_SECOND_NAME" => $this->avto->getDriverSecondName(),
               );
            $result = IblockHelper::updateProps($arFilter, $arProps, GarageConfig::GARAGE_IBLOCK);
            return $result;
        }
        return false;
    }

    public static function deleteAuto($id) {
       $result = IblockHelper::deleteIBlockElement($id);
       return $result;
    }
}