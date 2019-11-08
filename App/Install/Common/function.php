<?php
/**
 * fucntion.php
 *
 * @Description: 安装模块公共函数
 * @Author     : liebert
 * @Date       : 2017/03/04
 */

// 检测环境是否支持可写
define('IS_WRITE',APP_MODE !== 'sae');

/**
 * 系统环境检测
 * @return array 系统环境数据
 * @author liebert
 */
function check_env(){
    $items = array(
        'os'      => array('操作系统', '不限制', '类Unix', PHP_OS, 'success'),
        'php'     => array('PHP版本', '5.3', '5.3+', PHP_VERSION, 'success'),
        'upload'  => array('附件上传', '不限制', '2M+', '未知', 'success'),
        'gd'      => array('GD库', '2.0', '2.0+', '未知', 'success'),
        'disk'    => array('磁盘空间', '5M', '不限制', '未知', 'success'),
    );

    //PHP环境检测
    if($items['php'][3] < $items['php'][1]){
        $items['php'][4] = 'error';
        session('error', true);
    }

    //附件上传检测
    if(@ini_get('file_uploads'))
        $items['upload'][3] = ini_get('upload_max_filesize');

    //GD库检测
    $tmp = function_exists('gd_info') ? gd_info() : array();
    if(empty($tmp['GD Version'])){
        $items['gd'][3] = '未安装';
        $items['gd'][4] = 'error';
        session('error', true);
    } else {
        $items['gd'][3] = $tmp['GD Version'];
    }
    unset($tmp);

    //磁盘空间检测
    if(function_exists('disk_free_space')) {
        $items['disk'][3] = floor(disk_free_space(INSTALL_APP_PATH) / (1024*1024)).'M';
    }

    return $items;
}

/**
 * 目录，文件读写检测
 * @return array 检测数据
 * @author liebert
 */
function check_dirfile(){
    $items = array(
        array('dir',  '可写', 'success', './Uploads/user'),
        array('dir',  '可写', 'success', './App/Runtime'),
        array('dir',  '可写', 'success', './Data'),
        array('file', '可写', 'success', './App/Common/Conf'),

    );

    foreach ($items as &$val) {
		$item =	INSTALL_APP_PATH . $val[3];
        if('dir' == $val[0]){
            if(!is_writable($item)) {
                if(is_dir($items)) {
                    $val[1] = '可读';
                    $val[2] = 'error';
                    session('error', true);
                } else {
                    $val[1] = '不存在';
                    $val[2] = 'error';
                    session('error', true);
                }
            }
        } else {
            if(file_exists($item)) {
                if(!is_writable($item)) {
                    $val[1] = '不可写';
                    $val[2] = 'error';
                    session('error', true);
                }
            } else {
                if(!is_writable(dirname($item))) {
                    $val[1] = '不存在';
                    $val[2] = 'error';
                    session('error', true);
                }
            }
        }
    }

    return $items;
}

/**
 * 函数检测
 * @return array 检测数据
 * @author liebert
 */
function check_func(){
    $items = array(
        array('pdo','支持','success','类'),
        array('pdo_mysql','支持','success','模块'),
        array('file_get_contents', '支持', 'success','函数'),
        array('mb_strlen',		   '支持', 'success','函数'),
    );

    foreach ($items as &$val) {
        if(('类'==$val[3] && !class_exists($val[0]))
            || ('模块'==$val[3] && !extension_loaded($val[0]))
            || ('函数'==$val[3] && !function_exists($val[0]))
            ){
            $val[1] = '不支持';
            $val[2] = 'error';
            session('error', true);
        }
    }

    return $items;
}

/**
 * 写入配置文件
 * @param  array $config 配置信息
 * @author liebert
 */
function write_config($config, $auth){
    if(is_array($config)){
        //读取配置内容
        $conf = file_get_contents(MODULE_PATH . 'Data/conf.tpl');
        $user = file_get_contents(MODULE_PATH . 'Data/user.tpl');
        //替换配置项
        foreach ($config as $name => $value) {
            $conf = str_replace("[{$name}]", $value, $conf);
            $user = str_replace("[{$name}]", $value, $user);
        }

        $conf = str_replace('[AUTH_KEY]', $auth, $conf);
        $user = str_replace('[AUTH_KEY]', $auth, $user);

        //写入应用配置文件
        if(!IS_WRITE){
            return '由于您的环境不可写，请复制下面的配置文件内容覆盖到相关的配置文件，然后再登录后台。<p>'.realpath(APP_PATH).'/Common/Conf/config.php</p>
            <textarea name="" style="width:650px;height:185px">'.$conf.'</textarea>';
        }else{
            if(file_put_contents(APP_PATH . 'Common/Conf/config.php', $conf)){
                show_msg('配置文件写入成功');
            } else {
                show_msg('配置文件写入失败！', 'error');
                session('error', true);
            }
            return '';
        }

    }
}

/**
 * 创建数据表
 * @param  resource $db 数据库连接资源
 * @author liebert
 */
function create_tables($db, $prefix = ''){
    //读取SQL文件
    $sql = file_get_contents(MODULE_PATH . 'Data/install.sql');
    $sql = str_replace("\r", "\n", $sql);
    $sql = explode(";\n", $sql);

    //替换表前缀
    $orginal = C('ORIGINAL_TABLE_PREFIX');
    $sql = str_replace(" `{$orginal}", " `{$prefix}", $sql);

    //开始安装
    show_msg('开始安装数据库...');
    foreach ($sql as $value) {
        $value = trim($value);
        if(empty($value)) continue;
        if(substr($value, 0, 12) == 'CREATE TABLE') {
            $name = preg_replace("/^CREATE TABLE `(\w+)` .*/s", "\\1", $value);
            $msg  = "创建数据表{$name}";
            if(false !== $db->execute($value)){
                show_msg($msg . '...成功');
            } else {
                show_msg($msg . '...失败！', 'error');
                session('error', true);
            }
        } else {
            $db->execute($value);
        }

    }
}

