<?php
/**
 * EmployeeWagesSumViewModel.class.php
 *
 * @Description: 员工工时表单视图模型
 * @Author     : liebert
 * @Date       : 2017/03/18 15:58
 */

namespace Report\Model;

use Think\Model\ViewModel;

class EmployeeWagesSumViewModel extends ViewModel{
    public $viewFields = array(
        'EmployeeWorktime' => array('id','time','workerid','isagreement','price','totaltime','waterandelectricity','overallcost','iccard','penalty','commercialinsurance','managementcost','carfare','borrow','liquidateddamages','_type'=>'LEFT'),
        'EmployeeWorker' => array('name','categoryid','idcard','undercontractwage','fullagreementwage','commission','originid','_on'=>'EmployeeWorktime.workerid=EmployeeWorker.id','_type'=>'LEFT'),
        'EmployeeWorker2' => array('_table'=>'__EMPLOYEE_WORKER__','name'=>'oname','idcard'=>'oidcard','_as'=>'worker','_on'=>'EmployeeWorker.originid=worker.id')
    );
}