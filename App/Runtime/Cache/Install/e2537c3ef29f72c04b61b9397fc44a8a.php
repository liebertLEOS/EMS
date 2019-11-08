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
        <li class="disabled active"><a href="javascript:;">1.环境检测</a></li>
        <li class="disabled"><a href="javascript:;">2.创建数据库</a></li>
        <li class="disabled"><a href="javascript:;">3.<?php if(($_SESSION['update']) == "1"): ?>升级<?php else: ?>初始化系统<?php endif; ?></a></li>
        <li class="disabled"><a href="javascript:;">4.升级完成</a></li>
    </ul>

    <table class="table table-striped table-bordered">
        <caption><h2>运行环境</h2></caption>
        <thead>
            <tr>
                <th width="40%">项目</th>
                <th width="30%">所需配置</th>
                <th width="30%">当前配置</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($env)): $i = 0; $__LIST__ = $env;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($item[0]); ?></td>
                    <td><?php echo ($item[1]); ?></td>
                    <td><span class="ico-<?php echo ($item[4]); ?>">√&nbsp;<?php echo ($item[3]); ?></span></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>

    <table class="table table-striped table-bordered">
        <caption><h2>依赖性</h2></caption>
        <thead>
            <tr>
                <th width="40%">名称</th>
				<th width="30%">类型</th>
                <th width="30%">检查结果</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($func)): $i = 0; $__LIST__ = $func;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($item[0]); ?></td>
					<td><?php echo ($item[3]); ?></td>
                    <td><span class="ico-<?php echo ($item[2]); ?>">√&nbsp;<?php echo ($item[1]); ?></span></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>

	<?php if(isset($dirfile)): ?><table class="table table-striped table-bordered">
        <caption><h2>目录/文件权限</h2></caption>
        <thead>
            <tr>
                <th width="40%">目录/文件</th>
                <th width="30%">所需状态</th>
                <th width="30%">当前状态</th>
            </tr>
        </thead>
        <tbody>
            <?php if(is_array($dirfile)): $i = 0; $__LIST__ = $dirfile;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$item): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($item[3]); ?></td>
                    <td><span class="ico-success">可写</span></td>
                    <td><span class="ico-<?php echo ($item[2]); ?>">√&nbsp;<?php echo ($item[1]); ?></span></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table><?php endif; ?>
    <div class="actions">
        <a href="<?php echo U('/Index');?>" class="btn btn-default">上一步</a>
        <a href="<?php echo U('Install/step2');?>" class="btn btn-primary">下一步</a>
    </div>


            </div>
        </div>

    </body>
</html>