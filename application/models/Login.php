<?php

class LoginModel extends \BaseModel {

    /**
     * 获取登陆用户信息
     * ---
     *
     * @param $username 用户名            
     * @param $password 密码            
     * @return array
     */
    public function getUserInfo($paramList) {
        $params = $this->initParam($paramList);
        
        do {
            $params['username'] = trim($paramList['username']);
            $params['password'] = trim($paramList['password']);
            
            if (! $params['username'] || ! $params['password']) {
                $result = array(
                    'code' => 1,
                    'msg' => '用户名或密码不能为空！'
                );
                break;
            }
            $params['password'] = Enum_Login::getMd5Pass($params['password']);
            $params['ip'] = Util_Http::getIP();
            $result = $this->rpcClient->getResultRaw('AU001', $params);
        } while (false);
        return $result;
    }

    /**
     * 执行登录
     *
     * @param array $paramList            
     * @return Ambigous <multitype:number string , multitype:>
     */
    public function doLogin($paramList) {
        do {
            $result = $this->getUserInfo($paramList);
            if ($result['code']) {
                break;
            }
            $userInfo = $result['data'];
            $errorResult = array(
                'code' => 1,
                'msg' => '登录失败'
            );
            if (empty($userInfo['id'])) {
                $result = $errorResult;
                break;
            }
            $auth = Auth_Login::genSIdAndAId($userInfo['id']);
            $userInfo['sId'] = $auth['sId'];
            $key = Auth_Login::genLoginMemKey($auth['sId'], $auth['aId']);
            $cache = Cache_Redis::getInstance();
            if (! $cache->set($key, json_encode($userInfo), Enum_Login::LOGIN_TIMEOUT)) {
                $result = $errorResult;
                break;
            }
            $cookieTime = time() + Enum_Login::LOGIN_TIMEOUT;
            if (! Util_Http::setCookie(Enum_Login::LOGIN_INFO_COOKIE_KEY_AID, $auth['aId'], $cookieTime)) {
                $result = $errorResult;
                break;
            }
            if (! Util_Http::setCookie(Enum_Login::LOGIN_INFO_COOKIE_KEY_SID, $auth['sId'], $cookieTime)) {
                $result = $errorResult;
                break;
            }
            $result['data']['insertId'] = $result['data']['id'];
            Enum_Record::setRecordData('adminId', $result['data']['id']);
        } while (false);
        return $result;
    }

    /**
     * 退出登录
     *
     * @return boolean
     */
    public function loginOut() {
        if ($loginInfo = Auth_Login::checkLogin()) {
            $sId = Util_Http::getCookie(Enum_Login::LOGIN_INFO_COOKIE_KEY_SID);
            $aId = Util_Http::getCookie(Enum_Login::LOGIN_INFO_COOKIE_KEY_AID);
            if ($sId && $aId) {
                $memKey = Auth_Login::genLoginMemKey($sId, $aId);
                Cache_Redis::getInstance()->delete($memKey);
            }
            Util_Http::setCookie(Enum_Login::LOGIN_INFO_COOKIE_KEY_SID, '', time());
            Util_Http::setCookie(Enum_Login::LOGIN_INFO_COOKIE_KEY_AID, '', time());
            return true;
        }
    }

    /**
     * 修改用户密码
     * ---
     *
     * @param $oldPass 原密码            
     * @param $newPass 新密码            
     * @return array
     */
    public function changePass($paramList) {
        $params = $this->initParam($paramList);
        
        do {
            $params['userid'] = intval($paramList['userId']);
            $params['oldpass'] = trim($paramList['oldPass']);
            $params['newpass'] = trim($paramList['newPass']);
            
            if (! $params['userid'] || ! $params['oldpass'] || ! $params['newpass']) {
                $result = array(
                    'code' => 1,
                    'msg' => '参数错误'
                );
                break;
            }
            $params['oldpass'] = Enum_Login::getMd5Pass($params['oldpass']);
            $params['newpass'] = Enum_Login::getMd5Pass($params['newpass']);
            $result = $this->rpcClient->getResultRaw('AU003', $params);
        } while (false);
        return $result;
    }
}
