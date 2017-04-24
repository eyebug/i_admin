<?php

class BaseModel {

    protected $rpcClient;

    protected $limit;

    protected $partnerId;

    public function __construct() {
        $this->rpcClient = Rpc_HttpDao::getInstance();
        $this->limit = 5;
        $userInfo = Yaf_Registry::get('loginInfo');
        $this->partnerId = $userInfo['partnerId'];
    }

    protected function initParam($paramList = array()) {
        return $paramList;
    }

    /**
     * 设置分页
     *
     * @param array $param
     * @param int $page
     * @param int $limit
     * @param number $limitDefault
     */
    protected function setPageParam(&$params, $page, $limit, $limitDefault = 4) {
        $limit = intval($limit);
        $params['limit'] = $limit ? $limit : $limitDefault;
        $params['page'] = empty($page) ? 1 : intval($page);
    }

    /**
     * 抛出异常
     * @param $name
     * @param $code
     * @throws Exception
     */
    protected function throwException($name, $code) {
        throw new Exception($name, $code);
    }

    /**
     * 获取可用的语言列表
     * @return array
     */
    public function getLanguageList() {
        $result = $this->rpcClient->getResultRaw('B001', array(), true, 3600 * 12);
        $languageList = $result['code'] ? array() : $result['data']['list'];
        return $languageList;
    }

    /**
     * 上传文件
     * @param $file 待上传的文件
     * @param $path 待上传的文件类型
     * @return array
     */
    public function uploadFile($file, $path) {
        $result['code'] = 1;
        if ($file['error']) {
            switch ($file['error']) {
                case UPLOAD_ERR_INI_SIZE:
                    $result['msg'] = '上传的文件超过大小限制：' . ini_get('upload_max_filesize');
                    break;
            }
        } else {
            $result = $this->rpcClient->getResultRaw('B003', array('uploadfile' => $file, 'type' => $path));
        }
        return $result;
    }

    /**
     * 获取允许上传的扩展名
     * @param $type 待上传的文件类型
     * @return array
     */
    public function getAllowUploadFileType($type) {
        $result = $this->rpcClient->getResultRaw('B004', array('type' => $type), true, 3600 * 3);
        return $result;
    }

    /**
     * 获取设备列表
     * @return array
     */
    public function getPlatformList() {
        $result = $this->rpcClient->getResultRaw('B005', array(), true, 3600 * 12);
        $languageList = $result['code'] ? array() : $result['data']['list'];
        return $languageList;
    }
}

?>