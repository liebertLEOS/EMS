<?php
/**
 * LogController.class.php
 *
 * @Description: 后台日志模块控制器
 * @Author     : liebert
 * @Date       : 2017/03/09 15:28
 */

namespace Admin\Controller;
use Think\Controller;

class LogController extends BaseController {

    /**
     * user
     * @description: 查看用户
     */
    public function index(){
        $this->display();
    }

    /**
     * getUser
     * @description: 日志列表
     */
    public function getLog(){
        $page     = trim($_POST['page']);
        $pageSize = trim($_POST['rows']);
        $dateFrom = isset($_POST['datefrom']) ? strtotime($_POST['datefrom']) : false;
        $dateTo   = isset($_POST['dateto']) ? strtotime($_POST['dateto']) : false;
        $sort     = isset($_POST['sort']) ? trim($_POST['sort']) : '';
        $order    = isset($_POST['sort']) ? trim($_POST['order']) : '';

        $logTable = M('SystemLog');
        $map = array();
        if( $dateFrom ){
            $map['time'][] = array('egt', $dateFrom);
        }
        if( $dateTo ){
            $map['time'][] = array('elt', $dateTo);
        }
        if( $sort && $order ) {
            $sort = $sort.' '.$order;
        }
        $total = $logTable->where($map)->count();
        $log = $logTable->where($map)->order($sort)->page($page, $pageSize)->select();
        $log = array_map(function($value){
            $value['time'] = date('Y-m-d H:i:s', $value['time']);
            return $value;
        }, $log);
        if( $log ){
            $this->ajaxReturn( array(
                "total" => $total,
                "rows"  => $log
            ) );
        } else {
            $this->ajaxReturn( array(
                "total" => 0,
                "rows"  => array()
            ) );
        }
    }

    /**
     * deleteUser
     * @description: 删除日志
     */
    public function delete(){
        $ids = $_POST['ids'];

        if( $ids ){
            M('SystemLog')->where(array('id'=>array('in', $ids)))->delete();

            $this->ajaxReturn(array(
                'state' => 1,
                'msg'   => '删除成功！'
            ));
        }
    }

}