<?php

/**
 * 用户枚举
 * @author ZXM
 * 2015年7月13日
 */
class Enum_Request {

    const RPC_REQUEST_UA = "YoupuTrip/1.0(rop;)";

    public static function getUrlConfigById($interfaceId) {
        $config = array(
            'B' => 'Rpc_UrlConfigBase',
            'AU' => 'Rpc_UrlConfigAdmin',
            'GU' => 'Rpc_UrlConfigGroup',
            'GH' => 'Rpc_UrlConfigHotel',
        );
        $fileKey = preg_replace('/\d+/', '', $interfaceId);
        $fileNameKey = $config[$fileKey];
        if (empty($fileNameKey)) {
            return false;
        }
        $interfaceConfig = $fileNameKey::getConfig($interfaceId);
        if ($interfaceConfig) {
            return $interfaceConfig;
        } else {
            return false;
        }
    }
}
