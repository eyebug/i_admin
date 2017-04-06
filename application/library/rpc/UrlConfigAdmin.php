<?php

class Rpc_UrlConfigAdmin {

    private static $config = array(
        'AU001' => array(
            'name' => '后台登录',
            'method' => 'getUserInfo',
            'auth' => true,
            'url' => 'http://api-dev.easyiservice.com/IserviceAdministrator/login',
            'param' => array(
                'username' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'password' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                )
            )
        ),
        'AU002' => array(
            'name' => '新增后台操作日志',
            'method' => 'addOperateLog',
            'auth' => true,
            'url' => 'http://api-dev.easyiservice.com/OperateLog/addOperateLog',
            'param' => array(
                'operatorid' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'dataid' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'code' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'msg' => array(
                    'required' => false,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'module' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'action' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'ip' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'miscinfo' => array(
                    'required' => false,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'admintype' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                )
            )
        )
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
