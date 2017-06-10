<?php
/**
 * ReportController.class.php
 *
 * @Description: 后台报表管理模块控制器
 * @Author     : liebert
 * @Date       : 2017/02/20
 */

namespace Admin\Controller;
use Think\Controller;
class ReportController extends BaseController {
    /**
     * @description: 设计报表
     */
    public function designReports(){

        $this->display('design-reports');
    }

    /**
     * @description: 打印报表
     */
    public function printReports(){
        $this->display('print-reports');
    }

    /**
     * @description: 获取报表结构树
     */
    public function getReportsTree(){

        $tree = M('ReportTables')->field('id,text,type,dataurl')->select();

        $tree = array_map( function($value){
            $value['iconCls'] = 'icon-page_white_word';
            return $value;
        }, $tree );

        if( IS_AJAX ) {
            $this->ajaxReturn($tree);
        } else {
            return $tree;
        }

    }

    /**
     * desingOneReport
     * @description: 设计一张报表
     */
    public function designOneReport(){
        $id      = $_GET['id'];
        // check param
        if( !$id ){
            if( IS_AJAX ) {
                $this->ajaxReturn(array(
                    'state' => 0,
                    'msg'   => '参数信息不完整'
                ));
            } else {
                exit('参数信息不完整');
            }
        }
        $data = M('ReportTables')->where('id='.$id)->find();

        $this->assign('data',$data);

        $this->display('design-one-report');
    }

    /**
     * desingOneReport
     * @description: 设计一张报表
     */
    public function printOneReport(){
        $id      = $_GET['id'];
        // check param
        if( !$id ){
            if( IS_AJAX ) {
                $this->ajaxReturn(array(
                    'state' => 0,
                    'msg'   => '参数信息不完整'
                ));
            } else {
                exit('参数信息不完整');
            }
        }
        $data = M('ReportTables')->where('id='.$id)->find();

        $this->assign('data',$data);

        $this->display('print-one-report');
    }




}