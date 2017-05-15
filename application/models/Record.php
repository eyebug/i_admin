<?php

/**
 * 操作日志Model
 */
class RecordModel extends BaseModel {

    /**
     * 新增操作日志
     */
    public function addOperateLog($paramList) {
        $params = $this->initParam(array());
        do {
            $params['operatorid'] = $paramList['adminId'];
            $params['msg'] = $paramList['log'];
            $params['dataid'] = $paramList['dataId'];
            $params['module'] = intval($paramList['module']);
            $params['action'] = intval($paramList['action']);
            $params['ip'] = Util_Http::getIP();
            $params['miscinfo'] = $paramList['otherInfo'];
            $params['code'] = $paramList['code'];
            $params['admintype'] = Enum_Record::RECORD_ADMIN_TYPE_ID;
            if (empty($params['operatorid'])) {
                $result = array(
                    'code' => 1,
                    'msg' => 'ID不能为空'
                );
                break;
            }
            $result = $this->rpcClient->getResultRaw('AU002', $params);
        } while (false);
        return (array)$result;
    }
}