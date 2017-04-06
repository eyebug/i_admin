<?php
class Rpc_Curl {
    /**
     * 
     * @param string $url
     * @param string $method get post
     * @param unknown_type $postData
     * @param unknown_type $timeOut
     * @return mixed
     */
    public static function _request($url, $method = 'GET', $postData = '', $timeOut = 2, $imgSize = '') {
        $handle = curl_init ();
        curl_setopt ( $handle, CURLOPT_URL, $url );
        curl_setopt ( $handle, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $handle, CURLOPT_USERAGENT, Enum_Request::RPC_REQUEST_UA );
        curl_setopt ( $handle, CURLOPT_TIMEOUT, $timeOut );
        curl_setopt ( $handle, CURLOPT_CUSTOMREQUEST, $method );
        curl_setopt ( $handle, CURLOPT_FOLLOWLOCATION, 1 );
        if ($imgSize) {
            $ypimg = urlencode(json_encode($imgSize));
            curl_setopt ( $handle, CURLOPT_HTTPHEADER, array("ypimg:$ypimg"));
        }
        if (! empty ( $postData )){
            curl_setopt ( $handle, CURLOPT_POSTFIELDS, $postData );
        }
        $result['response'] = curl_exec ( $handle );
        $result['httpStatus'] = curl_getinfo ( $handle, CURLINFO_HTTP_CODE );
        $result['fullInfo'] = curl_getinfo ( $handle );
        curl_close ( $handle );
        
        return $result;
    }
}
