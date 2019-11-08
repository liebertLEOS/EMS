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
	
    <div id="tool">
        <div  style="margin-bottom:5px;height:30px;line-height:30px;">
            <a href="#" class="easyui-linkbutton" iconCls="icon-add-new" onclick="Tool.add();">添加</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-arrow_refresh" onclick="Tool.reload();">重载</a>
        </div>
    </div>

    <div style="width:100%;height:100%;">
        <table id="table"></table>
    </div>


	<!-- script -->
	<script type="text/javascript" src="/Public/easyui/1.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/easyloader.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/locale/easyui-lang-zh_CN.js"></script>
	
    <script type="text/javascript" src="/Public/js/admin/menu/index.js"></script>

</body>
</html>