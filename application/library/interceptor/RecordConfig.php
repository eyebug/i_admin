<?php

class Interceptor_RecordConfig {

    private static $config = array(
        'Loginajax' => array(
            'moduleType' => 1,
            'action' => array(
                'dologin' => 1
            )
        )
    );

    /**
     * 获取拦截器配置
     *
     * @return array
     */
    public static function getConfig() {
        return self::$config;
    }
}

?>
