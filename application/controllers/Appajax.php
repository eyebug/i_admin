<?php

/**
 * @author ZXM
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

    public function getStartPicListAction() {
        $paramList['id'] = intval($this->getPost('id'));
        $status = $this->getPost('status');
        $status !== 'all' && !is_null($status) ? $paramList['status'] = intval($status) : false;
        $result = $this->appModel->getStartPicList($paramList);
        $result = $this->appConvertor->startPicListConvertor($result);
        $this->echoJson($result);
    }

    /**
     * 新建和编辑启动广告图数据
     */
    private function handlerStartPicSaveParams() {
        $paramList = array();
        $paramList['link'] = trim($this->getPost("link"));
        $paramList['pic'] = $_FILES['pic'];
        $paramList['status'] = intval($this->getPost("status"));
        return $paramList;
    }

    /**
     * 新建启动广告图
     */
    public function createStartPicListAction() {
        $paramList = $this->handlerStartPicSaveParams();
        $result = $this->appModel->saveStartPicDataInfo($paramList);
        $this->echoJson($result);
    }

    /**
     * 更新集团信息
     */
    public function updateStartPicListAction() {
        $paramList = $this->handlerStartPicSaveParams();
        $paramList['id'] = intval($this->getPost("id"));
        $result = $this->appModel->saveStartPicDataInfo($paramList);
        $this->echoJson($result);
    }

    public function getVersionListAction() {
        $paramList['id'] = intval($this->getPost('id'));
        $paramList['platform'] = intval($this->getPost('platform'));
        $forced = $this->getPost('forced');
        $forced !== 'all' && !is_null($forced) ? $paramList['forced'] = intval($forced) : false;
        $latest = $this->getPost('latest');
        $latest !== 'all' && !is_null($latest) ? $paramList['latest'] = intval($latest) : false;
        $result = $this->appModel->getVersionList($paramList);
        $result = $this->appConvertor->versionListConvertor($result);
        $this->echoJson($result);
    }

    /**
     * 新建和编辑版本数据
     */
    private function handlerVersionSaveParams() {
        $paramList = array();
        $paramList['platform'] = intval($this->getPost("platform"));
        $paramList['forced'] = intval($this->getPost("forced"));
        $paramList['latest'] = intval($this->getPost("latest"));
        $paramList['version'] = trim($this->getPost("version"));
        $paramList['description'] = trim($this->getPost("description"));
        return $paramList;
    }

    /**
     * 新建版本
     */
    public function createVersionAction() {
        $paramList = $this->handlerVersionSaveParams();
        $result = $this->appModel->saveVersionDataInfo($paramList);
        $this->echoJson($result);
    }

    /**
     * 更新版本
     */
    public function updateVersionAction() {
        $paramList = $this->handlerVersionSaveParams();
        $paramList['id'] = intval($this->getPost("id"));
        $result = $this->appModel->saveVersionDataInfo($paramList);
        $this->echoJson($result);
    }

    public function getAppImgListAction() {
        $paramList['id'] = intval($this->getPost('id'));
        $status = $this->getPost('status');
        $status !== 'all' && !is_null($status) ? $paramList['status'] = intval($status) : false;
        $result = $this->appModel->getAppImgList($paramList);
        $result = $this->appConvertor->appImgListConvertor($result);
        $this->echoJson($result);
    }

    /**
     * 新建和编辑启动图数据
     */
    private function handlerAppImgSaveParams() {
        $paramList = array();
        $paramList['link'] = trim($this->getPost("link"));
        $paramList['pickey'] = $_FILES['pickey'];
        $paramList['status'] = intval($this->getPost("status"));
        return $paramList;
    }

    /**
     * 新建启动图
     */
    public function createAppImgAction() {
        $paramList = $this->handlerAppImgSaveParams();
        $result = $this->appModel->saveAppImgDataInfo($paramList);
        $this->echoJson($result);
    }

    /**
     * 更新启动图
     */
    public function updateAppImgAction() {
        $paramList = $this->handlerAppImgSaveParams();
        $paramList['id'] = intval($this->getPost("id"));
        $result = $this->appModel->saveAppImgDataInfo($paramList);
        $this->echoJson($result);
    }
}
