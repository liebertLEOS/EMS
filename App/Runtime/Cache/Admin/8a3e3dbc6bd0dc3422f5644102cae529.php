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
	
<div style="height:100%;">
    <div id="employee-worktime-tool" style="padding:5px;">
        <div  style="margin-bottom:5px;height:30px;line-height:30px;">
            <a href="#" class="easyui-linkbutton" iconCls="icon-add" id="tool-add" onclick="tool.add();">新增</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-delete" disabled="true" id="tool-delete" onclick="tool.delete();">删除</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-arrow_undo" disabled="true" id="tool-cancel" onclick="tool.cancel();">撤销</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-save" disabled="true" id="tool-save" onclick="tool.save();">保存</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-reload" onclick="tool.reload();">刷新</a>
        </div>
        <div id="tool-query">
            <span>
                <span>员工姓名：<input type="text" name="name" class="textbox" style="width:100px;height:24px;"></span>
                <span>身份证号码：<input type="text" name="idcard" class="textbox" style="width:200px;height:24px;"></span>
                <span>时间：
                    <input type="text" name="time-from" class="easyui-datebox" editable="false" style="width:110px;"> —
                    <input type="text" name="time-to" class="easyui-datebox" editable="false" style="width:110px;">
                </span>
            </span>
            <a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="tool.query();">查询</a>
        </div>
    </div>
    <div id="table"></div>
</div>


	<!-- script -->
	<script type="text/javascript" src="/Public/easyui/1.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/easyloader.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/locale/easyui-lang-zh_CN.js"></script>
	
    <script type="text/javascript" src="/Public/js/admin/employee/worktime.js"></script>

</body>
</html>