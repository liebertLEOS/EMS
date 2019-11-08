<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>EMS安装</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <!-- Le styles -->
        <link href="/Public/static/bootstrap/css/bootstrap.css" rel="stylesheet">
        <link href="/Public/static/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="/Public/css/install.css" rel="stylesheet">

        <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
        <script src="/Public/static/html5shiv.js"></script>
        <![endif]-->
        <script src="/Public/static/jquery-1.10.2.min.js"></script>
        <script src="/Public/static/bootstrap/js/bootstrap.js"></script>
    </head>
    <body>
        <div class="paper">
            <div class="paper-heading">
                <h1>
                    <span class="brand">EMS 员工管理系统</span>
                    <span class="text-muted"><?php if(($_SESSION['update']) == "1"): ?>升级<?php else: ?>安装<?php endif; ?>向导 <small class="text-info">V1.0</small></span>
                </h1>
            </div>
            <div class="paper-body">
                
    <ul class="nav nav-pills nav-justified">
        <li class="disabled"><a href="javascript:;">1.环境检测</a></li>
        <li class="disabled active"><a href="javascript:;">2.创建数据库</a></li>
        <li class="disabled"><a href="javascript:;">3.<?php if(($_SESSION['update']) == "1"): ?>升级<?php else: ?>初始化系统<?php endif; ?></a></li>
        <li class="disabled"><a href="javascript:;">4.升级完成</a></li>
    </ul>

    <?php
 defined('SAE_MYSQL_HOST_M') or define('SAE_MYSQL_HOST_M', '127.0.0.1'); defined('SAE_MYSQL_HOST_M') or define('SAE_MYSQL_PORT', '3306'); ?>
    <form action="/install.php?s=/install/step2.html" method="post" target="_self" class="form-horizontal">
        <div class="create-database">
            <h2>系统初始化信息</h2>
            <div class="form-group">
                <lablel class="col-sm-4 control-label">数据库类型</lablel>
                <div class="controls col-sm-5">
                    <select name="db[]" class="form-control">
                        <option>mysql</option>
                    </select>
                    <div class="help-block">默认为MySQL数据库</div>
                </div>
            </div>
            <div class="form-group">
                <lablel class="col-sm-4 control-label">数据库服务器</lablel>
                <div class="controls col-sm-5">
                    <input type="text" name="db[]" value="<?php if(defined("SAE_MYSQL_HOST_M")): echo (SAE_MYSQL_HOST_M); else: ?>127.0.0.1<?php endif; ?>" class="form-control">
                    <div class="help-block">数据库服务器，数据库服务器IP，一般为127.0.0.1</div>
                </div>

            </div>
            <div class="form-group">
                <lablel class="col-sm-4 control-label">数据库名</lablel>
                <div class="controls col-sm-5">
                    <input type="text" name="db[]" value="ems" class="form-control">
                    <div class="help-block">默认为ems</div>
                </div>

            </div>
            <div class="form-group">
                <lablel class="col-sm-4 control-label">数据库用户名</lablel>
                <div class="controls col-sm-5">
                    <input type="text" name="db[]" value="<?php if(defined("SAE_MYSQL_USER")): echo (SAE_MYSQL_USER); endif; ?>" class="form-control">
                    <div class="help-block">安装数据库时创建的用户名</div>
                </div>
            </div>
            <div class="form-group">
                <lablel class="col-sm-4 control-label">数据库密码</lablel>
                <div class="controls col-sm-5">
                    <input type="password" name="db[]" value="<?php if(defined("SAE_MYSQL_PASS")): echo (SAE_MYSQL_PASS); endif; ?>" class="form-control">
                    <div class="help-block">安装数据库时创建的用户密码</div>
                </div>
            </div>
            <div class="form-group">
                <lablel class="col-sm-4 control-label">数据库端口</lablel>
                <div class="controls col-sm-5">
                    <input type="text" name="db[]" value="<?php if(defined("SAE_MYSQL_PORT")): echo (SAE_MYSQL_PORT); else: ?>3306<?php endif; ?>" class="form-control">
                    <div class="help-block">数据库服务连接端口，一般为3306</div>
                </div>
            </div>
            <div class="form-group">
                <lablel class="col-sm-4 control-label">数据表前缀</lablel>
                <div class="controls col-sm-5">
                    <input type="text" name="db[]" value="ems_" class="form-control">
                    <div class="help-block">同一个数据库运行多个系统时请修改为不同的前缀</div>
                </div>
            </div>
        </div>

        <div class="create-database">
            <h2>管理员帐号信息</h2>
            <div class="form-group">
                <lablel class="col-sm-4 control-label">系统管理员账号</lablel>
                <div class="controls col-sm-5">
                    <input type="text" name="admin[]" value="admin" class="form-control">
                    <div class="help-block"></div>
                </div>
            </div>

            <div class="form-group">
                <lablel class="col-sm-4 control-label">系统管理员密码</lablel>
                <div class="controls col-sm-5">
                    <input type="password" name="admin[]" value="" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <lablel class="col-sm-4 control-label">确认密码</lablel>
                <div class="controls col-sm-5">
                    <input type="password" name="admin[]" value="" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <lablel class="col-sm-4 control-label">邮箱</lablel>
                <div class="controls col-sm-5">
                    <input type="text" name="admin[]" value="" class="form-control">
                    <div class="help-block">请填写正确的邮箱便于收取提醒邮件</div>
                </div>
            </div>
        </div>
    </form>
    <div class="actions">
        <a class="btn btn-default" href="<?php echo U('Install/step1');?>">上一步</a>
        <button id="submit" type="button" class="btn btn-primary" onclick="$('form').submit();return false;">下一步</button>
    </div>

            </div>
        </div>

    </body>
</html>