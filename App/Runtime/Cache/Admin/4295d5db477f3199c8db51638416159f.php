<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html style="width:100%;height:100%;">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-COMPATIBLE" content="IE=edge">
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
	<link rel="stylesheet" type="text/css" href="/Public/easyui/1.5.1/themes/default/easyui.css">
	<link rel="stylesheet" type="text/css" href="/Public/easyui/1.5.1/themes/icon.css">
	<link rel="stylesheet" type="text/css" href="/Public/css/admin-iframe.css">
</head>
<body class="iframe" scroll="no" style="padding:0;margin:0;width:100%;height:100%;">

	<!-- content  -->
	
    <div id="tool" style="padding:5px;">
        <div  style="margin-bottom:5px;height:30px;line-height:30px;">
            <a href="#" class="easyui-linkbutton" iconCls="icon-add-new" onclick="Tool.add();">添加</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-delete" onclick="Tool.delete();">删除</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-arrow_refresh" onclick="Tool.reload();">刷新</a>
        </div>
        <div id="tool-query">
            <span>查询用户：<input type="text" class="textbox" name="username" style="width:150px;height:24px;"></span>
            <a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="Tool.query();">查询</a>
        </div>
    </div>

    <div style="height:100%;">
        <table id="table"></table>
    </div>


	<!-- script -->
	<script type="text/javascript" src="/Public/easyui/1.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/easyloader.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/locale/easyui-lang-zh_CN.js"></script>
	
    <script type="text/javascript" src="/Public/js/admin/user/index.js"></script>

</body>
</html>