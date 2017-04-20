<?php

/**
 * @author ZXM
 */
class SystemajaxController extends \BaseController {

    /**
     * @var SystemModel
     */
    private $systemModel;

    /**
     * @var Convertor_System
     */
    private $systemConvertor;

    public function init() {
        parent::init();
        $this->systemModel = new SystemModel();
        $this->systemConvertor = new Convertor_System();
    }

    public function getAdminOperateLogAction() {
        $paramList['page'] = $this->getPost('page');
        $paramList['operatorid'] = intval($this->getPost('operatorid'));
        $paramList['module'] = intval($this->getPost('module'));
        $paramList['code'] = intval($this->getPost('code'));
        $paramList['admintype'] = intval($this->getPost('admintype'));
        $paramList['admintypeid'] = intval($this->getPost('admintypeid'));
        $result = $this->systemModel->getOperateLogList($paramList);
        $result = $this->systemConvertor->operateLogListConvertor($result);
        $this->echoJson($result);
    }

}
