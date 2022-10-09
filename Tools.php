<?php

namespace ORC\Garage;

use ORC\Garage\Config;

class Tools
{
    const CORRECT_MSG = "Файлы корректны";

    const ERROR_COMMON_MSG = "Ошибка отправки сообщения";
    const ERROR_MAX_FILE_SIZE = "Превышен допустимый размер файла. Разрешены файлы не более 5Mb.";
    const ERROR_WRONG_EXTENSIONS = "Прикрепить можно только файлы изображений (jpg, jpeg, png, gif)";

    public static function translit($s) {
            $translit = array(
                'а' => 'a',   'б' => 'b',   'в' => 'v',
                'г' => 'g',   'д' => 'd',   'е' => 'e',
                'ё' => 'yo',   'ж' => 'zh',  'з' => 'z',
                'и' => 'i',   'й' => 'j',   'к' => 'k',
                'л' => 'l',   'м' => 'm',   'н' => 'n',
                'о' => 'o',   'п' => 'p',   'р' => 'r',
                'с' => 's',   'т' => 't',   'у' => 'u',
                'ф' => 'f',   'х' => 'x',   'ц' => 'c',
                'ч' => 'ch',  'ш' => 'sh',  'щ' => 'shh',
                'ь' => '\'',  'ы' => 'y',   'ъ' => '\'\'',
                'э' => 'e\'', 'ю' => 'yu',  'я' => 'ya',
                'А' => 'A',   'Б' => 'B',   'В' => 'V',
                'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
                'Ё' => 'YO',  'Ж' => 'Zh',  'З' => 'Z',
                'И' => 'I',   'Й' => 'J',   'К' => 'K',
                'Л' => 'L',   'М' => 'M',   'Н' => 'N',
                'О' => 'O',   'П' => 'P',   'Р' => 'R',
                'С' => 'S',   'Т' => 'T',   'У' => 'U',
                'Ф' => 'F',   'Х' => 'X',   'Ц' => 'C',
                'Ч' => 'CH',  'Ш' => 'SH',  'Щ' => 'SHH',
                'Ь' => '\'',  'Ы' => 'Y\'', 'Ъ' => '\'\'',
                'Э' => 'E\'',  'Ю' => 'YU', 'Я' => 'YA',
            );
            $string = strtr($s, $translit);
            return $string;
    }
    
    public static function checkFiles($files) {

        $arResult = array(
            'hasError' => true,
            'msg' => self::ERROR_COMMON_MSG,
        );
    
        $fileSizeLimit = 1024 * 1024 * 5;
        $fileExts =  array('gif','png','jpg','jpeg');
    
        foreach ($files['size'] as $key => $size) {
    
            if ($size > $fileSizeLimit) {
                $arResult['msg'] = self::ERROR_MAX_FILE_SIZE;
                return $arResult;
            }
    
            $ext = pathinfo($files['name'][$key], PATHINFO_EXTENSION);
    
            if(!in_array($ext, $fileExts) ) {
                $arResult['msg'] = self::ERROR_WRONG_EXTENSIONS;
                return $arResult;
            }
        }
    
        $arResult = array(
            'hasError' => false,
            'msg' => self::CORRECT_MSG,
        );
    
        return $arResult;
    }

    public static function parseDate($date) {
        $exploded = explode(' ', $date);
        return $exploded[0];
    }

    public static function validate($elements) {
        $validate = array();
        foreach ($elements as $element) {
            if (strpos( $element, ".") !== false) {
                $exploded = explode(".", $element);
                $element = preg_replace("/[a-zA-Zа-яА-Я]/ui", "",$exploded[1]);
            }
            $element = preg_replace("/[a-zA-Zа-яА-Я]/ui", "", $element);
            $validate[] = trim(intval($element));
        }
        $result = array_unique($validate);
        arsort($result);
        return $result;
    }

    public static function getAcatAutotypeValue($type) {
        switch($type) {
            case '2': 
                $typeauto = Config::get('gruz'); 
                break;
            case '3': 
                $typeauto = Config::get('bus'); 
                break;
            case '4': 
                $typeauto = Config::get('selhoz'); 
                break;
            case '5': 
                $typeauto = Config::get('spec'); 
                break;
            default: 
            return false;
        }
        return $typeauto;
    }

    public static function getStringAutotypeValue($type) {
        switch($type) {
            case '262': 
                $typeauto = Config::get('gruz'); 
                break;
            case '263': 
                $typeauto = Config::get('bus'); 
                break;
            case '264': 
                $typeauto = Config::get('selhoz'); 
                break;
            case '265': 
                $typeauto = Config::get('spec'); 
                break;
            default: 
            return false;
        }
        return $typeauto;
    }

    public static function getAutotypeId($id) {
        switch($id) {
            case '262': 
                $typeauto = '2'; 
                break;
            case '263': 
                $typeauto = '3'; 
                break;
            case '264': 
                $typeauto = '4'; 
                break;
            case '265': 
                $typeauto = '5'; 
                break;
            default: 
            return false;
        }
        return $typeauto;
    }
}