<?php

/**
 * @author ZXM
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
     * 新建和编辑集团信息数据
     */
    private function handlerHotelSaveParams() {
        $paramList = array();
        $paramList['name'] = trim($this->getPost("name"));
        $paramList['enname'] = trim($this->getPost("enname"));
        $paramList['porturl'] = trim($this->getPost("porturl"));
        return $paramList;
    }

    /**
     * 新建集团信息
     */
    public function createHotelAction() {
        $paramList = $this->handlerHotelSaveParams();
        $result = $this->hotelModal->saveHotelDataInfo($paramList);
        $this->echoJson($result);
    }

    /**
     * 更新集团信息
     */
    public function updateHotelAction() {
        $paramList = $this->handlerHotelSaveParams();
        $paramList['id'] = intval($this->getPost("id"));
        $result = $this->hotelModal->saveHotelDataInfo($paramList);
        $this->echoJson($result);
    }

    /**
     * 获取用户列表
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
     * 新建和编辑集团信息数据
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
     * 新建集团信息
     */
    public function createUserAction() {
        $paramList = $this->handlerUserSaveParams();
        $paramList['createadmin'] = $this->userInfo['id'];
        $result = $this->hotelModal->saveUserDataInfo($paramList);
        $this->echoJson($result);
    }

    /**
     * 更新集团信息
     */
    public function updateUserAction() {
        $paramList = $this->handlerUserSaveParams();
        $paramList['id'] = intval($this->getPost("id"));
        $result = $this->hotelModal->saveUserDataInfo($paramList);
        $this->echoJson($result);
    }
}
