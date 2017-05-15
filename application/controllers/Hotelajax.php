<?php

/**
 * 物业请求
 */
class HotelajaxController extends \BaseController {

    /**
     * @var HotelModel
     */
    private $hotelModal;

    /**
     * @var Convertor_Hotel
     */
    private $hotelConvertor;

    public function init() {
        parent::init();
        $this->hotelModal = new HotelModel();
        $this->hotelConvertor = new Convertor_Hotel();
    }

    /**
     * 获取物业列表
     */
    public function getHotelListAction() {
        $paramList['id'] = intval($this->getPost('id'));
        $paramList['name'] = $this->getPost('name');
        $paramList['groupid'] = intval($this->getPost('groupid'));
        $status = $this->getPost('status');
        $status !== 'all' && !is_null($status) ? $paramList['status'] = intval($status) : false;
        $result = $this->hotelModal->getHotelList($paramList);
        $result = $this->hotelConvertor->hotelListConvertor($result);
        $this->echoJson($result);
    }

    /**
     * 新建和编辑物业信息数据
     */
    private function handlerHotelSaveParams() {
        $paramList = array();
        $paramList['groupid'] = intval($this->getPost("groupid"));
        $paramList['name_lang1'] = trim($this->getPost("nameLang1"));
        $paramList['name_lang2'] = trim($this->getPost("nameLang2"));
        $paramList['name_lang3'] = trim($this->getPost("nameLang3"));
        $paramList['cityid'] = intval($this->getPost("cityid"));
        $paramList['propertyinterfid'] = trim($this->getPost("propertyinterfid"));
        $paramList['lng'] = trim($this->getPost("lng"));
        $paramList['lat'] = trim($this->getPost("lat"));
        $paramList['tel'] = trim($this->getPost("tel"));
        $paramList['website'] = trim($this->getPost("website"));
        $paramList['logo'] = $_FILES['logo'];
        $paramList['index_background'] = $_FILES['indexBackground'];
        $paramList['voice_lang1'] = $_FILES['voiceLang1'];
        $paramList['voice_lang2'] = $_FILES['voiceLang2'];
        $paramList['voice_lang3'] = $_FILES['voiceLang3'];
        $paramList['status'] = intval($this->getPost("status"));
        $paramList['bookurl'] = trim($this->getPost("bookurl"));
        $paramList['address_lang1'] = trim($this->getPost("addressLang1"));
        $paramList['address_lang2'] = trim($this->getPost("addressLang2"));
        $paramList['address_lang3'] = trim($this->getPost("addressLang3"));
        $paramList['introduction_lang1'] = trim($this->getPost("introductionLang1"));
        $paramList['introduction_lang2'] = trim($this->getPost("introductionLang2"));
        $paramList['introduction_lang3'] = trim($this->getPost("introductionLang3"));
        return $paramList;
    }

    /**
     * 新建物业信息
     */
    public function createHotelAction() {
        $paramList = $this->handlerHotelSaveParams();
        $result = $this->hotelModal->saveHotelDataInfo($paramList);
        $this->echoJson($result);
    }

    /**
     * 更新物业信息
     */
    public function updateHotelAction() {
        $paramList = $this->handlerHotelSaveParams();
        $paramList['id'] = intval($this->getPost("id"));
        $result = $this->hotelModal->saveHotelDataInfo($paramList);
        $this->echoJson($result);
    }

    /**
     * 更新物业语言
     */
    public function updateHotelLangListAction() {
        $paramList['id'] = intval($this->getPost("id"));
        $paramList['lang_list'] = trim($this->getPost("lang"));
        $result = $this->hotelModal->saveHotelLangList($paramList);
        $this->echoJson($result);
    }

    /**
     * 获取物业管理员列表
     */
    public function getUserListAction() {
        $paramList['page'] = $this->getPost('page');
        $paramList['id'] = intval($this->getPost('id'));
        $paramList['hotelid'] = intval($this->getPost('hotelid'));
        $paramList['username'] = $this->getPost('username');
        $status = $this->getPost('status');
        $status !== 'all' && !is_null($status) ? $paramList['status'] = intval($status) : false;
        $result = $this->hotelModal->getUserList($paramList);
        $result = $this->hotelConvertor->userListConvertor($result);
        $this->echoJson($result);
    }

    /**
     * 新建和编辑物业管理员数据
     */
    private function handlerUserSaveParams() {
        $paramList = array();
        $paramList['username'] = trim($this->getPost("username"));
        $paramList['realname'] = trim($this->getPost("realname"));
        $paramList['password'] = trim($this->getPost("password"));
        $paramList['remark'] = trim($this->getPost("remark"));
        $paramList['status'] = intval($this->getPost("status"));
        $paramList['hotelid'] = intval($this->getPost("hotelid"));
        return $paramList;
    }

    /**
     * 新建物业管理员
     */
    public function createUserAction() {
        $paramList = $this->handlerUserSaveParams();
        $paramList['createadmin'] = $this->userInfo['id'];
        $result = $this->hotelModal->saveUserDataInfo($paramList);
        $this->echoJson($result);
    }

    /**
     * 更新物业管理员
     */
    public function updateUserAction() {
        $paramList = $this->handlerUserSaveParams();
        $paramList['id'] = intval($this->getPost("id"));
        $result = $this->hotelModal->saveUserDataInfo($paramList);
        $this->echoJson($result);
    }

    /**
     * 更新物业管理员权限
     */
    public function updateUserPermissionAction() {
        $paramList['id'] = intval($this->getPost("id"));
        $paramList['permission'] = trim($this->getPost("permission"));
        $result = $this->hotelModal->saveUserPermission($paramList);
        $this->echoJson($result);
    }
}
