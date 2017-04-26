<?php

class Interceptor_RecordConfig {

    private static $config = array(
        'Loginajax' => array(
            'moduleType' => 1,
            'action' => array(
                'dologin' => 1,
                'changepass' => 2
            )
        ),
        'Adminajax' => array(
            'moduleType' => 2,
            'action' => array(
                'craete' => 1,
                'update' => 2
            )
        ),
        'Groupajax' => array(
            'moduleType' => 3,
            'action' => array(
                'creategroup' => 1,
                'updategroup' => 2,
                'createuser' => 3,
                'updateuser' => 4,
            )
        ),
        'Hotelajax' => array(
            'moduleType' => 4,
            'action' => array(
                'createhotel' => 1,
                'updatehotel' => 2,
                'createuser' => 3,
                'updateuser' => 4,
                'updatehotellanglist' => 5,
                'updateuserpermission' => 6,
            )
        ),
        'Appajax' => array(
            'moduleType' => 5,
            'action' => array(
                'createstartpiclist' => 1,
                'updatestartpiclist' => 2,
                'createversion' => 3,
                'updateversion' => 4,
                'createappimg' => 5,
                'upadteappimg' => 6,
                'createstartmsg' => 7,
                'updatestartmsg' => 8,
                'createpush' => 9,
            )
        ),
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
