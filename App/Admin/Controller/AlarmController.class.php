<?php
/**
 * AlarmController.class.php
 *
 * @Description: 警情管理模块控制器
 * @Author     : liebert
 * @Date       : 2017/02/22
 */

namespace Admin\Controller;
use Think\Controller;

class AlarmController extends BaseController {

    /***************************************************************************************
     *                                    警情模块
     ****************************************************************************************/
    /**
     * 警情列表
     */
    public function index(){
        $this->display();
    }

    /**
     * 警情处理反馈列表
     */
    public function AlarmLog(){
        $this->display('alarmlog');
    }

    /**
     * 警情导入
     */
    public function importAlarm(){
        $this->display('import-alarm');
    }


    /**
     * 获取警情
     */
    public function getAlarm(){
        // fetch data and check
        $page     = $_POST['page'];
        $pageSize = $_POST['rows'];
        $sort     = isset($_POST['sort']) ? trim($_POST['sort']) : '';
        $order    = isset($_POST['sort']) ? trim($_POST['order']) : '';
        $alarmnumber = isset($_POST['alarmnumber']) ? trim($_POST['alarmnumber']) : '';

        if( $sort && $order ) {
            $sort = $sort.' '.$order;
        }

        // create and format data we need

        $alarmModel = M('Alarm');

        $map = array();
        if( $alarmnumber ){
            $map['alarmnumber'] = array('like', '%'.$alarmnumber.'%');
        }

        // sum the number the data
        $total = $alarmModel->where($map)->count();
        $alarm = $alarmModel->field('id,alarmnumber,alarmtype,phonenumber,alarminfo')->where($map)->order($sort)->page($page, $pageSize)->select();

        // format result we need

        // response
        if( IS_AJAX ) {
            $this->ajaxReturn( array(
                "total" => $total,
                "rows"  => $alarm
            ) );
        } else {
            return array(
                "total" => $total,
                "rows"  => $alarm
            );
        }
    }

    function getAlarmLog(){
        // fetch data and check
        $page     = $_POST['page'];
        $pageSize = $_POST['rows'];
        $sort     = isset($_POST['sort']) ? trim($_POST['sort']) : '';
        $order    = isset($_POST['sort']) ? trim($_POST['order']) : '';
        $alarmnumber = isset($_POST['alarmnumber']) ? trim($_POST['alarmnumber']) : '0';

        if( $sort && $order ) {
            $sort = $sort.' '.$order;
        }

        // create and format data we need

        $alarmLogModel = M('AlarmLog');

        $map = array();
        $map['alarmnumber'] = array('eq', $alarmnumber);

        // sum the number the data
        $total = $alarmLogModel->where($map)->count();
        $alarmLog = $alarmLogModel->field('id,alarmlogtime,alarmlogcontent')->where($map)->order($sort)->select();

        $alarmLog = array_map(function($value){
            $value['alarmlogtime'] = date('Y-m-d H:i:s', $value['alarmlogtime']);
            return $value;
        }, $alarmLog);

        // response
        if( IS_AJAX ) {
            $this->ajaxReturn( array(
                "total" => $total,
                "rows"  => $alarmLog
            ) );
        } else {
            return array(
                "total" => $total,
                "rows"  => $alarmLog
            );
        }
    }

    function getAlarmLogForm(){
        // get the form data
        $id = $_GET['id'];

        $alarmlogtime = date('Y-m-d H:i:s', time());
        $this->assign( 'alarmlogtime', $alarmlogtime );

        // check if data and query db
        if( $id ) {
            $data = M('AuthRule')->where('id='.$id)->find();
            $this->assign( 'data', $data );
        }
        $this->display('alarmlog-form');
    }

    /**
     * setAlarmLog
     */
    function setAlarmLog(){

    }

    /**
     * batchProcessWorker
     */
    public function batchProcessWorker(){
        $data  = $_POST;
        $workerModel = D('EmployeeWorker');
        $cate = $_GET['cate'];

        if(!is_numeric($cate)) {
            $cate = 1;
        }

        // updated
        if ( $source = json_decode($data['updated']) ) {
            foreach( $source as $key => $vo ){
                $data = array();
                foreach( $vo as $k=>$d ){
                    $data[$k] = $d;
                }

                $data['categoryid'] = $cate;

                if( !$workerModel->create($data) ){

                    $this->ajaxReturn(array(
                        "state" => 0,
                        "msg"   => $workerModel->getError()
                    ));
                }

                $error = $workerModel->save();

                if( $error === false ){

                    $this->ajaxReturn(array(
                        "state" => 0,
                        "msg"   => "更新失败"
                    ));
                }

                // 记录到日志中
                $log = $this->user['name'].'更新员工基础信息，员工ID：【'.$data['id'].'】，员工姓名：【'.$data['name'].'】';
                saveLog(0,$log, $this->user['id'], $this->user['name']);
            }
        }// end update


        // add
        if ( $source = json_decode($data['inserted']) ) {
            foreach( $source as $key=>$vo ){
                $data = array();
                foreach( $vo as $k=>$d ){
                    $data[$k] = $d;
                }

                $data['categoryid'] = $cate;
                if( !$workerModel->create($data) ){

                    $this->ajaxReturn(array(
                        "state" => 0,
                        "msg"   => $workerModel->getError()
                    ));
                }

                $error = $workerModel->add();

                if( $error === false ){

                    $this->ajaxReturn(array(
                        "state" => 0,
                        "msg"   => "添加失败"
                    ));
                }

                // 记录到日志中
                $log = $this->user['name'].'增加员工基础信息，员工ID：【'.$error.'】，员工姓名：【'.$data['name'].'】';
                saveLog(0,$log, $this->user['id'], $this->user['name']);

            }// end foreach

        }//end add


        // deleted
        if ( $source = json_decode($data['deleted']) ) {
            $data = array();
            foreach( $source as $key=>$vo ) {
                $data[] = $vo->id;
            }
            $data = implode(',', $data);
            $error = $workerModel->delete($data);
            if( $error === false ){

                $this->ajaxReturn(array(
                    "state" => 0,
                    "msg"   => "删除失败"
                ));
            }

            // 记录到日志中
            $log = $this->user['name'].'删除员工基础信息，员工ID：【'.$data['id'].'】，员工姓名：【'.$data['name'].'】';
            saveLog(0,$log, $this->user['id'], $this->user['name']);
        }

        // response
        $this->ajaxReturn(array(
            "state" => 1,
            "msg"   => "保存成功"
        ));
    }


}