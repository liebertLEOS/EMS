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
    <div data-options="region:'west',iconCls:'icon-page_white_excel',split:'true'" title="警情列表" style="width:700px;">
        <div style="height:100%;">
            <div id="alarm-tool" style="padding:10px;">
                <span>警情编号：<input type="text" name="alarmnumber" class="textbox" style="width:200px;height:24px;"></span>
                <span>时间：
                    <input type="text" name="time-from" class="easyui-datebox" editable="false" style="width:110px;"> —
                    <input type="text" name="time-end" class="easyui-datebox" editable="false" style="width:110px;">
                </span>
                <a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="alarmTool.query();">查询</a>
            </div>
            <div id="alarm-list"></div>
        </div>
    </div>
    <div data-options="region:'center',iconCls:'icon-table'" title="反馈列表">
        <div id="alarmlog-tool" class="datagrid-toolbar" style="padding:10px;">
            <a href="#" class="easyui-linkbutton" iconCls="icon-add" id="alarmlogTool-add" onclick="alarmlogTool.add();">新增</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-delete" id="alarmlogTool-delete" onclick="alarmlogTool.delete();">删除</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-reload" onclick="alarmlogTool.reload();">刷新</a>
        </div>
        <div id="alarmlog-list"></div>
    </div>
</div>



	<!-- script -->
	<script type="text/javascript" src="/Public/easyui/1.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/easyloader.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/locale/easyui-lang-zh_CN.js"></script>
	
    <script type="text/javascript" src="/Public/js/admin/alarm/alarm-log.js"></script>

</body>
</html>