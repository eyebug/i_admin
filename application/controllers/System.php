<?php

/**
 * 系统管理
 */
class SystemController extends \BaseController {

    /**
     * 总后台管理员操作日志
     */
    public function adminOperateLogAction() {
        $adminModel = new AdminModel();
        $adminUserList = $adminModel->getUserList(array(), 3600 * 3);
        $this->_view->assign('adminUserList', $adminUserList['data']['list']);
        $this->_view->assign('admintype', Enum_Record::RECORD_ADMIN_TYPE_ID);
        $this->_view->assign('modelTitleList', Enum_Record::getAdminRecordTitle());
        $this->_view->display('system/operateLog.phtml');
    }

    /**
     * 集团后台操作日志
     */
    public function groupOperateLogAction() {
        $groupModel = new GroupModel();
        $adminUserList = $groupModel->getUserList(array(), 3600 * 3);
        $this->_view->assign('adminUserList', $adminUserList['data']['list']);
        $groupList = $groupModel->getGroupList(array(), 3600 * 3);
        $this->_view->assign('groupList', $groupList['data']['list']);
        $this->_view->assign('admintype', Enum_Record::RECORD_GROUP_TYPE_ID);
        $this->_view->assign('modelTitleList', Enum_Record::getGroupRecordTitle());
        $this->_view->display('system/operateLog.phtml');
    }

    /**
     * 物业后台操作日志
     */
    public function hotelOperateLogAction() {
        $hotelModel = new HotelModel();
        $adminUserList = $hotelModel->getUserList(array(), 3600 * 3);
        $this->_view->assign('adminUserList', $adminUserList['data']['list']);
        $hotelList = $hotelModel->getHotelList(array(), 3600 * 3);
        $this->_view->assign('hotelList', $hotelList['data']['list']);
        $this->_view->assign('admintype', Enum_Record::RECORD_HOTEL_TYPE_ID);
        $this->_view->assign('modelTitleList', Enum_Record::getGroupRecordTitle());
        $this->_view->display('system/operateLog.phtml');
    }

}