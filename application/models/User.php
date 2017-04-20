<?php

class UserModel extends \BaseModel {

    public function getUserList($paramList) {
        do {
            $paramList['id'] ? $params['id'] = $paramList['id'] : false;
            $paramList['room_no'] ? $params['room_no'] = $paramList['room_no'] : false;
            $paramList['fullname'] ? $params['fullname'] = $paramList['fullname'] : false;
            $paramList['hotelid'] ? $params['hotelid'] = $paramList['hotelid'] : false;
            $paramList['groupid'] ? $params['groupid'] = $paramList['groupid'] : false;
            $paramList['oid'] ? $params['oid'] = $paramList['oid'] : false;
            $this->setPageParam($params, $paramList['page'], $paramList['limit'], 15);
            $result = $this->rpcClient->getResultRaw('U001', $params);
        } while (false);
        return (array)$result;
    }

}
