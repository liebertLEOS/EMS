<?php
/**
 * WagesController.class.php
 *
 * @Description: 工资数据控制器
 * @Author     : liebert
 * @Date       : 2017/03/01
 */

namespace Report\Controller;
use Think\Controller;
class WagesController extends Controller {

    /**
     * 计算普通员工指定月份的工资数据
     * @return mixed
     */
    private function getWorkerWages( $param ){

        // create one instance of WorkSumViewModel
        $map = array();

        if( !empty($param['_categoryid']) ){
            $map['categoryid'] = array('eq',$param['_categoryid']);
        }
        if( !empty($param['_timef']) || !empty($param['_timet']) ) {
            if ( !empty($param['_timef']) ) $map['time'][] = array('egt', strtotime($param['_timef']));
            if ( !empty($param['_timet']) ) $map['time'][] = array('elt', strtotime($param['_timet']));
        } else {
            $arr = getdate(time());
            $map['time'][] = array('egt', strtotime($arr['year'].'-'.$arr['mon']));
            $map['time'][] = array('elt', strtotime($arr['year'].'-'.($arr['mon']+1)));
        }
        if( !empty($param['_workerid']) ){
            $map['workerid'] = array('eq', $param['_workerid']);
        }
        if( !empty($param['_originid']) ){
            $map['originid'] = array('eq', $param['_originid']);
        }


        // query
        $data  = D('EmployeeWagesSumView')->where($map)->order('categoryid')->select();

        // format result we need
        foreach( $data as $key=>$value ){


            // 设置主从关联字段
            $data[$key]['groupid'] = $data[$key]['originid'] ? $data[$key]['originid'] :  $data[$key]['workerid'] ;

            // 员工-工时工资 = 满协议工价/未满协议工价 * 总工时
            if($data[$key]['isagreement'] == 'Y'){
                $data[$key]['isagreement'] = '是';
                $data[$key]['worktime_wages']   = round($data[$key]['fullagreementwage'] * $data[$key]['totaltime'], 2);
            } else {
                $data[$key]['isagreement'] = '否';
                $data[$key]['worktime_wages']   = round($data[$key]['undercontractwage'] * $data[$key]['totaltime'], 2);
            }

            // 员工-提成贡献 = 工时工资*工头提成
            $data[$key]['contribution'] = round($data[$key]['worktime_wages'] * $data[$key]['commission'], 2 );

            // 员工-提成工资 = 本月下属员工提成贡献之和
            if( $data[$key]['categoryid'] > 1 ){
                $data[$key]['commission_wages'] = $this->getCommissionWages($data[$key]['workerid'],$data[$key]['time']);
            } else {
                $data[$key]['commission_wages'] = 0.00;
            }

            // 员工-扣除工资 = 日常费用之和
            $data[$key]['deductions'] = $data[$key]['waterandelectricity'] + $data[$key]['overallcost'] + $data[$key]['iccard'] + $data[$key]['penalty'] + $data[$key]['commercialinsurance'] + $data[$key]['managementcost'] + $data[$key]['carfare'] + $data[$key]['borrow'] + $data[$key]['liquidateddamages'];

            // 员工-实发工资 = 工时工资 + 提成工资 - 扣除工资
            $data[$key]['real_wages'] = $data[$key]['worktime_wages'] + $data[$key]['commission_wages'] - $data[$key]['deductions'];

            // 公司-工时收入 = 工时工资 * 工时单价
            $data[$key]['worktime_income'] = round($data[$key]['price'] * $data[$key]['totaltime'], 2);

            // 公司-净利润 = 工时收入 - 员工实发工资
            $data[$key]['real_income'] = $data[$key]['worktime_income'] - $data[$key]['real_wages'];

            // 时间格式转换 xxxx年xx月xx日
            $data[$key]['time'] = date('Y-m-d',$data[$key]['time']);

        }
        return $data;
    }

    /**
     * getCommissionWages
     * @description 计算工头提成工资
     * @param integer $workerid 工头id
     * @return float
     */
    private function getCommissionWages( $workerid, $time ){
        $sumWages = 0.00;

        $map = array();
        if( $workerid && $time ){

            $arr = getdate((int)$time);

            $timeStart = strtotime($arr['year'].'-'.$arr['mon']);
            $timeEnd   = strtotime($arr['year'].'-'.($arr['mon']+1));

            $map['originid'] = array('eq', $workerid);
            $map['time'][]   = array('egt', $timeStart);
            $map['time'][]   = array('elt', $timeEnd);

            // 查询此工头的工人
            $workers = M('EmployeeWorktime')->field('isagreement,undercontractwage,fullagreementwage,totaltime,commission,originid')->join('LEFT JOIN __EMPLOYEE_WORKER__ ON __EMPLOYEE_WORKTIME__.workerid = __EMPLOYEE_WORKER__.id')->where($map)->select();

            foreach( $workers as $key=>$value ){
                if($value['isagreement'] == 'Y'){
                    $sumWages += round($value['totaltime'] * $value['fullagreementwage'] * $value['commission'], 2);
                } else {
                    $sumWages += round($value['totaltime'] * $value['undercontractwage'] * $value['commission'], 2);
                }
            }
        }

        return $sumWages;
    }

