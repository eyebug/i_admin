<?php

/**
 * APP用户管理数据转换
 */
class Convertor_User extends Convertor_Base {

    /**
     * 用户列表
     * @param $list
     * @return array
     */
    public function userListConvertor($list) {
        $data = array(
            'code' => intval($list['code']),
            'msg' => $list['msg']
        );
        if (isset($list['code']) && !$list['code']) {
            $result = $list['data'];
            $tmp = array();
            foreach ($result['list'] as $key => $value) {
                $dataTemp = array();
                $dataTemp['id'] = $value['id'];
                $dataTemp['roomNo'] = $value['room_no'];
                $dataTemp['hotel'] = $value['hotelName'];
                $dataTemp['group'] = $value['groupName'];
                $dataTemp['oid'] = $value['oid'];
                $dataTemp['fullname'] = $value['fullname'];
                $dataTemp['platform'] = $value['platformName'];
                $dataTemp['identity'] = $value['identity'];
                $dataTemp['language'] = $value['languageName'];
                $dataTemp['createtime'] = $value['createtime'] ? date('Y-m-d H:i:s', $value['createtime']) : '';
                $dataTemp['lastlogintime'] = $value['lastlogintime'] ? date('Y-m-d H:i:s', $value['lastlogintime']) : '';
                $dataTemp['lastloginip'] = $value['lastloginip'] ? Util_Tools::ntoip($value['lastloginip']) : '';
                $tmp[] = $dataTemp;
            }
            $data['data']['list'] = $tmp;
            $data['data']['pageData']['page'] = intval($result['page']);
            $data['data']['pageData']['rowNum'] = intval($result['total']);
            $data['data']['pageData']['pageNum'] = ceil($result['total'] / $result['limit']);
        }
        return $data;
    }
}

?>