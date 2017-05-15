<?php

/**
 * 系统管理数据转换
 */
class Convertor_System extends Convertor_Base {

    /**
     * 操作日志列表
     * @param $list
     * @return array
     */
    public function operateLogListConvertor($list) {
        $data = array(
            'code' => intval($list['code']),
            'msg' => $list['msg']
        );
        if (isset($list['code']) && !$list['code']) {
            $result = $list['data'];
            $tmp = array();
            $adminRecordList = Enum_Record::getAdminRecordTitle();
            $groupRecordList = Enum_Record::getGroupRecordTitle();
            $hotelRecordList = Enum_Record::getHotelRecordTitle();
            foreach ($result['list'] as $key => $value) {
                $dataTemp = array();
                $dataTemp['id'] = $value['id'];
                $dataTemp['operator'] = $value['operatorName'];
                $dataTemp['dataid'] = $value['dataid'];
                $dataTemp['msg'] = $value['msg'];
                $dataTemp['addtime'] = $value['addtime'] ? date('Y-m-d H:i:s', $value['addtime']) : '';
                $miscinfo = json_decode($value['miscinfo'], true);
                $dataTemp['result'] = $value['code'] ? '失败' : '成功';
                $dataTemp['resultMsg'] = $miscinfo['msg'];
                $dataTemp['ip'] = Util_Tools::ntoip($value['ip']);
                $dataTemp['hotel'] = $value['hotelName'];
                $dataTemp['group'] = $value['groupName'];
                switch ($value['admintype']) {
                    case Enum_Record::RECORD_ADMIN_TYPE_ID:
                        $dataTemp['module'] = $adminRecordList[$value['module']]['title'];
                        $dataTemp['action'] = $adminRecordList[$value['module']]['action'][$value['action']];
                        break;
                    case Enum_Record::RECORD_GROUP_TYPE_ID:
                        $dataTemp['module'] = $groupRecordList[$value['module']]['title'];
                        $dataTemp['action'] = $groupRecordList[$value['module']]['action'][$value['action']];
                        break;
                    case Enum_Record::RECORD_HOTEL_TYPE_ID:
                        $dataTemp['module'] = $hotelRecordList[$value['module']]['title'];
                        $dataTemp['action'] = $hotelRecordList[$value['module']]['action'][$value['action']];
                        break;
                }
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