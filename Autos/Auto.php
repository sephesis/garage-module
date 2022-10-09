<?php

namespace ORC\Garage\Autos;

class Auto
{
    public $params;

    public function __construct(\ORC\Garage\InputParams $inputParams) {
        $this->params = $inputParams;
    }

    public function getDriverName() {
        return $this->params->getDriverName();
    }

    public function getVin() {
        return $this->params->getVin();
    }

    public function getChassis() {
        return $this->params->getChassis();
    }
    
    public function getDriverSurname() {
        return $this->params->getDriverSurname();
    }

    public function getDriverSecondName() {
        return $this->params->getDriverSecondName();
    }

    public function getType() {
        $type = $this->params->getTypeAuto();
        switch($type) {
            case '2': $typeauto = '262'; break;
            case '3': $typeauto = '263'; break;
            case '4': $typeauto = '264'; break;
            case '5': $typeauto = '265'; break;
            default: return;
        }
        return $typeauto;
    }

    public function getAcatId() {
        return $this->params->getAcatId();
    }

    public function getAcatMarkId() {
        return $this->params->getAcatMarkId();
    }

    public function getMark() {
        return $this->params->getMark();
    }

    public function getYear() {
        return $this->params->getYear();
    }

    public function getModel() {
        return $this->params->getModel();
    }

    public function getId() {
        return !empty($this->params->getItem()) ? $this->params->getItem() : false;
    }
}