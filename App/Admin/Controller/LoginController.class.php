<?php
/**
 * LoginController.class.php
 *
 * @Description: 后台登陆模块控制器
 * @Author     : liebert
 * @Date       : 2017/02/20
 * @Update     :
 *               2017/03/05 ：添加了登陆记住账号功能，时间为3天
 *
 */

namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller {
    public function index(){
        $userid_s = session('emsuserid');
        if($userid_s) {
            $this->error('用户已经登录，如需登录新的账号，请先退出...');
        }
        $this->display();
    }

    public function login(){

        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if( !$username || !$password ){
            $this->ajaxReturn(array('state'=>0,'msg'=>'用户名或密码不能为空'));
        }

        // 判断用户是否存在
        $user = M('AdminUser')->where("name='{$username}'")->find();
        if( $user == null ){
            $this->ajaxReturn(array('state'=>0,'msg'=>'用户不存在'));
        }

        // 用户是否被禁止
        if($user['loginallowed'] == 0){
            $this->ajaxReturn(array('state'=>0,'msg'=>'该用户已被禁止登陆'));
        }

        // 判断密码是否一致
        if( $user['password'] != user_md5($password, C('DATA_AUTH_KEY')) ){
            $this->ajaxReturn(array('state'=>0,'msg'=>'密码错误'));
        }

        // 获取时间
        $user['lasttime'] = time();

        // 获取登陆ip
        $user['lastip'] = get_client_ip();

        // 获取登陆次数
        $user['loginnum'] = 'loginnum+1';

        // set user agent
        $user['useragent'] = $_SERVER['HTTP_USER_AGENT'];

        // set user token
        $user['token'] = md5( $user['name']+md5($user['useragent']) );

        // remember the login state
        $remember = $_POST['remember'];
        if($remember){
            $user['expire'] = time() + 259200;// three days
            // set cookie
            cookie('userid',   $user['id'], array('expire'=>259200,'prefix'=>'ems_'));
            cookie('usertoken',$user['token'],  array('expire'=>259200,'prefix'=>'ems_'));
        }

        // set session
        session(array(
            'expire' => 3600 // 1 hour
        ));
        session('emsuserid', $user['id']);

        // 更新用户信息
        M('AdminUser')->where("id={$user['id']}")->save($user);

        // log it
        $log = $user['name'].'于'.date('Y-m-d H:i:s', $user['lasttime']).'登陆系统,IP:'.$user['lastip'];
        saveLog(0,$log, $user['id'], $user['name']);

        // return response
        $this->ajaxReturn(array('state'=>1,'msg'=>'登陆成功', 'url'=>U('Admin/Index/index')));

    }

    public function logout(){
        $userid = session('emsuserid');
        $user = M('AdminUser')->where("id={$userid}")->find();
        // 记录到日志中
        $log = $user['name'].'于'.date('Y-m-d H:i:s', $user['lasttime']).'退出系统,IP:'.get_client_ip();;
        saveLog(0,$log, $user['id'], $user['name']);

        // delete session
        session('emsuserid', null);
        // delete cookie
        cookie('userid',null);
        cookie('usertoken',null);
        $this->redirect('Admin/Login/index');
    }
}