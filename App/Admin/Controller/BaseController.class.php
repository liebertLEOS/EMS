<?php
/**
 * BaseController.class.php
 *
 * @Description: 后台管理模块基控制器
 * @Author     : liebert
 * @Date       : 2017/02/20
 */

namespace Admin\Controller;

use Think\Controller;
use Admin\Model\AuthRuleModel;

class BaseController extends Controller {
    protected $user;

    public function _initialize(){
        // 获取当前用户ID
        if(defined('UID')) return ;
        // 检测用户登录
        $user = $this->checkUser();

        if( $user == null ) {
            $this->redirect('Admin/Login/index');
        }

        define('UID',$user['id']);

        $this->UpdateUserInfo();
        $this->user = $user;

        // 是否是超级管理员
        define('IS_ROOT', is_administrator(UID));

        //检测访问权限
        if(!IS_ROOT){

            $rule  = strtolower(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME);
            if ( !$this->checkRule($rule,AuthRuleModel::RULE_URL) ){
                exit('未授权访问!');
            }else{
                // 检测分类及内容有关的各项动态权限
                $dynamic    =   $this->checkDynamic();
                if( false === $dynamic ){
                    exit('未授权访问!');
                }
            }
        }

    }

    protected function checkUser(){
        $userid_s = session('emsuserid');
        if( $userid_s ) {
            // fetch the userinfo form database
            $userinfo = M('AdminUser')->where("id={$userid_s}")->find();
            return $userinfo;
        } else {
            // check if remeber the login state
            // get the cookie
            $userid    = cookie('ems_userid');
            $usertoken = cookie('ems_usertoken');
            if( $userid && $usertoken ){
                $user = M('AdminUser')->where("id='{$userid}'")->find();
                if( $user && $user['token']==$usertoken && $user['expire']>time()){
                    // set session
                    session(array(
                        'expire' => 3600 // 1 hour
                    ));
                    session('emsuserid', $userid);

                    return $user;
                }
            }
            $userInfo = null;
        }
    }

    /**
     * 权限检测
     * @param string  $rule    检测的规则
     * @param string  $mode    check模式
     * @return boolean
     * @author 朱亚杰  <xcoolcc@gmail.com>
     */
    final protected function checkRule($rule, $type=AuthRuleModel::RULE_URL, $mode='url'){
        static $Auth    =   null;
        if (!$Auth) {
            $Auth       =   new \Think\Auth();
        }
        if(!$Auth->check($rule,UID,$type,$mode)){
            return false;
        }
        return true;
    }

    /**
     * 检测是否是需要动态判断的权限
     * @return boolean|null
     *      返回true则表示当前访问有权限
     *      返回false则表示当前访问无权限
     *      返回null，则表示权限不明
     *
     * @author 朱亚杰  <xcoolcc@gmail.com>
     */
    protected function checkDynamic(){}

    /**
     * UpdateUserInfo
     * 更新用户信息
     * */
    protected function UpdateUserInfo(){

    }

    /**
     * 获取图标列表
     */
    final public function getIconList(){
        $icons = M('adminicons')->order('icon asc')->select();

        $icons = array_map(function($value){
            $value['iconCls'] = $value['icon'];
            $value['id']      = $value['icon'];
            return $value;
        }, $icons);


        $this->ajaxReturn($icons);
    }


}