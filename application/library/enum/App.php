<?php

class Enum_App {

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
}

?>