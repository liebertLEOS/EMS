<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/14
 * Time: 8:23
 */

/**
 * 记录日志
 * @param type
 *             0: 系统管理
 *             1：用户管理
 *             2：业务管理
 */
function saveLog( $type=0, $content, $userid, $username ){
    // 参数检验
    if ( !$content || !$userid || !$username){
        return 0;
    }
    // 添加日志到数据库中
    $id = M('SystemLog')->data(array(
        'type'     => $type,
        'content'  => $content,
        'time'     => time(),
        'userid'   => $userid,
        'username' => $username,
        'userip'   => get_client_ip()
    ))->add();

    return $id;
}

/**
 * 将数组转换成树
 * @param $list
 * @param string $pk
 * @param string $pid
 * @param string $child
 * @param string $root
 * @return array
 */
function listToTree( $list, $pk='id', $pid='nid', $child='children', $root='0' ){
    $tree = array();
    if( is_array($list) ){
        $refer = array();
        // 创建基于主键的数组引用，数组中存储的是“主键--数组引用”的对应关系
        foreach( $list as $key => $data ){
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach( $list as $key => $data ){
            $parentId = $data[$pid];
            $list[$key]['iconCls'] = $list[$key]['icon'];
            unset($list[$key]['icon']);
            if( $root == $parentId ) {
                $tree[] =& $list[$key];
            } else {
                if( isset($refer[$parentId]) ){
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }

        }
    }

    return $tree;
}

/**
 * 检测当前用户是否为管理员
 * @return boolean true-管理员，false-非管理员
 * @author liebert
 */
function is_administrator($uid = null){
    return $uid && (intval($uid) === C('USER_ADMINISTRATOR'));
}

/**
 * 系统非常规MD5加密方法
 * @param  string $str 要加密的字符串
 * @return string $key 加密因子
 */
function user_md5($str, $key = ''){
    return '' === $str ? '' : md5(sha1($str) . $key);
}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 * @author liebert
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}


