<?php

/**
 * 登录请求
 */
class LoginajaxController extends \BaseController {

    /**
     * 处理登录
     */
    public function doLoginAction() {
        $request = $this->getRequest();
        $paramList['username'] = $request->getPost('username');
        $paramList['password'] = $request->getPost('password');

        $model = new LoginModel();
        $result = $model->doLogin($paramList);
        $this->echoJson($result);
    }

    /**
     * 处理密码修改
     */
    public function changePassAction() {
        $paramList['userId'] = $this->userInfo['id'];
        $paramList['oldPass'] = $this->getPost('oldPass');
        $paramList['newPass'] = $this->getPost('newPass');

        $loginModel = new LoginModel();
        $result = $loginModel->changePass($paramList);
        $this->echoJson($result);
    }
}
