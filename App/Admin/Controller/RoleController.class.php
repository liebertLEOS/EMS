<?php
/**
 * RoleController.class.php
 *
 * @Description: 后台橘色管理模块控制器
 * @Author     : liebert
 * @Date       : 2017/03/09
 */

namespace Admin\Controller;
use Think\Controller;

class RoleController extends BaseController {

    /**
     * user
     * @description: 查看角色
     */
    public function index(){
        $this->display();
    }

    /**
     * getRole
     * @description: 获取角色列表
     */
    public function getRole(){
        $role = M('AuthGroup')->select();
        $this->ajaxReturn($role);
    }

    public function getForm(){
        // get the form data
        $id = $_GET['id'];

        // check if data and query db
        if( $id ) {
            $data = M('AuthGroup')->where('id='.$id)->find();
            $this->assign( 'data', $data );
        }

        $this->display('form');
    }

    /**
     * add
     * @description: 添加角色
     */
    public function add(){
        // get the form data
        $data = $_POST;

        // check data
        if( !$data['title'] || !$data['rules'] ){
            $this->ajaxReturn(array(
                "state" => 0,
                "msg"   => "参数不完整"
            ));
        }

        // format data
        $data['rules'] = count($data['rules']) > 1 ? implode(',', $data['rules']) : $data['rules'];
        $data['status'] = $data['status'] ? 1 : 0;

        // store to db
        $id= M('AuthGroup')->data( $data )->add();

        if( $id ){
            // log
            $log = $this->user['name'].'添加角色信息，角色ID：'.$data['id'].'角色名：'.$data['title'];
            saveLog(0,$log, $this->user['id'], $this->user['name']);

            // response
            $this->ajaxReturn(array(
                'state' => 1,
                'msg'   => '添加成功',

            ));
        }

        // response
        $this->ajaxReturn(array(
            'state' => 0,
            'msg'   => '添加失败',

        ));

    }

    /**
     * save
     * @description: 保存角色
     */
    public function save(){

        // get the form data
        $data = $_POST;

        // check data
        if( !$data['title'] || !$data['rules'] ){
            $this->ajaxReturn(array(
                "state" => 0,
                "msg"   => "参数不完整"
            ));
        }

        // format data
        $data['rules'] = count($data['rules']) > 1 ? implode(',', $data['rules']) : $data['rules'];
        $data['status'] = $data['status'] ? 1 : 0;

        // store to db
        M('AuthGroup')->where( 'id='.$data['id'] )->data( $data )->save();

        // log
        $log = $this->user['name'].'修改角色信息，角色ID：'.$data['id'].'角色名：'.$data['title'];
        saveLog(0,$log, $this->user['id'], $this->user['name']);

        // response
        $this->ajaxReturn(array(
            'state' => 1,
            'msg'   => '修改成功',

        ));

    }

    /**
     * delete
     * @description: 保存角色
     */
    public function delete(){
        $ids = $_POST['ids'];

        if( $ids ){
            M('AuthGroup')->where(array('id'=>array('in', $ids)))->delete();
            M('AuthGroupAccess')->where(array('group_id'=>array('in', $ids)))->delete();

            // log
            $log = $this->user['name'].'删除用户角色，角色ID：'.implode(',', $ids);
            saveLog(0,$log, $this->user['id'], $this->user['name']);

            $this->ajaxReturn(array(
                'state' => 1,
                'msg'   => '删除成功！'
            ));
        }
    }

}