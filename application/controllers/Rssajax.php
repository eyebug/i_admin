<?php

/**
 * RSS管理ajax
 * @author ZXM
 */
class RssajaxController extends \BaseController {

    /**
     * @var RssModel
     */
    private $RssModel;

    /**
     * @var Convertor_Rss
     */
    private $RssConvertor;

    public function init() {
        parent::init();
        $this->RssModel = new RssModel();
        $this->RssConvertor = new Convertor_Rss();
    }

    /**
     * RSS类型列表
     */
    public function getTypeListAction() {
        $paramList['page'] = $this->getPost('page');
        $result = $this->RssModel->getTypeList($paramList);
        $result = $this->RssConvertor->typeListConvertor($result);
        $this->echoJson($result);
    }

    /**
     * 新建和编辑RSS类型
     */
    private function handlerTypeSaveParams() {
        $paramList = array();
        $paramList['title'] = trim($this->getPost("title"));
        return $paramList;
    }

    /**
     * 新建RSS类型
     */
    public function createTypeAction() {
        $paramList = $this->handlerTypeSaveParams();
        $result = $this->RssModel->saveTypeDataInfo($paramList);
        $this->echoJson($result);
    }

    /**
     * 更新RSS类型
     */
    public function updateTypeAction() {
        $paramList = $this->handlerTypeSaveParams();
        $paramList['id'] = intval($this->getPost("id"));
        $result = $this->RssModel->saveTypeDataInfo($paramList);
        $this->echoJson($result);
    }

    /**
     * RSS列表
     */
    public function getRssListAction() {
        $paramList['page'] = $this->getPost('page');
        $paramList['id'] = intval($this->getPost('id'));
        $paramList['typeid'] = intval($this->getPost('typeid'));
        $status = $this->getPost('status');
        $status !== 'all' && !is_null($status) ? $paramList['status'] = intval($status) : false;
        $result = $this->RssModel->getRssList($paramList);
        $result = $this->RssConvertor->rssListConvertor($result);
        $this->echoJson($result);
    }

    /**
     * 新建和编辑RSS
     */
    private function handlerRssSaveParams() {
        $paramList = array();
        $paramList['name_zh'] = trim($this->getPost("namezh"));
        $paramList['name_en'] = trim($this->getPost("nameen"));
        $paramList['rss'] = trim($this->getPost("rss"));
        $paramList['typeid'] = intval($this->getPost("typeid"));
        $paramList['status'] = intval($this->getPost("status"));
        return $paramList;
    }

    /**
     * 新建RSS
     */
    public function createRssAction() {
        $paramList = $this->handlerRssSaveParams();
        $result = $this->RssModel->saveRssDataInfo($paramList);
        $this->echoJson($result);
    }

    /**
     * 更新RSS
     */
    public function updateRssAction() {
        $paramList = $this->handlerRssSaveParams();
        $paramList['id'] = intval($this->getPost("id"));
        $result = $this->RssModel->saveRssDataInfo($paramList);
        $this->echoJson($result);
    }
}