    /**
     * 获取普通员工报表数据
     */
    public function getGeneralWorker(){
        $param = $_GET;
        $general  = array_map(function($value){
            unset($value['id']);
            unset($value['oidcard']);             // 员工-工头身份证号
            unset($value['originid']);            // 员工-工头id
            unset($value['oname']);               // 员工-工头姓名
            unset($value['categoryid']);          // 员工-分类id
            unset($value['worktime_income']);     // 公司-工时收入
            unset($value['real_income']);         // 公司-净收入

            return $value;
        }, $this->getWorkerWages( $param ));
        exit('{"row":' . json_encode($general) . '}');
    }

    /**
     * 获取员工工头报表数据
     */
    public function getOverseer(){
        // get form data
        $param1 = $_GET;
        $param2 = $_GET;

        $param1['_categoryid'] = 2;
        $param2['_categoryid'] = 1;

        // alter filter
        if ( !empty($param2['_workerid']) ) {
            $param2['_originid'] = $param2['_workerid'];
            unset($param2['_workerid']);
        }

        // calculate commission wages and delete unused field for reducing data to client
        $overseer = array_map(function($value){
            unset($value['id']);                  // 员工-工时序号
            unset($value['price']);               // 员工-工时单价
            unset($value['totaltime']);           // 员工-总工时
            unset($value['waterandelectricity']); // 员工-水电
            unset($value['overallcost']);         // 员工-工衣
            unset($value['iccard']);              // 员工-IC卡
            unset($value['penalty']);             // 员工-罚金
            unset($value['commercialinsurance']); // 员工-商保
            unset($value['managementcost']);      // 员工-管理费
            unset($value['carfare']);             // 员工-车费
            unset($value['borrow']);              // 员工-借资
            unset($value['liquidateddamages']);   // 员工-违约金
            unset($value['oidcard']);             // 员工-工头身份证号
            unset($value['originid']);            // 员工-工头id
            unset($value['oname']);               // 员工-工头姓名
            unset($value['categoryid']);          // 员工-分类id
            unset($value['commission']);          // 员工-提成
            unset($value['contribution']);        // 员工-提成贡献
            unset($value['worktime_income']);     // 公司-工时收入
            unset($value['real_income']);         // 公司-净收入

            return $value;
        }, $this->getWorkerWages( $param1 ));

        // calculate general worker wages and delete unused field for reducing data to client
        $general  = array_map(function($value){
            unset($value['id']);                   // 员工-工时序号
            unset($value['price']);                // 员工-工时单价
            unset($value['waterandelectricity']);  // 员工-水电
            unset($value['overallcost']);          // 员工-工衣
            unset($value['iccard']);               // 员工-IC卡
            unset($value['penalty']);              // 员工-罚金
            unset($value['commercialinsurance']);  // 员工-商保
            unset($value['managementcost']);       // 员工-管理费
            unset($value['carfare']);              // 员工-车费
            unset($value['borrow']);               // 员工-借资
            unset($value['liquidateddamages']);    // 员工-违约金
            unset($value['deductions']);           // 员工-扣除工资
            unset($value['real_wages']);           // 员工-实发工资
            unset($value['commission_wages']);     // 员工-提成工资
            unset($value['oidcard']);              // 员工-工头身份证号
            unset($value['originid']);             // 员工-工头id
            unset($value['oname']);                // 员工-工头姓名
            unset($value['categoryid']);           // 员工-分类id
            unset($value['worktime_income']);      // 公司-工时收入
            unset($value['real_income']);          // 公司-净收入

            return $value;
        }, $this->getWorkerWages( $param2 ));

        exit('{"Master":' . json_encode($overseer) . ',"Detail":' . json_encode($general) . '}');
    }

    /**
     * 获取公司收支明细清单
     *                                                 收  入       支 出      净利润
     * |  员工编号  | 员工姓名  |  单  价  |  总工时  |  工时收入  |  员工工资  |  利  润  |
     *
     * |  总  计   |                               | 工时总收入 | 员工总工资  |  总利润  |
     */
    public function getCompanyIncome(){
        $param = $_GET;
        $data  = array_map(function($value){
            unset($value['id']);                  // 员工-工时序号
            unset($value['waterandelectricity']); // 员工-水电
            unset($value['overallcost']);         // 员工-工衣
            unset($value['iccard']);              // 员工-IC卡
            unset($value['penalty']);             // 员工-罚金
            unset($value['commercialinsurance']); // 员工-商保
            unset($value['managementcost']);      // 员工-管理费
            unset($value['carfare']);             // 员工-车费
            unset($value['borrow']);              // 员工-借资
            unset($value['liquidateddamages']);   // 员工-违约金
            unset($value['oidcard']);             // 员工-工头身份证号
            unset($value['originid']);            // 员工-工头id
            unset($value['oname']);               // 员工-工头姓名
            unset($value['categoryid']);          // 员工-分类id
            unset($value['commission']);          // 员工-提成
            unset($value['contribution']);        // 员工-提成贡献
            unset($value['commission_wages']);    // 员工-提成工资
            unset($value['deductions']);          // 员工-扣除工资

            return $value;
        }, $this->getWorkerWages( $param ));

        exit('{"row":' . json_encode($data) . '}');
    }


}