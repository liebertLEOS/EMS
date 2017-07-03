<?php
/**
 * EmployeeWorkerViewModel.class.php
 *
 * @Description:
 * @Author     : liebert
 * @Date       : 2017/03/18 15:58
 */

namespace Admin\Model;

use Think\Model\ViewModel;

class EmployeeWorkerViewModel extends ViewModel{
    public $viewFields = array(
        'EmployeeWorker' => array('id','name','idcard','phone','factory','categoryid','deliverydate','terminationdate','undercontractwage','fullagreementwage','commission','originid','isinservice','addedinfo','_type'=>'LEFT'),
        'EmployeeWorker2' => array('id'=>'lid','name'=>'originname','_table'=>'__EMPLOYEE_WORKER__','_on'=>'EmployeeWorker.originid=EmployeeWorker2.id')
    );
}