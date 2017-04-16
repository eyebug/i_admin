<?php

/**
 * Created by PhpStorm.
 * User: ZXM
 */
class HotelController extends \BaseController {

    public function hotelListAction() {
        $groupModel = new GroupModel();
        $groupList = $groupModel->getGroupList(array(), 3600 * 6);
        $this->_view->assign('groupList', $groupList['data']['list']);
        $cityModel = new CityModel();
        $cityList = $cityModel->getCityList(array());
        $this->_view->assign('cityList', $cityList['data']['list']);
        $this->_view->display('hotel/hotelList.phtml');
    }

    public function userListAction() {
        $this->_view->display('hotel/userList.phtml');
    }
}