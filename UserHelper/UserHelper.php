<?php

namespace ORC\Garage\UserHelper;

use Bitrix\Main\UserTable;

class UserHelper
{
    private $id;
    private $user;

    public function __construct($id) {
        $rsUsers = UserTable::getById($id);
        $this->user = $rsUsers->fetch();
    }

    public function getEmail() {
        return $this->user['EMAIL'];
    }

    public function getLogin() {
        return $this->user['LOGIN'];
    }

    public static function getList($fields = array(), $ids = false) {
        $defaultFields = [
            'ACTIVE' => 'Y',
        ];
        $rsUsers = \CUser::GetList(($by="ID"), ($order="desc"), array_merge($defaultFields,$fields)); 
        while ($arUser = $rsUsers->fetch()) {
            if ($ids) {
                $result[] = (int) $arUser['ID'];
            }else{
                $result[] = $arUser;
            }
        }
        return $result;
    }
}