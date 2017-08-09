<?php

/**
 * APP管理
 */
class AppController extends \BaseController {

    /**
     * 启动消息管理
     */
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

    /**
     * 全量推送
     */
    public function pushAction() {
        $baseModel = new BaseModel();
        $platform = $baseModel->getPlatformList();
        $this->_view->assign('platform', $platform);
        $this->_view->display('app/push.phtml');
    }

}