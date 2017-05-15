<?php

/**
 * 集团Model
 */
class GroupModel extends \BaseModel {

    /**
     * 获取集团列表
     */
    public function getGroupList($paramList, $cacheTime = 0) {
        do {
            if ($cacheTime == 0) {
                $this->setPageParam($params, $paramList['page'], $paramList['limit'], 15);
            } else {
                $params['limit'] = 0;
            }
            $isCache = $cacheTime != 0 ? true : false;
            $result = $this->rpcClient->getResultRaw('GU001', $params, $isCache, $cacheTime);
        } while (false);
        return (array)$result;
    }

    /**
     * 新建和编辑集团信息数据
     */
    public function saveGroupDataInfo($paramList) {
        $params = $this->initParam($paramList);
        do {
            $checkParams = Enum_Group::getGroupMustInput();
            $result = array(
                'code' => 1,
                'msg' => '参数错误'
            );
            foreach ($checkParams as $checkParamOne) {
                if (empty($params[$checkParamOne])) {
                    break 2;
                }
            }
            $interfaceId = $params['id'] ? 'GU003' : 'GU002';
            $result = $this->rpcClient->getResultRaw($interfaceId, $params);
            //更新或者新建集团成功后更新全量集团列表缓存
            if (!$result['code']) {
                $this->getGroupList(array(), -2);
            }
        } while (false);
        return $result;
    }

    /**
     * 获取用户列表
     */
    public function getUserList($paramList, $cacheTime = 0) {
        do {
            if ($cacheTime == 0) {
                $paramList['id'] ? $params['id'] = $paramList['id'] : false;
                $paramList['groupid'] ? $params['groupid'] = intval($paramList['groupid']) : false;
                $paramList['username'] ? $params['username'] = $paramList['username'] : false;
                isset($paramList['status']) ? $params['status'] = $paramList['status'] : false;
                $this->setPageParam($params, $paramList['page'], $paramList['limit'], 15);
            } else {
                $params['limit'] = 0;
            }
            $isCache = $cacheTime != 0 ? true : false;
            $result = $this->rpcClient->getResultRaw('GU004', $params, $isCache, $cacheTime);
        } while (false);
        return (array)$result;
    }

    /**
     * 新建和编辑集团管理员数据
     */
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
            } else {
                unset($params['password']);
            }
            $interfaceId = $params['id'] ? 'GU006' : 'GU005';
            $result = $this->rpcClient->getResultRaw($interfaceId, $params);
            if (!$result['code']) {
                $this->getUserList(array(), -2);
            }
        } while (false);
        return $result;
    }
}
