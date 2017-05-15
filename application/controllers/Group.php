<?php

/**
 * 集团管理
 */
class GroupController extends \BaseController {

    /**
     * 集团列表
     */
    public function groupListAction() {
        $this->_view->display('group/groupList.phtml');
    }

    /**
     * 集团管理员
     */
    public function userListAction() {
        $groupModel = new GroupModel();
        $groupList = $groupModel->getGroupList(array(), 3600 * 6);
        $this->_view->assign('groupList', $groupList['data']['list']);
        $this->_view->display('group/userList.phtml');
    }
}