<?php

class Rpc_UrlConfigRss {

    private static $config = array(
        'R001' => array(
            'name' => '获取RSS类别列表',
            'method' => 'getRssTypeList',
            'auth' => true,
            'url' => '/RssType/getRssTypeList',
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
                ),
            )
        ),
        'R002' => array(
            'name' => '添加RSS类别信息',
            'method' => 'addRssType',
            'auth' => true,
            'url' => '/RssType/addRssType',
            'param' => array(
                'title' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
            )
        ),
        'R003' => array(
            'name' => '根据id修改RSS类别信息',
            'method' => 'updateRssTypeById',
            'auth' => true,
            'url' => '/RssType/updateRssTypeById',
            'param' => array(
                'id' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'title' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
            )
        ),
        'R004' => array(
            'name' => '根据id修改RSS类别信息',
            'method' => 'updateRssTypeById',
            'auth' => true,
            'url' => '/Rss/getRssList',
            'param' => array(
                'id' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'typeid' => array(
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
        'R005' => array(
            'name' => '添加RSS信息',
            'method' => 'addRss',
            'auth' => true,
            'url' => '/Rss/addRss',
            'param' => array(
                'name_zh' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'name_en' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'rss' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'typeid' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'status' => array(
                    'required' => false,
                    'format' => 'int',
                    'style' => 'interface'
                ),
            )
        ),
        'R006' => array(
            'name' => '根据id修改RSS信息',
            'method' => 'updateRssById',
            'auth' => true,
            'url' => '/Rss/updateRssById',
            'param' => array(
                'id' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'name_zh' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'name_en' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'rss' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
                'typeid' => array(
                    'required' => true,
                    'format' => 'int',
                    'style' => 'interface'
                ),
                'status' => array(
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
