<?php

/**
 * 物业管理数据转换
 */
class Convertor_Hotel extends Convertor_Base {

    /**
     * 物业列表
     * @param $list
     * @return array
     */
    public function hotelListConvertor($list) {
        $data = array(
            'code' => intval($list['code']),
            'msg' => $list['msg']
        );
        if (isset($list['code']) && !$list['code']) {
            $baseModel = new BaseModel();
            $languageList = $baseModel->getLanguageList();

            $result = $list['data'];
            $tmp = array();
            foreach ($result['list'] as $key => $value) {
                $dataTemp = array();
                $dataTemp['id'] = $value['id'];
                $dataTemp['groupid'] = $value['groupid'];
                $dataTemp['groupName'] = $value['groupName'];
                $dataTemp['propertyinterfid'] = $value['propertyinterfid'];
                $dataTemp['lng'] = $value['lng'];
                $dataTemp['lat'] = $value['lat'];
                $dataTemp['cityid'] = $value['cityid'];
                $dataTemp['cityName'] = $value['cityName'];
                $dataTemp['tel'] = $value['tel'];
                $dataTemp['name_lang1'] = $value['name_lang1'];
                $dataTemp['name_lang2'] = $value['name_lang2'];
                $dataTemp['name_lang3'] = $value['name_lang3'];
                $dataTemp['website'] = $value['website'];
                $dataTemp['logo'] = Enum_Img::getPathByKeyAndType($value['logo']);
                $dataTemp['index_background'] = Enum_Img::getPathByKeyAndType($value['index_background']);
                $dataTemp['listpic'] = Enum_Img::getPathByKeyAndType($value['listpic']);
                $dataTemp['voice_lang1'] = Enum_Img::getPathByKeyAndType($value['voice_lang1']);
                $dataTemp['voice_lang2'] = Enum_Img::getPathByKeyAndType($value['voice_lang2']);
                $dataTemp['voice_lang3'] = Enum_Img::getPathByKeyAndType($value['voice_lang3']);
                $dataTemp['address_lang1'] = $value['address_lang1'];
                $dataTemp['address_lang2'] = $value['address_lang2'];
                $dataTemp['address_lang3'] = $value['address_lang3'];
                $dataTemp['introduction_lang1'] = $value['introduction_lang1'];
                $dataTemp['introduction_lang2'] = $value['introduction_lang2'];
                $dataTemp['introduction_lang3'] = $value['introduction_lang3'];
                $dataTemp['status'] = $value['status'];
                $dataTemp['statusShow'] = $value['status'] ? '启用' : '禁用';
                $langList = explode(",", $value['lang_list']);
                $dataTemp['langlist'] = $value['lang_list'];
                $dataTemp['langListShow'] = array();
                foreach ($langList as $langId) {
                    $dataTemp['langListShow'][] = $languageList[$langId];
                }
                $dataTemp['langListShow'] = implode(',', $dataTemp['langListShow']);
                $dataTemp['bookurl'] = $value['bookurl'];
                $tmp[] = $dataTemp;
            }
            $data['data']['list'] = $tmp;
            $data['data']['pageData']['page'] = intval($result['page']);
            $data['data']['pageData']['rowNum'] = intval($result['total']);
            $data['data']['pageData']['pageNum'] = ceil($result['total'] / $result['limit']);
        }
        return $data;
    }

    /**
     * 物业管理员列表
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
                $dataTemp['userName'] = $value['userName'];
                $dataTemp['realName'] = $value['realName'];
                $dataTemp['remark'] = $value['remark'];
                $dataTemp['status'] = $value['status'];
                $dataTemp['hotelId'] = $value['hotelId'];
                $dataTemp['hotelName'] = $value['hotelName'];
                $dataTemp['groupId'] = $value['groupId'];
                $dataTemp['groupName'] = $value['groupName'];
                $dataTemp['permission'] = $value['permission'];
                $dataTemp['statusShow'] = $value['status'] ? '启用' : '禁用';
                $dataTemp['createTime'] = $value['createTime'] ? date('Y-m-d H:i:s', $value['createTime']) : '';
                $dataTemp['lastLoginTime'] = $value['lastLoginTime'] ? date('Y-m-d H:i:s', $value['lastLoginTime']) : '';
                $dataTemp['lastLoginIp'] = $value['lastLoginIp'] ? Util_Tools::ntoip($value['lastLoginIp']) : '';
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