<?php
/**
 * EmployeeWorktimeViewModel.class.php
 *
 * @Description: 员工工时表单视图模型
 * @Author     : liebert
 * @Date       : 2017/02/23 17:15
 */

namespace Admin\Model;

use Think\Model\ViewModel;

class EmployeeWorktimeViewModel extends ViewModel{
    public $viewFields = array(
        'EmployeeWorktime' => array('id','time','workerid','checkindate','leavedate','isagreement','price','totaltime','waterandelectricity','overallcost','iccard','penalty','commercialinsurance','managementcost','carfare','borrow','liquidateddamages','addedinfo'=>'worktime_addedinfo','_type'=>'LEFT'),
        'EmployeeWorker' => array('name','categoryid','undercontractwage','fullagreementwage','_on'=>'EmployeeWorktime.workerid=EmployeeWorker.id'),
    );
}