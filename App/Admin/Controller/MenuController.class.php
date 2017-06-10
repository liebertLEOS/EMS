<?php
/**
 * MenuController.class.php
 *
 * @Description: 后台菜单管理模块控制器
 * @Author     : liebert
 * @Date       : 2017/03/09 15:32
 */

namespace Admin\Controller;
use Think\Controller;


class MenuController extends BaseController {

    /**
     * 菜单管理
     */
    public function index(){
        $this->display();
    }

    /**
     * getMenu
     * @description: 获取菜单列表
     */
    public function getMenu(){
        $menu = M('SystemMenu')->order("myorder asc")->select();

        $menu = listToTree($menu, 'id', 'nid', 'children', '1' );

        $this->ajaxReturn(array(
            "total" => count($menu),
            "rows"  => $menu
        ));
    }

    /**
     * getForm
     * @description: 获取菜单表单
     */
    public function getForm(){
        $id = $_GET['id'];
        if( $id ) {
            $data = M('SystemMenu')->where('id='.$id)->find();
            $this->assign( 'data', $data );
        }

        $this->display('form');
    }

    /**
     * add
     * @description: 添加菜单
     */
    public function add(){

        $data = $_POST;

        if( !$data['text'] || !$data['nid'] ){
            $this->ajaxReturn(array(
                "state" => 0,
                "msg"   => "参数不完整"
            ));
        }

        // 数据处理
        $data['hide'] = $data['hide'] ? 1 : 0;


        $id = M('SystemMenu')->data(array(
            'text'     => $data['text'],
            'icon'     => $data['icon'],
            'nid'      => $data['nid'],
            'hide'     => $data['hide'],
            'url'      => $data['url'],
            'authrule' => $data['authrule'],
            'myorder'  => $data['myorder']
        ))->add();

        if( $id ){
            // 记录到日志中
            $log = $this->user['name'].'创建菜单：【'.$data['text'].'】 ID：【'.$id.'】';
            saveLog(0,$log, $this->user['id'], $this->user['name']);

            $this->ajaxReturn(array(
                'state' => 1,
                'msg'   => '创建成功',

            ));
        }
        $this->ajaxReturn(array(
            'state' => 0,
            'msg'   => '创建失败',

        ));

    }

    /**
     * save
     * @description: 保存菜单
     */
    public function save(){
        $data = $_POST;

        if( !$data['text'] || !$data['nid'] ){
            $this->ajaxReturn(array(
                "state" => 0,
                "msg"   => "参数不完整"
            ));
        }

        // 数据处理
        $data['hide'] = $data['hide'] ? 1 : 0;

        M('SystemMenu')->data(array(
            'text'     => $data['text'],
            'icon'     => $data['icon'],
            'nid'      => $data['nid'],
            'hide'     => $data['hide'],
            'url'      => $data['url'],
            'authrule' => $data['authrule'],
            'myorder'  => $data['myorder']
        ))->where('id='.$data['id'])->save();

        // 记录到日志中
        $log = $this->user['name'].'修改菜单【'.$data['text'].'】';
        saveLog(0,$log, $this->user['id'], $this->user['name']);

        $this->ajaxReturn(array(
            'state' => 1,
            'msg'   => '修改成功',

        ));
    }

    /**
     * delete
     * @description: 删除菜单
     */
    public function delete(){
        $id = $_POST['id'];

        if( !$id ){
            $this->ajaxReturn(array(
                "state" => 1,
                "msg"   => "没有节点删除"
            ));
        }

        $menuModel = M('SystemMenu');
        // check if its childrens is null and delete them
        $info = $menuModel->where("id={$id}")->find();
        $menuModel->where("id={$id}")->delete();
        // 记录到日志中
        $log = $this->user['name'].'删除菜单：【'.$info['text'].'】 ID：【'.$info['id'].'】';
        saveLog(0,$log, $this->user['id'], $this->user['name']);

        $menu = $menuModel->where("nid={$id}")->select();// 获取子节点
        while ( $menu ) { // 当子节点不为空时
            $temp = array();
            foreach ( $menu as $k => $d ){
                $menuModel->where("id={$d['id']}")->delete();// 删除节点
                $data = $menuModel->where("nid={$d['id']}")->select(); // 获取子节点
                $temp = array_merge($temp, $data);

            }
            $menu = $temp;//收集刚删除的节点，循环继续删除其子节点
        }

        $this->ajaxReturn(array(
            "state" => 1,
            "msg"   => "删除成功"
        ));

    }

}