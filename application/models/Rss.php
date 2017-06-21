<?php

/**
 * RSS管理
 */
class RssModel extends \BaseModel {

    /**
     * 获取RSS类型列表
     */
    public function getTypeList($paramList, $cacheTime = 0) {
        do {
            if ($cacheTime == 0) {
                $this->setPageParam($params, $paramList['page'], $paramList['limit'], 15);
            } else {
                $params['limit'] = 0;
            }
            $isCache = $cacheTime != 0 ? true : false;
            $result = $this->rpcClient->getResultRaw('R001', $params, $isCache, $cacheTime);
        } while (false);
        return (array)$result;
    }

    /**
     * 新建和编辑RSS类型
     */
    public function saveTypeDataInfo($paramList) {
        $params = $this->initParam($paramList);
        do {
            $checkParams = Enum_Rss::getRssTypeMustInput();
            $result = array(
                'code' => 1,
                'msg' => '参数错误'
            );
            foreach ($checkParams as $checkParamOne) {
                if (empty($params[$checkParamOne])) {
                    break 2;
                }
            }
            $interfaceId = $params['id'] ? 'R003' : 'R002';
            $result = $this->rpcClient->getResultRaw($interfaceId, $params);
            if (!$result['code']) {
                $this->getTypeList(array(), -2);
            }
        } while (false);
        return $result;
    }

    /**
     * 获取RSS列表
     */
    public function getRssList($paramList) {
        do {
            $paramList['id'] ? $params['id'] = $paramList['id'] : false;
            $paramList['typeid'] ? $params['typeid'] = $paramList['typeid'] : false;
            isset($paramList['status']) ? $params['status'] = $paramList['status'] : false;
            $this->setPageParam($params, $paramList['page'], $paramList['limit'], 15);
            $result = $this->rpcClient->getResultRaw('R004', $params);
        } while (false);
        return (array)$result;
    }

    /**
     * 新建和编辑RSS
     */
    public function saveRssDataInfo($paramList) {
        $params = $this->initParam($paramList);
        do {
            $checkParams = Enum_Rss::getRssMustInput();
            $result = array(
                'code' => 1,
                'msg' => '参数错误'
            );
            foreach ($checkParams as $checkParamOne) {
                $checkParamOne = $checkParamOne == 'namezh' ? 'name_zh' : $checkParamOne;
                $checkParamOne = $checkParamOne == 'nameen' ? 'name_en' : $checkParamOne;
                if (empty($params[$checkParamOne])) {
                    break 2;
                }
            }
            $interfaceId = $params['id'] ? 'R006' : 'R005';
            $result = $this->rpcClient->getResultRaw($interfaceId, $params);
        } while (false);
        return $result;
    }
}
