<?php

class Enum_Record {

    const RECORD_VAR = 'recordLog';

    const RECORD_POST_VAR = 'recordLog';

    const RECORD_POST_ID = 'recordDataId';

    const RECORD_ADMIN_TYPE_ID = 1;

    public static function setRecordData($key, $value) {
        $logData = Yaf_Registry::get(self::RECORD_VAR);
        if ($key && $value) {
            $logData[$key] = $value;
        }
        Yaf_Registry::set(self::RECORD_VAR, $logData);
    }
}

?>