/**
 * 注册管理员账号
 * @param  resource $db 数据库连接资源
 * @param  resource $prefix 数据库前缀
 * @author liebert
 */
function register_administrator($db, $prefix, $admin, $auth){
    show_msg('开始注册创始人帐号...');
    $sql = "INSERT INTO `[PREFIX]admin_user` VALUES " .
           "('1', '[NAME]', '[PASS]', '[TIME]', '[EMAIL]', '[TIME]', '', '', '[PIC]', 0, '[IP]', '1', '', '', '[TIME]')";

    $password = user_md5($admin['password'], $auth);
    $sql = str_replace(
        array('[PREFIX]', '[NAME]', '[PASS]', '[EMAIL]', '[TIME]', '[PIC]', '[IP]'),
        array($prefix, $admin['username'], $password, $admin['email'], NOW_TIME, C('USER_DEFAULT_IMG'),get_client_ip()),
        $sql);
    //执行sql
    $db->execute($sql);

    show_msg('创始人帐号注册完成！');
}

/**
 * 更新文件变更
 * @author liebert
 */
function update_files(){
    show_msg('开始更新文件...');
    //读取文件变更配置
    $conf = load_config(MODULE_PATH . 'Data/files.config.php');
    $path = MODULE_PATH . 'Data';
    foreach ($conf as $key => $value) {
        // 更新文件
        if ($value['op'] === 'U' || $value['op'] === 'A') {
            // 首先判断目录是否存在，如果不存在则创建
            $dir = substr($value['dest'], 0, strripos($value['dest'], "/"));
            if( !file_exists($dir) ){
                mkdir($dir, 0755, true);
            }
            $success = copy($path . $value['src'], $value['dest']);
            if ($success) {
                show_msg("复制文件 '{$value['src']}' ==> '{$value['dest']}' 成功！");
            } else {
                show_msg("复制文件 '{$value['src']}' ==> '{$value['dest']}' 失败！");
                session('error', true);
            }
        } else if ($value['op'] === 'D') {// 删除文件
            if (file_exists($value['dest'])) {
                $success = unlink($value['dest']);
                if ($success) {
                    show_msg("删除文件 '{$value['dest']}' 成功！");
                } else {
                    show_msg("删除文件 '{$value['dest']}' 失败！");
                    session('error', true);
                }
            }
        }

    }
}

/**
 * 更新数据表
 * @param  resource $db 数据库连接资源
 * @author liebert
 */
function update_tables($db, $prefix = ''){
    //读取SQL文件
    $sql = file_get_contents(MODULE_PATH . 'Data/update.sql');
    $sql = str_replace("\r", "\n", $sql);
    $sql = explode(";\n", $sql);

    //替换表前缀
    $orginal = C('ORIGINAL_TABLE_PREFIX');
    $sql = str_replace(" `{$orginal}", " `{$prefix}", $sql);

    //开始安装
    show_msg('开始升级数据库...');
    foreach ($sql as $value) {
        $value = trim($value);
        if(empty($value)) continue;
        if(substr($value, 0, 12) == 'CREATE TABLE') {
            $name = preg_replace("/^CREATE TABLE `(\w+)` .*/s", "\\1", $value);
            $msg  = "创建数据表{$name}";
        } else if(substr($value, 0, 10) == 'DROP TABLE'){
            $name = preg_replace("/^DROP TABLE `(\w+)` .*/s", "\\1", $value);
            $msg  = "删除数据表{$name}";
        } else if(substr($value, 0, 9) == 'DROP VIEW'){
            $name = preg_replace("/^DROP VIEW `(\w+)` .*/s", "\\1", $value);
            $msg  = "删除数据表视图{$name}";
        } else if(substr($value, 0, 8) == 'UPDATE `') {
            $name = preg_replace("/^UPDATE `(\w+)` .*/s", "\\1", $value);
            $msg  = "更新数据表{$name}";
        } else if(substr($value, 0, 11) == 'ALTER TABLE'){
            $name = preg_replace("/^ALTER TABLE `(\w+)` .*/s", "\\1", $value);
            $msg  = "修改数据表{$name}";
        } else if(substr($value, 0, 11) == 'INSERT INTO'){
            $name = preg_replace("/^INSERT INTO `(\w+)` .*/s", "\\1", $value);
            $msg  = "写入数据表{$name}";
        }

        if(false !== $db->execute($value)){
            show_msg($msg . '...成功');
        } else {
            show_msg($msg . '...失败！', 'error');
            session('error', true);
        }
    }
}

/**
 * 及时显示提示信息
 * @param  string $msg 提示信息
 * @author liebert
 */
function show_msg($msg, $class = ''){
    echo "<script type=\"text/javascript\">showmsg(\"{$msg}\", \"{$class}\")</script>";
    flush();
    ob_flush();
}

/**
 * 生成系统AUTH_KEY
 * @author liebert
 */
function build_auth_key(){
    $chars  = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $chars .= '`~!@#$%^&*()_+-=[]{};:"|,.<>/?';
    $chars  = str_shuffle($chars);
    return substr($chars, 0, 40);
}