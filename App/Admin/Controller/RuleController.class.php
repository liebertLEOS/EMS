<?php
/**
 * RuleController.class.php
 *
 * @Description: 后台权限规则管理模块控制器
 * @Author     : liebert
 * @Date       : 2017/02/20
 */

namespace Admin\Controller;
use Think\Controller;

class RuleController extends BaseController {

    /**
     * index
     * @description: 获取规则
     */
    public function index(){
        $this->display();
    }

    /**
     * getRule
     * @description: 获取规则
     */
    public function getRule(){
        $rule = M('AuthRule')->select();

        $rule = listToTree($rule, 'id', 'pid', 'children', '1' );

        $this->ajaxReturn(array(
            "total" => count($rule),
            "rows"  => $rule
        ));
    }

    /**
     * getRuleTree
     * @description: 获取规则树
     */
    public function getRuleTree($root = 0){
        $rule = M('AuthRule')->field('id,pid,title as text')->select();
        $rule = listToTree($rule, 'id', 'pid', 'children', $root );

        $this->ajaxReturn($rule);
    }

    /**
     * addRule
     * @description: 获取规则表单
     */
    public function getForm(){
        // get the form data
        $id = $_GET['id'];

        // check if data and query db
        if( $id ) {
            $data = M('AuthRule')->where('id='.$id)->find();
            $this->assign( 'data', $data );
        }

        $this->display('form');
    }

    /**
     * addRule
     * @description: 添加规则
     */
    public function add(){
        // get the form data
        $data = $_POST;

        // check data
        if( !$data['title'] ){
            $this->ajaxReturn(array(
                "state" => 0,
                "msg"   => "参数不完整"
            ));
        }
        // format
        $data['status'] = $data['status'] ? 1 : 0;

        // store to db
        $id= M('AuthRule')->data( $data )->add();

        if( $id ){
            // log
            $log = $this->user['name'].'添加权限规则，规则ID：'.$data['id'].'规则名称：'.$data['title'];
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
     * saveRule
     * @description: 保存规则
     */
    public function save(){
        // get the form data
        $data = $_POST;

        // check data
        if( !$data['title'] ){
            $this->ajaxReturn(array(
                "state" => 0,
                "msg"   => "参数不完整"
            ));
        }

        // format
        $data['status'] = $data['status'] ? 1 : 0;

        // store to db
        M('AuthRule')->where( 'id='.$data['id'] )->data( $data )->save();

        // log
        $log = $this->user['name'].'修改权限规则，规则ID：'.$data['id'].'规则名称：'.$data['title'];
        saveLog(0,$log, $this->user['id'], $this->user['name']);

        // response
        $this->ajaxReturn(array(
            'state' => 1,
            'msg'   => '修改成功',

        ));
    }

    /**
     * deleteRule
     * @description: 删除规则
     */
    public function delete(){
        $id = $_POST['id'];

        if( !$id ){
            $this->ajaxReturn(array(
                "state" => 1,
                "msg"   => "没有节点删除"
            ));
        }

        $authRuleModel = M('AuthRule');
        // check if its childrens is null and delete them
        $info = $authRuleModel->where("id={$id}")->find();
        $authRuleModel->where("id={$id}")->delete();
        // 记录到日志中
        $log = $this->user['name'].'删除菜单：【'.$info['text'].'】 ID：【'.$info['id'].'】';
        saveLog(0,$log, $this->user['id'], $this->user['name']);

        $authRule = $authRuleModel->where("pid={$id}")->select();// 获取子节点
        while ( $authRule ) { // 当子节点不为空时
            $temp = array();
            foreach ( $authRule as $k => $d ){
                $authRuleModel->where("id={$d['id']}")->delete();// 删除节点
                $data = $authRuleModel->where("pid={$d['id']}")->select(); // 获取子节点
                $temp = array_merge($temp, $data);

            }
            $authRule = $temp;//收集刚删除的节点，循环继续删除其子节点
        }

        $this->ajaxReturn(array(
            'state' => 1,
            'msg'   => '删除成功！'
        ));
    }




}