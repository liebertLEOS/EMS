<?php
/**
 * IndexController.class.php
 *
 * @Description: 后台管理模块默认控制器
 * @Author     : liebert
 * @Date       : 2017/02/20
 */
namespace Admin\Controller;

use Think\Controller;
use Admin\Model\AuthRuleModel;


class IndexController extends BaseController {
    public function index(){
        // 获取菜单栏

        $this->assign('user', $this->user);
        $this->display();
    }

    final public function getMenuTree($root=0){
        $menu = M('SystemMenu')->order("myorder asc")->select();
        $menu = listToTree($menu, 'id', 'nid', 'children', $root );

        $this->ajaxReturn($menu);
    }

    final public function getSideMenu(){
        $menu = M('SystemMenu')->where( 'hide=0' )->order("myorder asc")->select();

        $refer = array();
        // 创建基于主键的数组引用，数组中存储的是“主键--数组引用”的对应关系
        foreach( $menu as $key => $data ){
            // 判断主菜单权限
            if ( !IS_ROOT && !$this->checkRule(strtolower($data['authrule']),array('in','1,2'),null) ) {
                unset($menu[$key]);
            } else {
                $refer[$data['id']] =& $menu[$key];
            }

        }
        foreach( $menu as $key => $data ){
            $parentId = $data['nid'];
            $menu[$key]['iconCls'] = $menu[$key]['icon'];
            unset($menu[$key]['icon']);
            if( isset($refer[$parentId]) ){
                $parent =& $refer[$parentId];
                $parent['children'][] =& $menu[$key];
                unset($menu[$key]);
            }

        }

        $this->ajaxReturn(array_values($menu));
    }

    final public function getUserSettingForm(){
        $data = M('AdminUser')->where('id='.$this->user['id'])->join('LEFT JOIN __AUTH_GROUP_ACCESS__ ON __ADMIN_USER__.id = __AUTH_GROUP_ACCESS__.uid')->find();
        $data['password'] = '';
        $data['userpic'] = $data['userpic'] ? $data['userpic'] : '/Public/images/no-user.gif';
        $this->assign( 'data', $data );

        $this->display('user-setting-form');

    }

    final public function saveUserSetting(){
        // create object needed
        $userTable = D('AdminUser');

        // get form data
        $data = $_POST;

        // 强制为当前登陆用户信息，防止非法修改他人信息的行为
        $data['id'] = $this->user['id'];

        // check data
        if ( !$data['name'] || !$data['email'] || !$data['group_id'] ) {
            $this->ajaxReturn(array(
                "state" => 0,
                "msg"   => "参数不完整"
            ));
        }

        // format data
        $data['loginallowed'] = $data['loginallowed'] ? 1 : 0;

        // upload file
        if ( !empty($_FILES['userpic']['tmp_name']) ){
            $upload = new \Think\Upload();
            $upload->maxSize   = 1048576;//1M
            $upload->exts      = array('jpg', 'gif', 'png', 'jpeg');
            $upload->rootPath  = './Uploads/user/';
            $fileinfo = $upload->uploadOne($_FILES['userpic']);

            if(!$fileinfo){
                $this->ajaxReturn(array(
                    'state' => 0,
                    'msg'   => '文件上传失败：'.$fileinfo

                ));
            }
            $data['userpic'] = '/uploads/user/'.$fileinfo['savepath'].$fileinfo['savename'];
        }

        if(!empty($data['password'])) $data['password'] = user_md5($data['password'], C('DATA_AUTH_KEY'));

        // collect data
        foreach ( $data as $key => $dat ) {
            if( $dat == null || $dat == '' ) {
                unset($data[$key]);
            }
        }
        // save to db
        $userTable->create($data);
        $userTable->where( 'id='.$data['id'] )->save();

        // save group id
        if( M('AuthGroupAccess')->where( 'uid='.$data['id'] )->count() == 0 ){
            // 创建 用户--角色 关联
            M('AuthGroupAccess')->data(array(
                'uid'      => $data['id'],
                'group_id' => $data['group_id']
            ))->add();
        } else {
            $r = M('AuthGroupAccess')->where( 'uid='.$data['id'] )->data(array(
                'group_id' => $data['group_id']
            ))->save();
        }

        // log
        $log = $this->user['name'].'修改用户信息，用户名ID：'.$data['id'].'用户名：'.$data['name'];
        saveLog(0,$log, $this->user['id'], $this->user['name']);

        // response
        $this->ajaxReturn(array(
            'state' => 1,
            'msg'   => '修改成功',
        ));
    }
}