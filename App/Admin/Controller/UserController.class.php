<?php
/**
 * UserController.class.php
 *
 * @Description: 后台用户管理模块控制器
 * @Author     : liebert
 * @Date       : 2017/02/20
 */

namespace Admin\Controller;
use Think\Controller;
use Think\Model;

class UserController extends BaseController {
    /**
     * user
     * @description: 查看用户
     */
    public function index(){
        $this->display();
    }

    /**
     * getUser
     * @description: 用户列表
     */
    public function getUser(){
        $page     = $_POST['page'];
        $pageSize = $_POST['rows'];
        $username = isset($_POST['username']) ? trim($_POST['username']) : false;
        $sort     = isset($_POST['sort']) ? trim($_POST['sort']) : '';
        $order    = isset($_POST['sort']) ? trim($_POST['order']) : '';
        if( $sort && $order ) {
            $sort = $sort.' '.$order;
        }

        $userModel = M('AdminUser');

        $map = array();

        if( $username ){
            $map['name'] = array('like', '%'.$username.'%');
        }
        $total = $userModel->where($map)->count();
        $user  = $userModel->field('id,name,userpic,loginallowed,registertime,lastip,lasttime')->where($map)->order($sort)->page($page, $pageSize)->select();

        $user = array_map(function($value){
            $value['registertime'] = date('Y-m-d H:i:s', $value['registertime']);
            $value['lasttime'] = date('Y-m-d H:i:s', $value['lasttime']);
            return $value;
        }, $user);

        $this->ajaxReturn( array(
            "total" => $total,
            "rows"  => $user
        ) );
    }

    /**
     * getUserForm
     * @description: 获取用户表单
     */
    public function getForm(){
        $id = $_GET['id'];
        if( $id ) {
            $data = M('AdminUser')->where('id='.$id)->join('LEFT JOIN __AUTH_GROUP_ACCESS__ ON __ADMIN_USER__.id = __AUTH_GROUP_ACCESS__.uid')->find();
            $data['password'] = '';
            $data['userpic'] = $data['userpic'] ? $data['userpic'] : '/Public/images/no-user.gif';
            $this->assign( 'data', $data );
        }
        $this->display('form');
    }

    /**
     * addUser
     * @description: 添加用户
     */
    public function add(){
        $userTable = D('AdminUser');
        $data = $_POST;
        if ( !$data['name'] || !$data['password'] || !$data['email'] || !$data['group_id'] ) {
            $this->ajaxReturn(array(
                "state" => 0,
                "msg"   => "参数不完整"
            ));
        }

        // 检查用户是否存在
        $exits = $userTable->where("name='{$data['name']}'")->find();
        if ( $exits ) {
            $this->ajaxReturn(array(
                'state' => 0,
                'msg'   => '该用户名已存在',

            ));
        }

        // 数据处理
        $data['password']     = user_md5($data['password'], C('DATA_AUTH_KEY'));
        $data['allowed']      = 1;
        $data['loginallowed'] = $data['loginallowed'] ? 1 : 0;

        // 文件上传
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
        } else {
            $data['userpic'] =  C('USER_DEFAULT_IMG');
        }


        // 存储到数据库中
        $userTable->create(array(
            'name'          => $data['name'],
            'password'      => $data['password'],
            'registertime'  => time(),
            'email'         => $data['email'],
            'qq'            => $data['qq'],
            'phone'         => $data['phone'],
            'loginallowed'  => $data['loginallowed'] ? 1 : 0,
            'userpic'       => $data['userpic']
        ));

        $id = $userTable->add();

        if($id){
            // 用户--角色关联
            M('AuthGroupAccess')->data(array(
                'uid'      => $id,
                'group_id' => $data['group_id']
            ))->add();

            // 记录到日志中
            $log = $this->user['name'].'新增用户，用户名ID：'.$data['id'].'用户名：'.$data['name'];
            saveLog(0,$log, $this->user['id'], $this->user['name']);

            $this->ajaxReturn(array(
                'state' => 1,
                'msg'   => '添加成功',

            ));
        }

        $this->ajaxReturn(array(
            'state' => 0,
            'msg'   => '新增失败',

        ));
    }
    /**
     * saveUser
     * @description: 保存用户信息
     */
    public function save(){
        // create object needed
        $userTable = D('AdminUser');

        // get form data
        $data = $_POST;

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

    /**
     * deleteUser
     * @description: 删除用户
     */
    public function delete(){
        $ids = $_POST['ids'];

        if( $ids ){
            M('AdminUser')->where(array('id'=>array('in', $ids)))->delete();
            M('AuthGroupAccess')->where(array('uid'=>array('in', $ids)))->delete();

            // log
            $log = $this->user['name'].'删除用户，用户ID：'.implode(',', $ids);
            saveLog(0,$log, $this->user['id'], $this->user['name']);

            $this->ajaxReturn(array(
                'state' => 1,
                'msg'   => '删除成功！'
            ));
        }
    }

}