<?php

/**
 * Class LoginController
 * @author ZXM
 */
class LoginController extends \BaseController {

    /**
     * 登陆页面
     * ---
     */
    public function indexAction() {
        if (Auth_Login::checkLogin()) {
            Util_Tools::redirect("/");
        }
        $this->_view->display('login/index.phtml');
    }

    /**
     * 退出登陆
     * ---
     */
    public function logoutAction() {
        $loginModel = new LoginModel();
        if ($loginModel->loginOut()) {
            Util_Tools::scriptRedirect('/Login');
        } else {
            Util_Tools::alert('退出登陆失败！');
        }
    }

    public function changePassAction() {
        $this->_view->assign('userId', $this->userInfo['id']);
        $this->_view->display('login/changePass.phtml');
    }
}
