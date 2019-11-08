<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<title>南山派出所侦办队管理系统</title>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-COMPATIBLE" content="IE=edge">
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
	<link rel="stylesheet" type="text/css" href="/Public/easyui/1.5.1/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="/Public/easyui/1.5.1/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="/Public/css/admin.css">
</head>

<body class="login" >

	<div class="top-block"></div>

	<div class="form-table">

		<!-- 装饰 -->
		<div class="form-table-hd">
		</div>

		<div class="form-table-bd">
			<!-- 表单 -->
			<h2 class="form-tt">南山派出所侦办队管理系统</h2>
			<form id="login-form" method="post" >

				<p class="form-control">
					<input id="username" name="username" type="text" placeholder="请输入用户名或邮箱">
				</p>

				<p class="form-control">
					<input id="password" name="password" type="text" placeholder="请输入密码">
				</p>

				<div class="form-footer">
					<p>
					<span class="info-left"><a href="#" class="easyui-tooltip" title="请联系管理员！">忘记密码?</a></span>
					<span class="info-right">
						<input id="remember" name="remember" type="checkbox"><label for="remember" title="默认记住时间为3天" class="easyui-tooltip">记住账号</label>
						<input id="btn-login" type="submit" value="登录" title="按[回车]键登陆" class="easyui-tooltip">
					</span>
					</p>
				</div>

			</form>
		</div>

	</div>

	<!-- script -->
	<script type="text/javascript" src="/Public/easyui/1.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/locale/easyui-lang-zh_CN.js"></script>
	<script type="text/javascript" src="/Public/js/admin/login/login.js"></script>
</body>
</html>