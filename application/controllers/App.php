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

    public function startMsgListAction() {
        $groupModel = new GroupModel();
        $groupList = $groupModel->getGroupList(array(), 3600 * 6);
        $this->_view->assign('groupList', $groupList['data']['list']);

        $hotelModel = new HotelModel();
        $hotelList = $hotelModel->getHotelList(array(), 3600 * 6);
        $this->_view->assign('hotelList', $hotelList['data']['list']);

        $allowTypeImage = $groupModel->getAllowUploadFileType(Enum_Oss::OSS_PATH_IMAGE);
        $this->_view->assign('allowTypeImage', array_keys($allowTypeImage['data']['list']));
        $this->_view->display('app/startMsgList.phtml');
    }

    public function pushAction() {
        $this->_view->display('app/push.phtml');
    }

    public function feedbackListAction() {
        $this->_view->display('app/feedbackList.phtml');
    }
}