<?php

class AppModel extends \BaseModel {

    public function getStartPicList($paramList) {
        do {
            $paramList['id'] ? $params['id'] = $paramList['id'] : false;
            isset($paramList['status']) ? $params['status'] = $paramList['status'] : false;
            $this->setPageParam($params, $paramList['page'], $paramList['limit'], 15);
            $result = $this->rpcClient->getResultRaw('APP001', $params);
        } while (false);
        return (array)$result;
    }

    public function saveStartPicDataInfo($paramList) {
        $params = $this->initParam();
        do {
            $result = array(
                'code' => 1,
                'msg' => '参数错误'
            );

            $paramList['id'] ? $params['id'] = $paramList['id'] : false;
            $paramList['link'] ? $params['link'] = $paramList['link'] : false;
            $paramList['pic'] ? $params['pic'] = $paramList['pic'] : false;
            !is_null($paramList['status']) ? $params['status'] = $paramList['status'] : false;

            $checkParams = Enum_App::getStartPicMustInput();
            foreach ($checkParams as $checkParamOne) {
                if (empty($params[$checkParamOne])) {
                    break 2;
                }
            }
            unset($params['pic']);
            if ($paramList['pic']) {
                $uploadResult = $this->uploadFile($paramList['pic'], Enum_Oss::OSS_PATH_IMAGE);
                if ($uploadResult['code']) {
                    $result['msg'] = '启动图上传失败:' . $uploadResult['msg'];
                    break;
                }
                $params['pic'] = $uploadResult['data']['picKey'];
            }
            $interfaceId = $params['id'] ? 'APP003' : 'APP002';
            $result = $this->rpcClient->getResultRaw($interfaceId, $params);
        } while (false);
        return $result;
    }

    public function getVersionList($paramList) {
        do {
            $paramList['id'] ? $params['id'] = $paramList['id'] : false;
            $paramList['platform'] ? $params['platform'] = $paramList['platform'] : false;
            isset($paramList['forced']) ? $params['forced'] = $paramList['forced'] : false;
            isset($paramList['latest']) ? $params['latest'] = $paramList['latest'] : false;
            $this->setPageParam($params, $paramList['page'], $paramList['limit'], 15);
            $result = $this->rpcClient->getResultRaw('APP004', $params);
        } while (false);
        return (array)$result;
    }

    public function saveVersionDataInfo($paramList) {
        $params = $this->initParam();
        do {
            $result = array(
                'code' => 1,
                'msg' => '参数错误'
            );

            $paramList['id'] ? $params['id'] = $paramList['id'] : false;
            $paramList['platform'] ? $params['platform'] = $paramList['platform'] : false;
            !is_null($paramList['forced']) ? $params['forced'] = $paramList['forced'] : false;
            !is_null($paramList['latest']) ? $params['latest'] = $paramList['latest'] : false;
            $paramList['version'] ? $params['version'] = $paramList['version'] : false;
            $paramList['description'] ? $params['description'] = $paramList['description'] : false;

            $checkParams = Enum_App::getVersionMustInput();
            foreach ($checkParams as $checkParamOne) {
                if (empty($params[$checkParamOne])) {
                    break 2;
                }
            }
            $interfaceId = $params['id'] ? 'APP006' : 'APP005';
            $result = $this->rpcClient->getResultRaw($interfaceId, $params);
        } while (false);
        return $result;
    }

    public function getAppImgList($paramList) {
        do {
            $paramList['id'] ? $params['id'] = $paramList['id'] : false;
            isset($paramList['status']) ? $params['status'] = $paramList['status'] : false;
            $this->setPageParam($params, $paramList['page'], $paramList['limit'], 15);
            $result = $this->rpcClient->getResultRaw('APP007', $params);
        } while (false);
        return (array)$result;
    }

    public function saveAppImgDataInfo($paramList) {
        $params = $this->initParam();
        do {
            $result = array(
                'code' => 1,
                'msg' => '参数错误'
            );

            $paramList['id'] ? $params['id'] = $paramList['id'] : false;
            $paramList['pickey'] ? $params['pickey'] = $paramList['pickey'] : false;
            !is_null($paramList['status']) ? $params['status'] = $paramList['status'] : false;

            $checkParams = Enum_App::getAppImgMustInput();
            foreach ($checkParams as $checkParamOne) {
                if (empty($params[$checkParamOne])) {
                    break 2;
                }
            }
            if (empty($paramList['id']) && empty($params['pickey'])) {
                break;
            }

            unset($params['pickey']);
            if ($paramList['pickey']) {
                $uploadResult = $this->uploadFile($paramList['pickey'], Enum_Oss::OSS_PATH_IMAGE);
                if ($uploadResult['code']) {
                    $result['msg'] = '启动图上传失败:' . $uploadResult['msg'];
                    break;
                }
                $params['pickey'] = $uploadResult['data']['picKey'];
            }
            $interfaceId = $params['id'] ? 'APP009' : 'APP008';
            $result = $this->rpcClient->getResultRaw($interfaceId, $params);
        } while (false);
        return $result;
    }

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

    public function getPushList($paramList) {
        do {
            $paramList['id'] ? $params['id'] = $paramList['id'] : false;
            $paramList['type'] ? $params['type'] = $paramList['type'] : false;
            isset($paramList['result']) ? $params['result'] = $paramList['result'] : false;
            $this->setPageParam($params, $paramList['page'], $paramList['limit'], 15);
            $result = $this->rpcClient->getResultRaw('APP013', $params);
        } while (false);
        return (array)$result;
    }

    public function createPush($paramList) {
        $params = $this->initParam();
        do {
            $result = array(
                'code' => 1,
                'msg' => '参数错误'
            );

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

    public function getFeedbackList($paramList) {
        do {
            $paramList['id'] ? $params['id'] = $paramList['id'] : false;
            $paramList['email'] ? $params['email'] = $paramList['email'] : false;
            $this->setPageParam($params, $paramList['page'], $paramList['limit'], 15);
            $result = $this->rpcClient->getResultRaw('APP015', $params);
        } while (false);
        return (array)$result;
    }
}
