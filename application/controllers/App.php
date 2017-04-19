<?php

/**
 * Created by PhpStorm.
 * User: ZXM
 */
class AppController extends \BaseController {

    public function startPicListAction() {
        $baseModel = new BaseModel();
        $allowTypeImage = $baseModel->getAllowUploadFileType(Enum_Oss::OSS_PATH_IMAGE);
        $this->_view->assign('allowTypeImage', array_keys($allowTypeImage['data']['list']));
        $this->_view->display('app/startPicList.phtml');
    }

    public function versionListAction() {
        $baseModel = new BaseModel();
        $platformList = $baseModel->getPlatformList();
        $this->_view->assign('platformList', $platformList);
        $this->_view->display('app/versionList.phtml');
    }

    public function appImgListAction() {
        $baseModel = new BaseModel();
        $allowTypeImage = $baseModel->getAllowUploadFileType(Enum_Oss::OSS_PATH_IMAGE);
        $this->_view->assign('allowTypeImage', array_keys($allowTypeImage['data']['list']));
        $this->_view->display('app/appImgList.phtml');
    }
}