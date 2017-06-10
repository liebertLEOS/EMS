<?php
/**
 * WorkSumViewModel.class.php
 *
 * @Description: 汇总表单模型
 * @Author     : liebert
 * @Date       : 2017/02/23 17:15
 */

namespace Admin\Model;

use Think\Model\ViewModel;

class WorkSumViewModel extends ViewModel{
    public $viewFields = array(
        'EmployeeWorktime' => array('id','time','workerid','checkindate','leavedate','price','isagreement','totaltime','waterandelectricity','overallcost','iccard','penalty','commercialinsurance','managementcost','carfare','borrow','liquidateddamages','addedinfo'=>'worktime_addedinfo','_type'=>'LEFT'),
        'EmployeeWorker' => array('name','originid','idcard','phone','factory','categoryid','deliverydate','terminationdate','undercontractwage','fullagreementwage','commission','isinservice','addedinfo'=>'worker_addedinfo','_on'=>'EmployeeWorktime.workerid=EmployeeWorker.id')
    );
}