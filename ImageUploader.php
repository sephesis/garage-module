<?php
namespace ORC\Garage;

use ORC\Garage\Tools;
use ORC\Garage\Config as GarageConfig;

class ImageUploader
{
    public $files;
    public $server;

    const BX_ITEM_ID = 'bx_garage';

    public function __construct($file, $item = '') {
        $this->files = $file;
        if ($item !== '') {
            $this->item = $item;
        }else{
            return false;
        }
        $this->server = \Bitrix\Main\Context::getCurrent()->getServer();
    }

    public function uploadImage($needLink = false) {
        $files = $this->files;
        $arFileCheckRes = Tools::checkFiles($files);
        if($arFileCheckRes['hasError']){
            return false;
        }
        $fileUploadDir = $this->server->getDocumentRoot().'/upload/';
        $arFile = array();
            $arFile[] = array(
                'name' => $files['name'][0],
                'type' => $files['type'][0],
                'tmp_name' => $files['tmp_name'][0],
                'error' => $files['error'][0],
                'size' => $files['size'][0],
            );
        
            $arFile[0]['save_to'] = $fileUploadDir.self::BX_ITEM_ID.'_'.date('Ymd_His_').$arFile[0]['name'];
        
            if(!move_uploaded_file($arFile[0]['tmp_name'], $arFile[0]['save_to'])){
               return false;
            }
            $rsElement = new \CIBlockElement;
            $arFields = array(
                "ACTIVE"    => "Y",
                "IBLOCK_ID" => GarageConfig::GARAGE_IBLOCK,
                "PREVIEW_PICTURE" => \CFile::MakeFileArray($arFile[0]['save_to']),
            );
            $rsIDElement = $rsElement->Update(intval($this->item), $arFields);
            if ($rsIDElement) {
                if ($needLink) {
                    $arrLink = \CFile::MakeFileArray($arFile[0]['save_to']);
                    return ['result' => true, 'link' => $arrLink['tmp_name']];
                }
                return true;
            }else{
                return false;
            }
    }
}