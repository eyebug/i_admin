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
                ),
                'ip' => array(
                    'required' => false,
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
        ),
        'AU003' => array(
            'name' => '修改登录密码',
            'method' => 'changePass',
            'auth' => true,
            'url' => 'http://api-dev.easyiservice.com/IserviceAdministrator/changePass',
            'param' => array(
                'userid' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'oldpass' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'newpass' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                )
            )
        ),
        'AU004' => array(
            'name' => '获取帐号列表',
            'method' => 'getIserviceAdministratorList',
            'auth' => true,
            'url' => 'http://api-dev.easyiservice.com/IserviceAdministrator/getIserviceAdministratorList',
            'param' => array(
                'id' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'username' => array(
                    'required' => false,
                    'format' => 'string',
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
                )
            )
        ),
        'AU005' => array(
            'name' => '新建管理员',
            'method' => 'addIserviceAdministrator',
            'auth' => true,
            'url' => 'http://api-dev.easyiservice.com/IserviceAdministrator/addIserviceAdministrator',
            'param' => array(
                'username' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'realname' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'password' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'status' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'remark' => array(
                    'required' => false,
                    'format' => 'string',
                    'style' => 'interface'
                )
            )
        ),
        'AU006' => array(
            'name' => '更新管理员',
            'method' => 'updateIserviceAdministratorById',
            'auth' => true,
            'url' => 'http://api-dev.easyiservice.com/IserviceAdministrator/updateIserviceAdministratorById',
            'param' => array(
                'id' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'username' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'realname' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'password' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'status' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'remark' => array(
                    'required' => false,
                    'format' => 'string',
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
