<?php

/**
 * Created by PhpStorm.
 * User: ZXM
 */
class GroupController extends \BaseController {

    public function groupListAction() {
        $this->_view->display('group/groupList.phtml');
    }
}