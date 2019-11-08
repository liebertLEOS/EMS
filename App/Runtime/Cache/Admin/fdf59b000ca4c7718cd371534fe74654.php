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
    <div data-options="region:'west',iconCls:'icon-page_white_excel'" title="已上传文件" style="width:750px;">
        <div style="height:100%;">
            <div id="uploaded-files-tool" style="padding:10px;">
                <form id="uploaded-files-form" method="post" enctype="multipart/form-data" style="display:inline-block;">
                    <input name="files[]" class="easyui-filebox" data-options="buttonText:'选择文件',width:'180px',required:true,multiple:true,accept:'application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'">
                </form>
                <a href="#" class="easyui-linkbutton" iconCls="icon-page_white_get" onclick="uploadedFilesTool.upload();">上传</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-delete" onclick="uploadedFilesTool.delete();">删除</a>
                <a href="#" class="easyui-linkbutton" iconCls="icon-reload" onclick="uploadedFilesTool.reload();">刷新</a>
            </div>

            <div id="uploaded-files-list"></div>
            <div id="uploaded-files-menu" class="easyui-menu" style="width: 50px; display: none;">
                <div data-options="iconCls:'icon-search'" onclick="uploadedFilesTool.openFile();">查看数据</div>
            </div>
        </div>
    </div>
    <div data-options="region:'center',iconCls:'icon-table'" title="数据信息">
        <div id="data-list-tool" class="datagrid-toolbar" style="padding:10px;">
            <a href="#" class="easyui-linkbutton" iconCls="icon-tick" onclick="dataListTool.done();">完成</a>
            <a href="#" class="easyui-linkbutton" iconCls="icon-database_go" onclick="dataListTool.import();">导入</a>
        </div>
        <div id="data-list"></div>
    </div>
</div>



	<!-- script -->
	<script type="text/javascript" src="/Public/easyui/1.5.1/jquery.min.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/jquery.easyui.min.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/easyloader.js"></script>
	<script type="text/javascript" src="/Public/easyui/1.5.1/locale/easyui-lang-zh_CN.js"></script>
	
    <script type="text/javascript" src="/Public/js/admin/employee/import-data.js"></script>

</body>
</html>