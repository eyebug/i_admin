<?php

/**
 * APP请求
 */
class AppajaxController extends \BaseController {

    /**
     * @var AppModel
     */
    private $appModel;

    /**
     * @var Convertor_App
     */
    private $appConvertor;

    public function init() {
        parent::init();
        $this->appModel = new AppModel();
        $this->appConvertor = new Convertor_App();
    }


    /**
     * 获取启动消息列表
     */
    public function getStartMsgListAction() {
        $paramList['id'] = intval($this->getPost('id'));
        $paramList['type'] = intval($this->getPost('type'));
        $paramList['dataid'] = intval($this->getPost('dataid'));
        $status = $this->getPost('status');
        $status !== 'all' && !is_null($status) ? $paramList['status'] = intval($status) : false;
        $result = $this->appModel->getStartMsgList($paramList);
        $result = $this->appConvertor->startMsgListConvertor($result);
        $this->echoJson($result);
    }

    /**
     * 新建和编辑启动消息数据
     */
    private function handlerStartMsgSaveParams() {
        $paramList = array();
        $paramList['type'] = intval($this->getPost("type"));
        if ($paramList['type'] == 1) {
            $paramList['dataid'] = intval($this->getPost("hotelid"));
        } else {
            $paramList['dataid'] = intval($this->getPost("groupid"));
        }
        $paramList['pic'] = $_FILES['pic'];
        $paramList['msg'] = trim($this->getPost("msg"));
        $paramList['url'] = trim($this->getPost("url"));
        $paramList['status'] = intval($this->getPost("status"));
        return $paramList;
    }

    /**
     * 新建启动消息
     */
    public function createStartMsgAction() {
        $paramList = $this->handlerStartMsgSaveParams();
        $result = $this->appModel->saveStartMsgDataInfo($paramList);
        $this->echoJson($result);
    }

    /**
     * 更新启动消息
     */
    public function updateStartMsgAction() {
        $paramList = $this->handlerStartMsgSaveParams();
        $paramList['id'] = intval($this->getPost("id"));
        $result = $this->appModel->saveStartMsgDataInfo($paramList);
        $this->echoJson($result);
    }

    /**
     * 获取推送列表
     */
    public function getPushListAction() {
        $paramList['id'] = intval($this->getPost('id'));
        $paramList['type'] = Enum_App::PUSH_TYPE_ALL;
        $paramList['content_type'] = Enum_App::PUSH_CONTENT_TYPE_URL;
        $result = $this->getPost('result');
        $result !== 'all' && !is_null($result) ? $paramList['result'] = intval($result) : false;
        $platform = $this->getPost('platform');
        $platform !== 'all' && !is_null($platform) ? $paramList['platform'] = intval($platform) : false;
        $result = $this->appModel->getPushList($paramList);
        $result = $this->appConvertor->pushListConvertor($result);
        $this->echoJson($result);
    }

    /**
     * 新建全量推送
     */
    public function createPushAction() {
        $paramList = array();
        $paramList['type'] = Enum_App::PUSH_TYPE_ALL;
        $paramList['platform'] = intval($this->getPost("platform"));
        $paramList['cn_title'] = trim($this->getPost("cnTitle"));
        $paramList['cn_value'] = trim($this->getPost("cnValue"));
        $paramList['en_title'] = trim($this->getPost("enTitle"));
        $paramList['en_value'] = trim($this->getPost("enValue"));
        $paramList['url'] = trim($this->getPost("url"));
        $result = $this->appModel->createPush($paramList);
        $this->echoJson($result);
    }
}
