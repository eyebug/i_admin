<?php

/**
 * RSS管理
 */
class RssController extends \BaseController {

    /**
     * 分类列表
     */
    public function typeListAction() {
        $this->_view->display('rss/typeList.phtml');
    }

    /**
     * RSS列表
     */
    public function listAction() {
        $rssModel = new RssModel();
        $typeList = $rssModel->getTypeList(array(), 3600 * 6);
        $this->_view->assign('typeList', $typeList['data']['list']);
        $this->_view->display('rss/rssList.phtml');
    }
}