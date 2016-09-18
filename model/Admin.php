<?php
class PzkAdminModel {
    public function getUser($username) {
        static $data = array();
        if (!$username) return false;
        if (!@$data[$username]) {
            if (is_numeric($username)) {
                $userId = $username;
                $conds = "`id`='$userId'";
            } else {
                $conds = "`username`='$username'";
            }
            $users = _db()->select('*')->from('user')
                ->where($conds)->limit(0, 1)->result();
            if ($users) $data[$username] = $users[0];
            else $data[$username] = false;
        }
        return $data[$username];
    }

    public function login($username, $password) {
        $password = md5(trim($password));
        $users = _db()->select('a.id, a.username, a.adminLevelId, at.level')
            ->from('pzk_admin a')
            ->join('pzk_admin_level at', 'a.adminLevelId = at.id')
            ->where("username='$username' and password='$password'")
            ->limit(0, 1);
        $users = $users->result_one();

        if ($users) {
            return $users;
        }else{
            return false;

        }
    }

    public function checkAction($action, $level) {
        $users = _db()->select('a.*')
            ->from('pzk_admin_level_action a')
            ->where("admin_action='$action' and admin_level='$level'")
            ->where(array('software', pzk_request('softwareId')))
            ->limit(0, 1);
        $users = $users->result();
        if (count($users) > 0) {
            return true;
        }else{
            return false;

        }
    }

    public function checkActionType($type, $controller, $level) {
        $type   = 	trim($type);
        $user	= 	_db()->select('*')->fromPzk_Admin_level_action()->where(
        		array(
        				'action_type'	=> $type,
        				'admin_action'	=> $controller,
        				'admin_level'	=> $level,
        				'software'		=> pzk_request('softwareId')
        		)
        )->limit(0, 1);
        $users = $user->result_one();
        if ($users) {
            return true;
        }else{
            return false;

        }
    }

    public function getAllLevel() {
        $data = _db()->select('id, level')->from('pzk_admin_level')->result();
        return $data;
    }

    public function checkUser($username) {
        $username = trim($username);
        $users = _db()->select('id')
            ->from('pzk_admin')
            ->where("username='$username'")
            ->result_one();
        if(count($users) >0) {
            return true;
        }else {
            return false;
        }
    }
    public function checkPass($userid, $pass) {
        $pass = trim($pass);
        $pass = md5($pass);
        $users = _db()->select('id')
            ->from('pzk_admin')
            ->where("id='$userid' and password='$pass'")
            ->result_one();
        if(count($users) >0) {
            return true;
        }else {
            return false;
        }
    }
}
?>