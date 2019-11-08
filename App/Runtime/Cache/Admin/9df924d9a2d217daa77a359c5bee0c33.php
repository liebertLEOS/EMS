<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title>南山派出所侦办队管理系统</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <link href="/Public/static/bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="/Public/static/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="/Public/easyui/1.5.1/themes/default/easyui.css">
    <link rel="stylesheet" type="text/css" href="/Public/easyui/1.5.1/themes/icon.css">
    
    <link rel="stylesheet" type="text/css" href="/Public/css/admin.css">


    <!--[if lt IE 9]>
    <script src="/Public/static/html5shiv.js"></script>
    <![endif]-->

</head>
<body class="easyui-layout" data-options="border:false">


    <div class="header" data-options="region:'north',noheader:true">
        <div class="header-logo">
            南山派出所侦办队管理系统
        </div>
        <div id="main-header-menu" class="header-menu">
            <a href="javascript:void(0)" id="main-header-menu-user" class="easyui-menubutton"
               data-options="menu:'#main-header-menu-user-sub',iconCls:'icon-status_online',plain:false"><?php echo ($user["name"]); ?></a>
            <div id="main-header-menu-user-sub">
                <div data-options="iconCls:'icon-cog'"><a href="javascript:void(0);" onclick="User.setting(<?php echo ($user["id"]); ?>);">修改资料</a></div>
                <div data-options="iconCls:'icon-door_out'"><a href="<?php echo U('Admin/Login/logout');?>">注销登陆</a></div>
            </div>
        </div>
    </div>

    <div data-options="region:'west',split:true,iconCls:'icon-world'" title="管理菜单" style="width:200px;">
        <ul id="side-menu"></ul>
    </div>

    <div data-options="region:'center'">
        <div id="main-tabs" data-options="iconCls:'icon-group',plain:false,border:false" class="easyui-tabs" style="height:100%;">
            <div title="后台首页" data-options="iconCls:'icon-group',closeable:true" style="padding:0 10px;display:block;">
                <div class="table-mod">
                    <table class="table table-striped table-bordered">
                        <caption><h5>运行环境</h5></caption>
                        <tr>
                            <th width="30%">服务器操作系统</th>
                            <td><?php echo (PHP_OS); ?></td>
                        </tr>
                        <tr>
                            <th>ThinkPHP版本</th>
                            <td><?php echo (THINK_VERSION); ?></td>
                        </tr>
                        <tr>
                            <th>运行环境</th>
                            <td><?php echo ($_SERVER['SERVER_SOFTWARE']); ?></td>
                        </tr>
                        <tr>
                            <th>MYSQL版本</th>
                            <?php $system_info_mysql = M()->query("select version() as v;"); ?>
                            <td><?php echo ($system_info_mysql["0"]["v"]); ?></td>
                        </tr>
                        <tr>
                            <th>上传限制</th>
                            <td><?php echo ini_get('upload_max_filesize');?></td>
                        </tr>
                        <tr>
                            <th>建议浏览器版本</th>
                            <td>IE8以上，谷歌，<a href="http://www.firefox.com.cn/">火狐</a>，360极速浏览器</td>
                        </tr>
                    </table>
                </div>

                <div class="table-mod">
                    <table class="table table-striped table-bordered">
                        <caption><h5>开发团队</h5></caption>
                        <tr>
                            <th width="30%">总策划</th>
                            <td>李伯特</td>
                        </tr>
                        <tr>
                            <th>研发团队</th>
                            <td>李伯特 谢胖子 liebert</td>
                        </tr>
                        <tr>
                            <th>软件设计</th>
                            <td>liebert</td>
                        </tr>
                        <tr>
                            <th>数据库设计</th>
                            <td>谢胖子</td>
                        </tr>
                        <tr>
                            <th>界面及用户体验团队</th>
                            <td>liebert</td>
                        </tr>
                        <tr>
                            <th>技术支持</th>
                            <td>QQ：845301110 , 微信：leos_studio</td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>


<!-- script -->
<script type="text/javascript" src="/Public/easyui/1.5.1/jquery.min.js"></script>
<script type="text/javascript" src="/Public/easyui/1.5.1/jquery.easyui.min.js"></script>
<script type="text/javascript" src="/Public/easyui/1.5.1/locale/easyui-lang-zh_CN.js"></script>
<script type="text/javascript" src="/Public/static/bootstrap/js/bootstrap.js"></script>

    <script type="text/javascript" src="/Public/js/admin/index/index.js"></script>

</body>
</html>