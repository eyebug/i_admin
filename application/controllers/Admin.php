<?php

/**
 * 总后台管理
 */
class AdminController extends \BaseController {

    /**
     * 管理员列表
     */
    public function userListAction() {
        $this->_view->display('admin/userList.phtml');
    }
}
