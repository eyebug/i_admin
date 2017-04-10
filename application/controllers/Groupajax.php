<?php

/**
 * @author ZXM
 */
class GroupajaxController extends \BaseController {

    private $groupModal;

    private $groupConvertor;

    public function init() {
        parent::init();
        $this->groupModal = new GroupModel();
        $this->groupConvertor = new Convertor_Group();
    }

    public function getGroupListAction() {
        $paramList['page'] = $this->getPost('page');
        $result = $this->groupModal->getGroupList($paramList);
        $result = $this->groupConvertor->groupListConvertor($result);
        $this->echoJson($result);
    }

    /**
     * 新建和编辑集团信息数据
     */
    private function handlerGroupSaveParams() {
        $paramList = array();
        $paramList['name'] = trim($this->getPost("name"));
        $paramList['enname'] = trim($this->getPost("enname"));
        $paramList['porturl'] = trim($this->getPost("porturl"));
        return $paramList;
    }

    /**
     * 新建集团信息
     */
    public function createGroupAction() {
        $paramList = $this->handlerGroupSaveParams();
        $result = $this->groupModal->saveGroupDataInfo($paramList);
        $this->echoJson($result);
    }

    /**
     * 更新集团信息
     */
    public function updateGroupAction() {
        $paramList = $this->handlerGroupSaveParams();
        $paramList['id'] = intval($this->getPost("id"));
        $result = $this->groupModal->saveGroupDataInfo($paramList);
        $this->echoJson($result);
    }

    public function getUserListAction() {
        $paramList['page'] = $this->getPost('page');
        $paramList['id'] = intval($this->getPost('id'));
        $paramList['groupid'] = intval($this->getPost('groupid'));
        $paramList['username'] = $this->getPost('username');
        $status = $this->getPost('status');
        $status !== 'all' ? $paramList['status'] = intval($status) : false;
        $result = $this->groupModal->getUserList($paramList);
        $result = $this->groupConvertor->userListConvertor($result);
        $this->echoJson($result);
    }
}
