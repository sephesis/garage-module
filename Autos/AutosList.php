<?php

namespace ORC\Garage\Autos;

use ORC\Garage\Config;

class AutosList
{
    const MAX_GARAGE_SIZE = 50;

    public $total;
    public $userId;

    public function __construct($userID = '') {
        $this->userId = $userID;
        if (!empty($userID)) {
            $this->getTotalByUser();
        }
    }

    public function getTotalByUser() {
        $arFilter = array(
            'IBLOCK_ID' => Config::GARAGE_IBLOCK, 
            'ACTIVE' => 'Y',
            'PROPERTY_USER' => $this->userId,
        );
        $res = \CIBlockElement::GetList(false, $arFilter, array(Config::GARAGE_IBLOCK));
        $this->total = $res->SelectedRowsCount();
        return $this->total;
    }

    public function checkUserRightsToAdd() {
        if ($this->total >= self::MAX_GARAGE_SIZE) {
            return false;
        }else{
            return true;
           
        }
    }
}