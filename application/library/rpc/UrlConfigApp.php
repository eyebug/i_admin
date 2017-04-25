<?php

class Rpc_UrlConfigApp {

    private static $config = array(
        'APP001' => array(
            'name' => '获取APP广告图列表',
            'method' => 'getAppstartPicList',
            'auth' => true,
            'url' => '/AppstartPic/getAppstartPicList',
            'param' => array(
                'id' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'status' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'page' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'limit' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
            )
        ),
        'APP002' => array(
            'name' => '新建APP广告图列表',
            'method' => 'getAppstartPicList',
            'auth' => true,
            'url' => '/AppstartPic/addAppstartPic',
            'param' => array(
                'link' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'pic' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'status' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
            )
        ),
        'APP003' => array(
            'name' => '更新APP广告图列表',
            'method' => 'updateAppstartPicById',
            'auth' => true,
            'url' => '/AppstartPic/updateAppstartPicById',
            'param' => array(
                'id' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'link' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'pic' => array(
                    'required' => false,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'status' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
            )
        ),
        'APP004' => array(
            'name' => '获取APP广告图列表',
            'method' => 'getAppVersionList',
            'auth' => true,
            'url' => '/AppVersion/getAppVersionList',
            'param' => array(
                'id' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'platform' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'forced' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'latest' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'page' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'limit' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
            )
        ),
        'APP005' => array(
            'name' => '新建APP版本',
            'method' => 'addAppVersion',
            'auth' => true,
            'url' => '/AppVersion/addAppVersion',
            'param' => array(
                'platform' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'forced' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'version' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'description' => array(
                    'required' => false,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'latest' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
            )
        ),
        'APP006' => array(
            'name' => '更新APP版本',
            'method' => 'updateAppVersionById',
            'auth' => true,
            'url' => '/AppVersion/updateAppVersionById',
            'param' => array(
                'id' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'platform' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'forced' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'version' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'description' => array(
                    'required' => false,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'latest' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
            )
        ),
        'APP007' => array(
            'name' => '获取首屏图列表',
            'method' => 'getAppImgList',
            'auth' => true,
            'url' => '/AppImg/getAppImgList',
            'param' => array(
                'id' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'status' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'page' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'limit' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
            )
        ),
        'APP008' => array(
            'name' => '新建APP启动图',
            'method' => 'addAppImg',
            'auth' => true,
            'url' => '/AppImg/addAppImg',
            'param' => array(
                'pickey' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'status' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
            )
        ),
        'APP009' => array(
            'name' => '更新APP启动图',
            'method' => 'updateAppImgById',
            'auth' => true,
            'url' => '/AppImg/updateAppImgById',
            'param' => array(
                'id' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'pickey' => array(
                    'required' => false,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'status' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
            )
        ),
        'APP010' => array(
            'name' => '获取APP启动消息列表',
            'method' => 'getAppstartPicList',
            'auth' => true,
            'url' => '/appStartMsg/getAppstartMsgList',
            'param' => array(
                'id' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'type' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'dataid' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'status' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'page' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'limit' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
            )
        ),
        'APP011' => array(
            'name' => '新建APP启动消息',
            'method' => 'addAppstartMsg',
            'auth' => true,
            'url' => '/appStartMsg/addAppstartMsg',
            'param' => array(
                'type' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'dataid' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'pic' => array(
                    'required' => false,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'msg' => array(
                    'required' => false,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'url' => array(
                    'required' => false,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'status' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
            )
        ),
        'APP012' => array(
            'name' => '更新APP启动消息',
            'method' => 'updateAppstartMsgById',
            'auth' => true,
            'url' => '/appStartMsg/updateAppstartMsgById',
            'param' => array(
                'id' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'type' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'dataid' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'pic' => array(
                    'required' => false,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'msg' => array(
                    'required' => false,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'url' => array(
                    'required' => false,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'status' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
            )
        ),
        'APP013' => array(
            'name' => '获取APP推送列表',
            'method' => 'getPushList',
            'auth' => true,
            'url' => '/push/getPushList',
            'param' => array(
                'id' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'type' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'result' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'platform' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'page' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'limit' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
            )
        ),
        'APP014' => array(
            'name' => '添加APP推送',
            'method' => 'addPush',
            'auth' => true,
            'url' => '/push/addPush',
            'param' => array(
                'platform' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'type' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'cn_title' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'cn_value' => array(
                    'required' => false,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'en_title' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'en_value' => array(
                    'required' => false,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'url' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
            )
        ),
        'APP015' => array(
            'name' => '获取APP反馈列表',
            'method' => 'getIserviceFeedbackList',
            'auth' => true,
            'url' => '/IserviceFeedback/getIserviceFeedbackList',
            'param' => array(
                'id' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'email' => array(
                    'required' => false,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'page' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'limit' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
            )
        ),
    );

    /**
     * 根据接口编号获取接口配置
     *
     * @param string $interfaceId
     * @param string $configKey
     * @return multitype:multitype:string multitype:multitype:boolean string
     *         |boolean
     */
    public static function getConfig($interfaceId, $configKey = '') {
        if (isset(self::$config[$interfaceId])) {
            if (strlen($configKey) && isset(self::$config[$interfaceId][$configKey])) {
                return self::$config[$interfaceId][$configKey];
            } else {
                return self::$config[$interfaceId];
            }
        } else {
            return false;
        }
    }
}
