/**
 *  index.js
 * Created by Administrator on 2017/2/12.
 */
$(function () {
    $('#table').datagrid({
        url : './getExport',
        fit : true,
        fitColumns : true,
        striped : true,
        rownumbers : true,
        toolbar: '#tool',
        columns : [[
            {
                field : 'check',
                title : 'check',
                checkbox : true
            },
            {
                field : 'name',
                title : '表名',
                width : 100,
                halign : 'center'
            },
            {
                field : 'engine',
                title : '类型',
                width : 50,
                halign : 'center'
            },
            {
                field : 'version',
                title : '版本',
                width : 30,
                halign : 'center'
            },
            {
                field : 'collation',
                title : '字符集校对',
                width : 50,
                halign : 'center'
            },
            {
                field : 'rows',
                title : '数据量/个',
                width : 30,
                halign : 'center',
                align : 'right'
            },
            {
                field : 'data_length',
                title : '数据大小',
                width : 30,
                halign : 'center',
                align : 'right'
            },
            {
                field : 'create_time',
                title : '创建时间',
                width : 100,
                align : 'center'
            },
            {
                field : 'update_time',
                title : '更新时间',
                width : 100,
                align : 'center'
            }
        ]]
    });

    Tool = {
        export : function(){
            var rows = $('#table').datagrid('getSelections');
            if (rows.length > 0) {
                $.messager.confirm({
                    title : '备份确认',
                    msg   : '您确定要备份选中的数据表吗？',
                    fn    : function(r){
                        // true and delete
                        if (r) {
                            var tables = [];
                            for (var i = 0; i < rows.length; i ++) {
                                tables.push(rows[i].name);
                            }

                            $.ajax({
                                type : 'POST',
                                url  : './doExport',
                                data : {
                                    tables : tables
                                },
                                beforeSend : function () {
                                    $('#table').datagrid('loading');
                                    window.onbeforeunload = function(){ return "正在备份数据库，请不要关闭！" }
                                },
                                success : function ( data ) {
                                    $('#table').datagrid('loaded');
                                    window.onbeforeunload = function(){ return null; }
                                    if ( data.state ) {
                                        $('#table').datagrid('load');
                                        $.messager.alert('备份成功！', data.msg, 'info');
                                    } else {
                                        $.messager.alert('备份失败！', data.msg, 'error');
                                    }
                                }
                            });
                        }
                    }
                });
            } else {
                $.messager.alert('提示', '请选择要备份的数据表！', 'info');
            }
        },
        optimize : function(){
            var rows = $('#table').datagrid('getSelections');
            if (rows.length > 0) {
                $.messager.confirm({
                    title : '优化确认',
                    msg   : '您确定要优化选中的数据表吗？',
                    fn    : function(r){
                        // true and delete
                        if (r) {
                            var tables = [];
                            for (var i = 0; i < rows.length; i ++) {
                                tables.push(rows[i].name);
                            }

                            $.ajax({
                                type : 'POST',
                                url  : './optimize',
                                data : {
                                    tables : tables
                                },
                                beforeSend : function () {
                                    $('#table').datagrid('loading');
                                },
                                success : function ( data ) {
                                    $('#table').datagrid('loaded');
                                    if ( data.state ) {
                                        $('#table').datagrid('load');
                                    } else {
                                        $.messager.alert('优化失败！', data.msg, 'error');
                                    }
                                }
                            });
                        }
                    }
                });
            } else {
                $.messager.alert('提示', '请选择要优化的数据表！', 'info');
            }

        },
        repair : function(){
            var rows = $('#table').datagrid('getSelections');
            if (rows.length > 0) {
                $.messager.confirm({
                    title : '修复确认',
                    msg   : '您确定要修复选中的数据表吗？',
                    fn    : function(r){
                        // true and delete
                        if (r) {
                            var tables = [];
                            for (var i = 0; i < rows.length; i ++) {
                                tables.push(rows[i].name);
                            }

                            $.ajax({
                                type : 'POST',
                                url  : './repair',
                                data : {
                                    tables : tables
                                },
                                beforeSend : function () {
                                    $('#table').datagrid('loading');
                                },
                                success : function ( data ) {
                                    $('#table').datagrid('loaded');
                                    if ( data.state ) {
                                        $('#table').datagrid('load');
                                    } else {
                                        $.messager.alert('修复失败！', data.msg, 'error');
                                    }
                                }
                            });
                        }
                    }
                });
            } else {
                $.messager.alert('提示', '请选择要修复的数据表！', 'info');
            }
        }

    };


});