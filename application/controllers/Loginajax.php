<?php

class LoginajaxController extends \BaseController {

    /**
     * 登陆请求
     */
    public function doLoginAction() {
        $request = $this->getRequest();
        $paramList['username'] = $request->getPost('username');
        $paramList['password'] = $request->getPost('password');
        
        $model = new LoginModel();
        $result = $model->doLogin($paramList);
        $this->echoJson($result);
    }

    public function changePassAction() {
        $paramList['userId'] = $this->userInfo['id'];
        $paramList['oldPass'] = $this->getPost('oldPass');
        $paramList['newPass'] = $this->getPost('newPass');
        
        $loginModel = new LoginModel();
        $result = $loginModel->changePass($paramList);
        $this->echoJson($result);
    }
}
