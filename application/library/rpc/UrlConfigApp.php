<?php

class Rpc_UrlConfigApp {

    private static $config = array(
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
