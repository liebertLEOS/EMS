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
	
<div id="main-layout" class="easyui-layout">
    <div data-options="region:'center',iconCls:'icon-page_white_excel'" title="警情列表">
        <div style="height:100%;">
            <div id="alarm-tool" style="padding:10px;">
                <a href="#" class="easyui-linkbutton" iconCls="icon-add" onclick="alarmTool.add();">添加</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-delete" onclick="alarmTool.delete();">删除</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-save" onclick="alarmTool.save();">保存</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-reload" onclick="alarmTool.reload();">刷新</a>
            </div>

            <div id="alarm-list"></div>
        </div>
    </div>
</div>



	<!-- script -->
	<script type="text/javascript" src="/Public/easyui/1.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/easyloader.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/locale/easyui-lang-zh_CN.js"></script>
	
    <script type="text/javascript" src="/Public/js/admin/alarm/index.js"></script>

</body>
</html>