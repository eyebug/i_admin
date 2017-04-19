<?php

class Rpc_UrlConfigBase {

    private static $config = array(
        'B001' => array(
            'name' => '获取支持的语言列表',
            'method' => 'getLanguageList',
            'auth' => true,
            'url' => '/system/getLanguageList',
            'param' => array()
        ),
        'B002' => array(
            'name' => '获取城市列表',
            'method' => 'getCityList',
            'auth' => true,
            'url' => '/city/getCityList',
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
        'B003' => array(
            'name' => '上传至oss',
            'method' => 'uploadToOss',
            'auth' => true,
            'url' => '/system/uploadToOss',
            'param' => array(
                'uploadfile' => array(
                    'required' => true,
                    'format' => 'file',
                    'style' => 'interface'
                ),
                'type' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
            )
        ),
        'B004' => array(
            'name' => '获取上传允许的文件类型',
            'method' => 'getAllowUploadFileType',
            'auth' => true,
            'url' => '/system/getAllowUploadFileType',
            'param' => array(
                'type' => array(
                    'required' => true,
                    'format' => 'string',
                    'style' => 'interface'
                ),
            )
        ),
        'B005' => array(
            'name' => '获取设备列表',
            'method' => 'getPlatformList',
            'auth' => true,
            'url' => '/system/getPlatformList',
            'param' => array()
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
