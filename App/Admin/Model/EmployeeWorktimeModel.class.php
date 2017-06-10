<?php
/**
 * EmployeeWorktimeModel.class.php
 *
 * @Description: 员工工时表单模型
 * @Author     : liebert
 * @Date       : 2017/02/22 19:05
 */

namespace Admin\Model;

use Think\Model;

class EmployeeWorktimeModel extends Model{

    /* 自动验证规则 */
    protected $_validate = array(
        array('time','require','时间不能为空！'),
        array('workerid','require','工人id不能为空！'),
        array('price','/^(?:(0|[1-9][0-9]{0,10})(?:.[0-9]{1,2})?)|$/','"单价"数据格式不合法',1,'regex'),
        array('totaltime','/^(?:(0|[1-9][0-9]{0,10})(?:.[0-9]{1,2})?)|$/','"总工时"数据格式不合法',1,'regex'),
        array('waterandelectricity','/^(?:(0|[1-9][0-9]{0,9})(?:.[0-9]{1,2})?)|$/','"水电"数据格式不合法',1,'regex'),
        array('overallcost','/^(?:(0|[1-9][0-9]{0,9})(?:.[0-9]{1,2})?)|$/','"工衣"数据格式不合法',1,'regex'),
        array('iccard','/^(?:(0|[1-9][0-9]{0,9})(?:.[0-9]{1,2})?)|$/','"IC卡"数据格式不合法',1,'regex'),
        array('penalty','/^(?:(0|[1-9][0-9]{0,9})(?:.[0-9]{1,2})?)|$/','"罚款"数据格式不合法',1,'regex'),
        array('commercialinsurance','/^(?:(0|[1-9][0-9]{0,9})(?:.[0-9]{1,2})?)|$/','"商保"数据格式不合法',1,'regex'),
        array('managementcost','/^(?:(0|[1-9][0-9]{0,9})(?:.[0-9]{1,2})?)|$/','"管理费"数据格式不合法',1,'regex'),
        array('carfare','/^(?:(0|[1-9][0-9]{0,9})(?:.[0-9]{1,2})?)|$/','"车费"数据格式不合法',1,'regex'),
        array('borrow','/^(?:(0|[1-9][0-9]{0,9})(?:.[0-9]{1,2})?)|$/','"借资"数据格式不合法',1,'regex'),
        array('liquidateddamages','/^(?:(0|[1-9][0-9]{0,9})(?:.[0-9]{1,2})?)|$/','"违约金"数据格式不合法',1,'regex')
    );

    /* 自动完成规则 */
    protected $_auto = array(
        array('time','strtotime',self::MODEL_BOTH,'function'),
        array('checkindate','strtotime',self::MODEL_BOTH,'function'),
        array('leavedate','strtotime',self::MODEL_BOTH,'function'),
        array('price','setDefaultZero',self::MODEL_BOTH,'callback'),
        array('totaltime','setDefaultZero',self::MODEL_BOTH,'callback'),
        array('waterandelectricity','setDefaultZero',self::MODEL_BOTH,'callback'),
        array('overallcost','setDefaultZero',self::MODEL_BOTH,'callback'),
        array('iccard','setDefaultZero',self::MODEL_BOTH,'callback'),
        array('penalty','setDefaultZero',self::MODEL_BOTH,'callback'),
        array('commercialinsurance',self::MODEL_BOTH,'callback'),
        array('managementcost','setDefaultZero',self::MODEL_BOTH,'callback'),
        array('carfare','setDefaultZero',self::MODEL_BOTH,'callback'),
        array('borrow','setDefaultZero',self::MODEL_BOTH,'callback'),
        array('liquidateddamages','setDefaultZero',self::MODEL_BOTH,'callback')
    );

    public function setDefaultZero($value){
        if ( !isset($value) || empty( $value ) ) {
            $value = 0;
        }
        return $value;
    }


}