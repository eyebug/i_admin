<?php

/**
 * APP用户
 */
class UserController extends \BaseController {

    /**
     * 获取用户列表
     */
    public function userListAction() {
        $groupModel = new GroupModel();
        $groupList = $groupModel->getGroupList(array(), 3600 * 6);
        $this->_view->assign('groupList', $groupList['data']['list']);

        $hotelModel = new HotelModel();
        $hotelList = $hotelModel->getHotelList(array(), 3600 * 6);
        $this->_view->assign('hotelList', $hotelList['data']['list']);
        $this->_view->display('user/userList.phtml');
    }

}