<?php
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liebert <845301110@qq.com>
// +----------------------------------------------------------------------

// 应用入口文件
// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
//define('APP_DEBUG',true);

// 定义应用目录
define('APP_PATH','./App/');

if(!is_file('Data/install.lock')){
    header('Location: /install.php');
    exit;
}

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';