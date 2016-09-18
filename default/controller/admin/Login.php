<?php
class PzkAdminLoginController extends PzkController {


    public function indexAction(){
        //$this->layout();

        if(pzk_request()->is('POST')){
            $post = pzk_request()->query;
            $user = $this->fillter($post["username"]);
            $pass = $this->fillter($post["password"]);
            $usermodel = pzk_model('admin');
            $checkLogin = $usermodel->login($user, $pass);
			
            if(isset($checkLogin)) {
                pzk_session('adminUser', $checkLogin['username']);
                pzk_session('adminId', $checkLogin['id']);
                pzk_session('adminLevel', $checkLogin['level']);
                $this->redirect('admin_home/index');
				debug($checkLogin);die();
            }else {
                pzk_notifier_add_message('Tên đăng nhập or mật khẩu không đúng', 'danger');
                $this->redirect('admin_login/index');
            }
        }else{
            $view = pzk_parse('<div layout="admin/login/login" />');
            $view->display();
        }
    }

    public function logoutAction(){
        pzk_session('adminUser', false);
        pzk_session('adminId', false);
        pzk_session('adminLevel', false);
        $this->redirect('admin_login/index');
    }
    public function fillter($str){
        $str = str_replace("<", "&lt;", $str);
        $str = str_replace(">", "&gt;", $str);
        $str = str_replace("&", "&amp;", $str);
        $str = str_replace("|", "&brvbar;", $str);
        $str = str_replace("~", "&tilde;", $str);
        $str = str_replace("`", "&lsquo;", $str);
        $str = str_replace("#", "&curren;", $str);
        $str = str_replace("%", "&permil;", $str);
        $str = str_replace("'", "&rsquo;", $str);
        $str = str_replace("\"", "&quot;", $str);
        $str = str_replace("\\", "&frasl;", $str);
        $str = str_replace("--", "&ndash;&ndash;", $str);
        $str = str_replace("ar(", "ar&Ccedil;", $str);
        $str = str_replace("Ar(", "Ar&Ccedil;", $str);
        $str = str_replace("aR(", "aR&Ccedil;", $str);
        $str = str_replace("AR(", "AR&Ccedil;", $str);
        return htmlspecialchars($str);
    }

}