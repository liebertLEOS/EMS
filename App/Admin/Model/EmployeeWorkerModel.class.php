<?php
/**
 * EmployeeWorkerModel.class.php
 *
 * @Description: 员工模型
 * @Author     : liebert
 * @Date       : 2017/02/22 19:05
 */

namespace Admin\Model;

use Think\Model;

class EmployeeWorkerModel extends Model{

    /* 自动验证规则 */
    protected $_validate = array(
        array('name','require','名字不能为空！'),
        array('undercontractwage','/^(0|[1-9][0-9]{0,10})(.[0-9]{1,2})?$/','"未满协议工价"数据格式不合法',1,'regex'),
        array('fullagreementwage','/^(0|[1-9][0-9]{0,10})(.[0-9]{1,2})?$/','"满协议工价"数据格式不合法',1,'regex')
    );

    /* 自动完成规则 */
    protected $_auto = array(
        array('deliverydate','str2time',self::MODEL_BOTH,'callback'),
        array('terminationdate','str2time',self::MODEL_BOTH,'callback')
    );

    public function str2time($value){
        if ( !isset($value) || empty( $value ) ) {
            $value = '';
        } else {
            $value = strtotime($value);
        }
        return $value;
    }


}