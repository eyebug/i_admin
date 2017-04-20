<?php

/**
 * @author ZXM
 */
class UserajaxController extends \BaseController {

    /**
     * @var UserModel
     */
    private $userModel;

    /**
     * @var Convertor_User
     */
    private $userConvertor;

    public function init() {
        parent::init();
        $this->userModel = new UserModel();
        $this->userConvertor = new Convertor_User();
    }

    public function getUserListAction() {
        $paramList['page'] = intval($this->getPost('page'));
        $paramList['id'] = intval($this->getPost('id'));
        $paramList['room_no'] = $this->getPost('room_no');
        $paramList['fullname'] = $this->getPost('fullname');
        $paramList['hotelid'] = intval($this->getPost('hotelid'));
        $paramList['groupid'] = intval($this->getPost('groupid'));
        $paramList['oid'] = $this->getPost('oid');
        $result = $this->userModel->getUserList($paramList);
        $result = $this->userConvertor->userListConvertor($result);
        $this->echoJson($result);
    }

}
