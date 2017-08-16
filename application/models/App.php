<?php

/**
 * APP管理
 */
class AppModel extends \BaseModel {

    /**
     * 获取启动消息列表
     */
    public function getStartMsgList($paramList) {
        do {
            $paramList['id'] ? $params['id'] = $paramList['id'] : false;
            $paramList['type'] ? $params['type'] = $paramList['type'] : false;
            if ($paramList['type']) {
                $paramList['dataid'] ? $params['dataid'] = $paramList['dataid'] : false;
            }
            isset($paramList['status']) ? $params['status'] = $paramList['status'] : false;
            $this->setPageParam($params, $paramList['page'], $paramList['limit'], 15);
            $result = $this->rpcClient->getResultRaw('APP010', $params);
        } while (false);
        return (array)$result;
    }

    /**
     * 新建和编辑启动消息数据
     */
    public function saveStartMsgDataInfo($paramList) {
        $params = $this->initParam();
        do {
            $result = array(
                'code' => 1,
                'msg' => '参数错误'
            );

            $paramList['id'] ? $params['id'] = $paramList['id'] : false;
            $paramList['type'] ? $params['type'] = $paramList['type'] : false;
            $paramList['dataid'] ? $params['dataid'] = $paramList['dataid'] : false;
            $paramList['msg'] ? $params['msg'] = $paramList['msg'] : false;
            $paramList['url'] ? $params['url'] = $paramList['url'] : false;
            !is_null($paramList['status']) ? $params['status'] = $paramList['status'] : false;

            $checkParams = Enum_App::getStartMsgMustInput();
            foreach ($checkParams as $checkParamOne) {
                if (empty($params[$checkParamOne])) {
                    break 2;
                }
            }
            if (empty($params['dataid'])) {
                break;
            }

            if ($paramList['pic']) {
                $uploadResult = $this->uploadFile($paramList['pic'], Enum_Oss::OSS_PATH_IMAGE);
                if ($uploadResult['code']) {
                    $result['msg'] = '展示图上传失败:' . $uploadResult['msg'];
                    break;
                }
                $params['pic'] = $uploadResult['data']['picKey'];
            }
            $interfaceId = $params['id'] ? 'APP012' : 'APP011';
            $result = $this->rpcClient->getResultRaw($interfaceId, $params);
        } while (false);
        return $result;
    }

    /**
     * 获取推送列表
     */
    public function getPushList($paramList) {
        do {
            $paramList['id'] ? $params['id'] = $paramList['id'] : false;
            $paramList['type'] ? $params['type'] = $paramList['type'] : false;
            $paramList['content_type'] ? $params['content_type'] = $paramList['content_type'] : false;
            isset($paramList['result']) ? $params['result'] = $paramList['result'] : false;
            isset($paramList['platform']) ? $params['platform'] = $paramList['platform'] : false;
            $this->setPageParam($params, $paramList['page'], $paramList['limit'], 15);
            $result = $this->rpcClient->getResultRaw('APP013', $params);
        } while (false);
        return (array)$result;
    }

    /**
     * 新建全量推送
     */
    public function createPush($paramList) {
        $params = $this->initParam();
        do {
            $result = array(
                'code' => 1,
                'msg' => '参数错误'
            );

            $paramList['platform'] ? $params['platform'] = $paramList['platform'] : false;
            $paramList['type'] ? $params['type'] = $paramList['type'] : false;
            $paramList['cn_title'] ? $params['cn_title'] = $paramList['cn_title'] : false;
            $paramList['cn_value'] ? $params['cn_value'] = $paramList['cn_value'] : false;
            $paramList['en_title'] ? $params['en_title'] = $paramList['en_title'] : false;
            $paramList['en_value'] ? $params['en_value'] = $paramList['en_value'] : false;
            $paramList['url'] ? $params['url'] = $paramList['url'] : false;

            $checkParams = Enum_App::getPushMustInput();
            foreach ($checkParams as $checkParamOne) {
                if (empty($params[$checkParamOne])) {
                    break 2;
                }
            }
            $result = $this->rpcClient->getResultRaw('APP014', $params);
        } while (false);
        return $result;
    }


}
