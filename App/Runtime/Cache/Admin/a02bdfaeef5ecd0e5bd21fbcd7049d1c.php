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
    <div data-options="region:'west',iconCls:'icon-calendar'" title="员工组织结构" style="width:200px;padding:15px;">
        <div id="worker-tree"></div>
    </div>

    <div data-options="region:'center',iconCls:'icon-table'" title="数据信息">
        <div id="tool" style="padding:5px;">
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
                    <span>身份证号码：<input type="text" name="idcard" class="textbox" style="width:180px;height:24px;"></span>
                    <span>送厂日期：<input type="text" name="deliverydateFrom" class="easyui-datebox" editable="false" style="width:110px;"> —
                        <input type="text" name="terminationdateTo" class="easyui-datebox" editable="false" style="width:110px;">
                    </span>
                    <span>是否在职：<input type="checkbox" name="isinservice" class="easyui-checkbox"></span>
                    <a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="tool.query();">查询</a>
                </span>
            </div>
        </div>
        <div id="table"></div>
    </div>

</div>


	<!-- script -->
	<script type="text/javascript" src="/Public/easyui/1.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/easyloader.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/locale/easyui-lang-zh_CN.js"></script>
	
    <?php if(($cate) == "2"): ?><script type="text/javascript" src="/Public/js/admin/employee/worker-leader.js"></script>
    <?php else: ?>
        <script type="text/javascript" src="/Public/js/admin/employee/worker.js"></script><?php endif; ?>


</body>
</html>