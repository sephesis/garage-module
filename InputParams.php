<?php

namespace ORC\Garage;

class InputParams
{
    private $request;

    public function __construct() {
        $this->request = \Bitrix\Main\Context::getCurrent()->getRequest();
    }

    public function isPost() {
        if ($this->request->isPost()) {
            return true;
        }
        return false;
    }

    public function getYear() {
        if (!empty($this->request->getPost('year'))) {
            return $this->request->getPost('year') ?: '';
        }
       return $this->request->getPost('GARAGE_YEARS');
    }

    public function getChassis() {
        if (!empty($this->request->getPost('chassis'))) {
            return $this->request->getPost('chassis') ?: '';
        }
        return $this->request->getPost('GARAGE_CHASSIS') ?: '';
    }

    public function getTypeAuto() {
        if (!empty($this->request->getPost('typeauto'))) {
            return $this->request->getPost('typeauto') ?: '';
        }
        return $this->request->getPost('GARAGE_TYPEAUTO') ?: '';
    }
    
    public function getVin() {
        if (!empty($this->request->getPost('vin'))) {
            return $this->request->getPost('vin') ?: '';
        }
        return $this->request->getPost('GARAGE_VIN') ?: '';
    }

    public function getModel() {
        if (!empty($this->request->getPost('model'))) {
            return $this->request->getPost('model') ?: '';
        }
        return $this->request->getPost('GARAGE_MODEL') ?: '';
    }

    public function getMark() {
        if (!empty($this->request->getPost('mark'))) {
            return $this->request->getPost('mark') ?: '';
        }
        return $this->request->getPost('GARAGE_MARKS') ?: '';
    }

    public function getAction() {
        return $this->request->getPost('action') ?: '';
    }

    public function getItemId() {
        return $this->request->getPost('id') ?: '';
    }

    public function getItem() {
        return $this->request->getPost('item') ?: '';
    }

    public function getDriverName() {
        if (!empty($this->request->getPost('drivername'))) {
            return $this->request->getPost('drivername') ?: '';
        }
        return $this->request->getPost('GARAGE_DRIVER_NAME') ?: '';
    }

    public function getDriverSurname() {
        if (!empty($this->request->getPost('driversurname'))) {
            return $this->request->getPost('driversurname') ?: '';
        }
        return $this->request->getPost('GARAGE_DRIVER_SURNAME') ?: '';
    }

    public function getDriverSecondName() {
        if (!empty($this->request->getPost('driverSecondName'))) {
            return $this->request->getPost('driverSecondName') ?: '';
        }
        return $this->request->getPost('GARAGE_DRIVER_SECOND_NAME') ?: '';
    }

    public function getFile() {
        return $this->request->getFile('attach') ?: array();
    }

    public function getFileItemId() {
       return $this->request->getPost('bx_item_id') ?: '';
    }

    public function getSearchWord() {
        return $this->request->getPost('search') ?: '';
    }

    public function getSearchType() {
        return $this->request->getPost('type') ?: '';
    }

    public function getAcatId() {
        if (!empty($this->request->getPost('acatId'))) {
            return $this->request->getPost('acatId') ?: '';
        }
       return $this->request->getPost('GARAGE_ACAT') ?: '';
    }

    public function getAcatMarkId() {
        return $this->request->getPost('GARAGE_MARK_ACAT_ID');
    }

    public function getSearchAutoType() {
        return $this->request->getPost('ajaxType');
    }

    public function getSearchAutoMark() {
        return $this->request->getPost('ajaxMark');
    }

    public function getSearchAutoYear() {
        return $this->request->getPost('ajaxYear');
    }
}
