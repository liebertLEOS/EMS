<?php
/**
 * 系统配置文件
 * 所有系统级别的配置
 */
return array(

    /* 模块相关配置 */
    'DEFAULT_MODULE'     => 'Admin',
    'MODULE_DENY_LIST'   => array('Common','Install'),
    'MODULE_ALLOW_LIST'  => array('Admin','Report'),

    /* 用户相关设置 */
    'USER_MAX_CACHE'     => 1000,                                                 //最大缓存用户数
    'USER_ADMINISTRATOR' => 1,                                                    //管理员用户ID
    'USER_DEFAULT_IMG'   => '/Public/images/no-user.gif',

    /* URL配置 */
    'URL_CASE_INSENSITIVE' => true,                                               //默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'            => 2,                                                  //URL模式
    'URL_PATHINFO_DEPR'    => '/',                                                //PATHINFO URL分割符

    /* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
    '__STATIC__' => __ROOT__ . '/Public/static',
    '__ADDONS__' => __ROOT__ . '/Public/' . MODULE_NAME . '/Addons',
    '__IMG__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/images',
    '__CSS__'    => __ROOT__ . '/Public/' . MODULE_NAME . '/css',
    '__JS__'     => __ROOT__ . '/Public/' . MODULE_NAME . '/js',
    ),

    /* 全局过滤配置 */
    'DEFAULT_FILTER' => '', //全局过滤函数

    /* 系统数据加密设置 */
    'DATA_AUTH_KEY' => 'n@g08~${BZL-d]EW+q"hx1>3c|G?^OF9vy[SplCJ', //默认数据加密KEY

    /* 数据库配置 */
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => '127.0.0.1', // 服务器地址
    'DB_NAME'   => 'ems', // 数据库名
    'DB_USER'   => 'root', // 用户名
    'DB_PWD'    => 'root',  // 密码
    'DB_PORT'   => '3306', // 端口
    'DB_PREFIX' => 'ems_', // 数据库表前缀

    /* 上传文件目录 */
    'UPLOAD_USER'  => './Uploads/user/',
    'UPLOAD_EXCEL' => './Uploads/excel/'
);
