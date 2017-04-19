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
}
