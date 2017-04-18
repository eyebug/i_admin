<?php

/**
 * Created by PhpStorm.
 * User: ZXM
 */
class HotelController extends \BaseController {

    public function hotelListAction() {
        $groupModel = new GroupModel();
        $cityModel = new CityModel();
        $groupList = $groupModel->getGroupList(array(), 3600 * 6);
        $this->_view->assign('groupList', $groupList['data']['list']);
        $cityList = $cityModel->getCityList(array());
        $this->_view->assign('cityList', $cityList['data']['list']);
        $languageList = $cityModel->getLanguageList();
        $this->_view->assign('languageList', $languageList);
        $allowTypeImage = $cityModel->getAllowUploadFileType(Enum_Oss::OSS_PATH_IMAGE);
        $this->_view->assign('allowTypeImage', array_keys($allowTypeImage['data']['list']));
        $allowTypeVoice = $cityModel->getAllowUploadFileType(Enum_Oss::OSS_PATH_VOICE);
        $this->_view->assign('allowTypeVoice', array_keys($allowTypeVoice['data']['list']));
        $this->_view->display('hotel/hotelList.phtml');
    }

    public function userListAction() {
        $hotelModel = new HotelModel();
        $hotelList = $hotelModel->getHotelList(array(), 3600 * 6);
        $this->_view->assign('hotelList', $hotelList['data']['list']);
        $this->_view->display('hotel/userList.phtml');
    }
}