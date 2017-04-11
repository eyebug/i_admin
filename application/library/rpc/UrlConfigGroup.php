<?php

class Rpc_UrlConfigGroup {

    private static $config = array(
        'GU001' => array(
            'name' => '获取列表',
            'method' => 'getUserInfo',
            'auth' => true,
            'url' => 'http://api-dev.easyiservice.com/group/getGroupList',
            'param' => array(
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
        'GU002' => array(
            'name' => '新建集团',
            'method' => 'addGroup',
            'auth' => true,
            'url' => 'http://api-dev.easyiservice.com/group/addGroup',
            'param' => array(
                'name' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'enname' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'porturl' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                )
            )
        ),
        'GU003' => array(
            'name' => '修改集团',
            'method' => 'updateGroupbyId',
            'auth' => true,
            'url' => 'http://api-dev.easyiservice.com/group/updateGroupbyId',
            'param' => array(
                'id' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'name' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'enname' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'porturl' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                )
            )
        ),
        'GU004' => array(
            'name' => '修改集团',
            'method' => 'updateGroupbyId',
            'auth' => true,
            'url' => 'http://api-dev.easyiservice.com/Administrator/getAdministratorList',
            'param' => array(
                'id' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'groupid' => array(
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
        'GU005' => array(
            'name' => '新建管理员',
            'method' => 'addAdministrator',
            'auth' => true,
            'url' => 'http://api-dev.easyiservice.com/Administrator/addAdministrator',
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
                'groupid' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'createadmin' => array(
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
        'GU006' => array(
            'name' => '更新管理员',
            'method' => 'updateAdministratorById',
            'auth' => true,
            'url' => 'http://api-dev.easyiservice.com/Administrator/updateAdministratorById',
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
                    'required' => false,
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
