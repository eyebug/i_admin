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
                6 => '修改帐号权限'
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
        2 => array(
            'title' => '集团管理',
            'action' => array(
                1 => '创建集团帐号',
                2 => '修改集团帐号',
            )
        ),
        3 => array(
            'title' => 'APP管理',
            'action' => array(
                1 => '创建启动消息',
                2 => '修改启动消息信息',
                3 => '创建集团推送',
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
        2 => array(
            'title' => '物业管理',
            'action' => array(
                1 => '登录后台',
                2 => '新建楼层',
                3 => '修改楼层信息',
                4 => '新建设施',
                5 => '修改设施信息',
                6 => '新建交通',
                7 => '修改交通信息',
                8 => '新建全景',
                9 => '修改全景信息',
                10 => '新建物业图片',
                11 => '修改物业图片信息',
                12 => '新建多语言标题',
                13 => '修改多语言标题信息',
            )
        ),
        3 => array(
            'title' => '活动管理',
            'action' => array(
                1 => '新建标签',
                2 => '修改标签信息',
                3 => '新建活动',
                4 => '修改活动信息',
            )
        ),
        4 => array(
            'title' => '雅士阁生活管理',
            'action' => array(
                1 => '新建标签',
                2 => '修改标签信息',
                3 => '新建雅士阁生活',
                4 => '修改雅士阁生活信息',
            )
        ),
        5 => array(
            'title' => '本地攻略管理',
            'action' => array(
                1 => '新建标签',
                2 => '修改标签信息',
                3 => '新建本地攻略',
                4 => '修改本地攻略信息',
            )
        ),
        6 => array(
            'title' => '物业促销管理',
            'action' => array(
                1 => '新建标签',
                2 => '修改标签信息',
                3 => '新建物业促销',
                4 => '修改物业促销信息',
            )
        ),
        7 => array(
            'title' => '客房管理',
            'action' => array(
                1 => '新建客房物品',
                2 => '修改客房物品信息',
                3 => '新建房型',
                4 => '修改房型信息',
                5 => '修改房型物品信息',
            )
        ),
        8 => array(
            'title' => '体验购物管理',
            'action' => array(
                1 => '新建标签',
                2 => '修改标签信息',
                3 => '新建体验购物',
                4 => '修改体验购物信息',
            )
        ),
        9 => array(
            'title' => '电话黄页管理',
            'action' => array(
                1 => '新建分类',
                2 => '修改分类信息',
                3 => '新建号码',
                4 => '修改号码信息',
            )
        ),
        10 => array(
            'title' => '物业新闻管理',
            'action' => array(
                1 => '新建标签',
                2 => '修改标签信息',
                3 => '新建物业新闻',
                4 => '修改物业新闻信息',
            )
        ),
        11 => array(
            'title' => '物业通知管理',
            'action' => array(
                1 => '新建标签',
                2 => '修改标签信息',
                3 => '新建物业通知',
                4 => '修改物业通知信息',
            )
        ),
        12 => array(
            'title' => '调查反馈管理',
            'action' => array(
                1 => '新建反馈问题',
                2 => '修改反馈问题信息',
                3 => '修改反馈问题选项',
            )
        ),
        13 => array(
            'title' => 'APP管理',
            'action' => array(
                1 => '新建物业推送',
                2 => '新建快捷入口',
                3 => '修改快捷入口信息',
                4 => 'APP分享平台设置',
            )
        ),
    );

    public static function getHotelRecordTitle() {
        return self::$hotelRecordTilte;
    }
}

?>
