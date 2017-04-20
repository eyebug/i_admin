<?php

class Enum_Record {

    const RECORD_VAR = 'recordLog';

    const RECORD_POST_VAR = 'recordLog';

    const RECORD_POST_ID = 'recordDataId';

    const RECORD_ADMIN_TYPE_ID = 1;
    const RECORD_GROUP_TYPE_ID = 2;
    const RECORD_HOTEL_TYPE_ID = 3;

    public static function setRecordData($key, $value) {
        $logData = Yaf_Registry::get(self::RECORD_VAR);
        if ($key && $value) {
            $logData[$key] = $value;
        }
        Yaf_Registry::set(self::RECORD_VAR, $logData);
    }

    private static $adminRecordTilte = array(
        1 => array(
            'title' => '后台系统',
            'action' => array(
                1 => '登录后台',
                2 => '修改登录密码',
            )
        ),
        2 => array(
            'title' => '总后台管理',
            'action' => array(
                1 => '创建帐号',
                2 => '修改帐号',
            )
        ),
        3 => array(
            'title' => '集团后台管理',
            'action' => array(
                1 => '创建集团',
                2 => '修改集团信息',
                3 => '创建帐号',
                4 => '修改帐号',
            )
        ),
        4 => array(
            'title' => '物业后台管理',
            'action' => array(
                1 => '创建物业',
                2 => '修改物业信息',
                3 => '创建帐号',
                4 => '修改帐号',
                5 => '修改物业语言',
            )
        ),
        5 => array(
            'title' => 'APP管理',
            'action' => array(
                1 => '创建启动广告',
                2 => '修改启动广告信息',
                3 => '创建版本',
                4 => '修改版本信息',
                5 => '创建首屏图片',
                6 => '修改首屏图片信息',
                7 => '创建启动消息',
                8 => '修改启动消息信息',
                9 => '创建全员推送',
            )
        ),
    );

    public static function getAdminRecordTitle() {
        return self::$adminRecordTilte;
    }

    private static $groupRecordTilte = array(
        1 => array(
            'title' => '后台系统',
            'action' => array(
                1 => '登录后台',
                2 => '修改登录密码',
            )
        ),
    );

    public static function getGroupRecordTitle() {
        return self::$groupRecordTilte;
    }

    private static $hotelRecordTilte = array(
        1 => array(
            'title' => '后台系统',
            'action' => array(
                1 => '登录后台',
                2 => '修改登录密码',
            )
        ),
    );

    public static function getHotelRecordTitle() {
        return self::$hotelRecordTilte;
    }
}

?>
