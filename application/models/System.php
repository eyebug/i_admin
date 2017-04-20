<?php

class SystemModel extends \BaseModel {

    public function getOperateLogList($paramList) {
        do {
            $paramList['operatorid'] ? $params['operatorid'] = $paramList['operatorid'] : false;
            $paramList['module'] ? $params['module'] = $paramList['module'] : false;
            $paramList['code'] ? $params['code'] = $paramList['code'] : false;
            $paramList['admintype'] ? $params['admintype'] = $paramList['admintype'] : false;
            $paramList['admintypeid'] ? $params['admintypeid'] = $paramList['admintypeid'] : false;
            $this->setPageParam($params, $paramList['page'], $paramList['limit'], 15);
            $result = $this->rpcClient->getResultRaw('AU007', $params);
        } while (false);
        return (array)$result;
    }
}
