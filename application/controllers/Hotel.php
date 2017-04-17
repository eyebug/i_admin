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
        $this->_view->display('hotel/hotelList.phtml');
    }

    public function userListAction() {
        $this->_view->display('hotel/userList.phtml');
    }
}