<?php

/**
 * 总后台管理ajax
 * @author ZXM
 */
class AdminajaxController extends \BaseController {

    /**
     * @var AdminModel
     */
    private $adminModel;

    /**
     * @var Convertor_Admin
     */
    private $adminConvertor;

    public function init() {
        parent::init();
        $this->adminModel = new AdminModel();
        $this->adminConvertor = new Convertor_Admin();
    }

    /**
     * 获取管理员列表
     */
    public function getUserListAction() {
        $paramList['page'] = $this->getPost('page');
        $paramList['id'] = intval($this->getPost('id'));
        $paramList['username'] = $this->getPost('username');
        $status = $this->getPost('status');
        $status !== 'all' && !is_null($status) ? $paramList['status'] = intval($status) : false;
        $result = $this->adminModel->getUserList($paramList);
        $result = $this->adminConvertor->userListConvertor($result);
        $this->echoJson($result);
    }

    /**
     * 新建和编辑管理员信息数据
     */
    private function handlerSaveParams() {
        $paramList = array();
        $paramList['username'] = trim($this->getPost("username"));
        $paramList['realname'] = trim($this->getPost("realname"));
        $paramList['password'] = trim($this->getPost("password"));
        $paramList['remark'] = trim($this->getPost("remark"));
        $paramList['status'] = intval($this->getPost("status"));
        return $paramList;
    }

    /**
     * 新建管理员信息
     */
    public function createAction() {
        $paramList = $this->handlerSaveParams();
        $paramList['createadmin'] = $this->userInfo['id'];
        $result = $this->adminModel->saveDataInfo($paramList);
        $this->echoJson($result);
    }

    /**
     * 更新管理员信息
     */
    public function updateAction() {
        $paramList = $this->handlerSaveParams();
        $paramList['id'] = intval($this->getPost("id"));
        $result = $this->adminModel->saveDataInfo($paramList);
        $this->echoJson($result);
    }
}
