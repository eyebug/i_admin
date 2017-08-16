<?php

class Enum_App {

    const PUSH_TYPE_ALL = 3;
    const PUSH_CONTENT_TYPE_URL = 'url';

    public static function getStartPicMustInput() {
        return array(
            'link',
        );
    }

    public static function getVersionMustInput() {
        return array(
            'version',
            'description',
            'platform',
        );
    }

    public static function getAppImgMustInput() {
        return array();
    }

    public static function getStartMsgMustInput() {
        return array(
            'type',
            'url',
        );
    }

    public static function getPushMustInput() {
        return array(
            'cn_title',
            'en_title',
            'url',
        );
    }
}

?>