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
        <li class="disabled"><a href="javascript:;">2.创建数据库</a></li>
        <li class="disabled active"><a href="javascript:;">3.<?php if(($_SESSION['update']) == "1"): ?>升级<?php else: ?>初始化系统<?php endif; ?></a></li>
        <li class="disabled"><a href="javascript:;">4.升级完成</a></li>
    </ul>

    <h1>升级</h1>
    <p>检测到已经安装过系统，点击下一步开始进行系统升级！</p>

    <div class="actions">
        <a href="<?php echo U('Install/step1');?>" class="btn btn-default">上一步</a>
        <a href="<?php echo U('Install/step3');?>" class="btn btn-primary">下一步</a>
    </div>

            </div>
        </div>

    </body>
</html>