<?php

/**
 * 总后台管理
 * @author ZXM
 */
class AdminController extends \BaseController {

    public function userListAction() {
        $this->_view->display('admin/userList.phtml');
    }
}
