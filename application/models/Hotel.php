<?php

class HotelModel extends \BaseModel {

    public function getHotelList($paramList, $cacheTime = 0) {
        do {
            if ($cacheTime == 0) {
                $paramList['id'] ? $params['id'] = $paramList['id'] : false;
                $paramList['name'] ? $params['name'] = $paramList['name'] : false;
                $paramList['groupid'] ? $params['groupid'] = $paramList['groupid'] : false;
                isset($paramList['status']) ? $params['status'] = $paramList['status'] : false;
                $this->setPageParam($params, $paramList['page'], $paramList['limit'], 15);
            }
            $isCache = $cacheTime != 0 ? true : false;
            $result = $this->rpcClient->getResultRaw('GH001', $params, $isCache, $cacheTime);
        } while (false);
        return (array)$result;
    }

    public function saveHotelDataInfo($paramList) {
        $params = $this->initParam();
        do {
            $result = array(
                'code' => 1,
                'msg' => '参数错误'
            );

            $paramList['id'] ? $params['id'] = $paramList['id'] : false;
            $paramList['groupid'] ? $params['groupid'] = $paramList['groupid'] : false;
            $paramList['name_lang1'] ? $params['name_lang1'] = $params['nameLang1'] = $paramList['name_lang1'] : false;
            $paramList['name_lang2'] ? $params['name_lang2'] = $paramList['name_lang2'] : false;
            $paramList['name_lang3'] ? $params['name_lang3'] = $paramList['name_lang3'] : false;
            $paramList['cityid'] ? $params['cityid'] = $paramList['cityid'] : false;
            $paramList['propertyinterfid'] ? $params['propertyinterfid'] = $paramList['propertyinterfid'] : false;
            $paramList['lng'] ? $params['lng'] = $paramList['lng'] : false;
            $paramList['lat'] ? $params['lat'] = $paramList['lat'] : false;
            $paramList['tel'] ? $params['tel'] = $paramList['tel'] : false;
            $paramList['website'] ? $params['website'] = $paramList['website'] : false;
            $paramList['logo'] ? $params['logo'] = $paramList['logo'] : false;
            $paramList['bookurl'] ? $params['bookurl'] = $paramList['bookurl'] : false;
            $paramList['address_lang1'] ? $params['address_lang1'] = $paramList['address_lang1'] : false;
            $paramList['address_lang2'] ? $params['address_lang2'] = $paramList['address_lang2'] : false;
            $paramList['address_lang3'] ? $params['address_lang3'] = $paramList['address_lang3'] : false;
            $paramList['introduction_lang1'] ? $params['introduction_lang1'] = $paramList['introduction_lang1'] : false;
            $paramList['introduction_lang2'] ? $params['introduction_lang2'] = $paramList['introduction_lang2'] : false;
            $paramList['introduction_lang3'] ? $params['introduction_lang3'] = $paramList['introduction_lang3'] : false;
            !is_null($paramList['status']) ? $params['status'] = $paramList['status'] : false;

            $checkParams = Enum_Hotel::getHotelMustInput();
            foreach ($checkParams as $checkParamOne) {
                if (empty($params[$checkParamOne])) {
                    break 2;
                }
            }
            if ($paramList['logo']) {
                $uploadResult = $this->uploadFile($paramList['logo'], Enum_Oss::OSS_PATH_IMAGE);
                if ($uploadResult['code']) {
                    $result['msg'] = '公寓LOGO上传失败:' . $uploadResult['msg'];
                    break;
                }
                $params['logo'] = $uploadResult['data']['picKey'];
            }
            if ($paramList['index_background']) {
                $uploadResult = $this->uploadFile($paramList['index_background'], Enum_Oss::OSS_PATH_IMAGE);
                if ($uploadResult['code']) {
                    $result['msg'] = 'APP首页背景图上传失败:' . $uploadResult['msg'];
                    break;
                }
                $params['index_background'] = $uploadResult['data']['picKey'];
            }
            if ($paramList['voice_lang1']) {
                $uploadResult = $this->uploadFile($paramList['voice_lang1'], Enum_Oss::OSS_PATH_VOICE);
                if ($uploadResult['code']) {
                    $result['msg'] = '公寓语音介绍上传失败:' . $uploadResult['msg'];
                    break;
                }
                $params['voice_lang1'] = $uploadResult['data']['picKey'];
            }
            if ($paramList['voice_lang2']) {
                $uploadResult = $this->uploadFile($paramList['voice_lang2'], Enum_Oss::OSS_PATH_VOICE);
                if ($uploadResult['code']) {
                    $result['msg'] = '公寓语音介绍上传失败:' . $uploadResult['msg'];
                    break;
                }
                $params['voice_lang2'] = $uploadResult['data']['picKey'];
            }
            if ($paramList['voice_lang3']) {
                $uploadResult = $this->uploadFile($paramList['voice_lang3'], Enum_Oss::OSS_PATH_VOICE);
                if ($uploadResult['code']) {
                    $result['msg'] = '公寓语音介绍上传失败:' . $uploadResult['msg'];
                    break;
                }
                $params['voice_lang3'] = $uploadResult['data']['picKey'];
            }
            $interfaceId = $params['id'] ? 'GH003' : 'GH002';
            $result = $this->rpcClient->getResultRaw($interfaceId, $params);
        } while (false);
        return $result;
    }

    public function saveHotelLangList($paramList) {
        $params = $this->initParam($paramList);
        do {
            $result = array(
                'code' => 1,
                'msg' => '参数错误'
            );
            if (empty($params['id']) || empty($params['lang_list'])) {
                break;
            }
            $result = $this->rpcClient->getResultRaw('GH003', $params);
        } while (false);
        return $result;
    }

    public function getUserList($paramList) {
        do {
            $paramList['id'] ? $params['id'] = $paramList['id'] : false;
            $paramList['groupid'] ? $params['groupid'] = intval($paramList['groupid']) : false;
            $paramList['username'] ? $params['username'] = $paramList['username'] : false;
            isset($paramList['status']) ? $params['status'] = $paramList['status'] : false;
            $this->setPageParam($params, $paramList['page'], $paramList['limit'], 15);
            $result = $this->rpcClient->getResultRaw('GU004', $params);
        } while (false);
        return (array)$result;
    }

    public function saveUserDataInfo($paramList) {
        $params = $this->initParam($paramList);
        do {
            $checkParams = Enum_Admin::getAdminUserMustInput();
            $result = array(
                'code' => 1,
                'msg' => '参数错误'
            );
            foreach ($checkParams as $checkParamOne) {
                if (empty($params[$checkParamOne])) {
                    break 2;
                }
            }
            if (empty($params['id']) && empty($params['password'])) {
                $result['msg'] = '新建密码不能为空';
                break;
            }
            if ($params['password']) {
                $params['password'] = Enum_Login::getMd5Pass($params['password']);
            }
            $interfaceId = $params['id'] ? 'GU006' : 'GU005';
            $result = $this->rpcClient->getResultRaw($interfaceId, $params);
        } while (false);
        return $result;
    }
}
