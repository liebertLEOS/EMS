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
                
    <h1>完成</h1>
    <p><?php if(($_SESSION['update']) == "1"): ?>升级<?php else: ?>安装<?php endif; ?>完成！</p>
	<?php if(isset($info)): echo ($info); endif; ?>

    <div class="actions">
        <a class="btn btn-primary" href="index.php">登录系统</a>
    </div>

            </div>
        </div>

    </body>
</html>