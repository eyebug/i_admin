<?php

/**
 * 物业管理
 */
class HotelController extends \BaseController {


    /**
     * 物业列表
     */
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

    /**
     * 物业管理员
     */
    public function userListAction() {
        $hotelModel = new HotelModel();
        $hotelList = $hotelModel->getHotelList(array(), 3600 * 6);

        $permissionResult = $hotelModel->getHotelPermission(array('type' => HotelModel::PERMISSION_TYPE_ALL), 6 * 3600);
        $departmentAndLevel = $hotelModel->getDepartmentAndLevelListAction(array(), 6 * 3600);
        $departmentList = $departmentAndLevel['data']['department'];
        $levelList = $departmentAndLevel['data']['level'];
        $permissionResult = $permissionResult['data']['list'];
        $taskPermissionList = $permissionResult[HotelModel::PERMISSION_TYPE_TASK];
        $permissionList = $permissionResult[HotelModel::PERMISSION_TYPE_BASE];

        $this->_view->assign('permissionList', $permissionList);
        $this->_view->assign('taskPermissionList', $taskPermissionList);
        $this->_view->assign('departmentList', $departmentList);
        $this->_view->assign('levelList', $levelList);
        $this->_view->assign('hotelList', $hotelList['data']['list']);

        $this->_view->display('hotel/userList.phtml');

    }
}