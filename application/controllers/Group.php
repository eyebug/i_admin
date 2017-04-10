<?php

/**
 * Created by PhpStorm.
 * User: ZXM
 */
class GroupController extends \BaseController {

    public function groupListAction() {
        $this->_view->display('group/groupList.phtml');
    }

    public function userListAction() {
        $groupModel = new GroupModel();
        $groupList = $groupModel->getGroupList(array(), 3600 * 6);
        $this->_view->assign('groupList', $groupList['data']['list']);
        $this->_view->display('group/userList.phtml');
    }
}