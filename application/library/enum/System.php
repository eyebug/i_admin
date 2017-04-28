<?php

class Enum_System {

    const RPC_REQUEST_PACKAGE = 'ia';

    const SYSTEM_NAME = 'EASYISERVICE管理后台';

    const SERVICE_API_DOMAIN = 'http://testapi.liheinfo.com';

    //    const SERVICE_API_DOMAIN = 'http://api-dev.easyiservice.com';

    public static function getServiceApiUrlByLink($url) {
        $url = strpos('http', $url) ? $url : self::SERVICE_API_DOMAIN . $url;
        return $url;
    }
}

?>