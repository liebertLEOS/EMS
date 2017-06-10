/**
 *  index.js
 * Created by Administrator on 2017/2/12.
 */
$(function () {
    $('#table').datagrid({
        url : './getImport',
        fit : true,
        fitColumns : true,
        striped : true,
        toolbar: '#tool',
        rownumbers : true,
        border : false,
        pagination : true,
        pageSize : 20,
        pageList : [10, 20, 30, 40, 50],
        pageNumber : 1,
        onClickRow : function( rowIndex, rowData ){
            $(this).datagrid('unselectRow', rowIndex);
        },
        columns : [[
            {
                field : 'name',
                title : '备份项目名',
                width : 150,
                halign : 'center'
            },
            {
                field : 'part',
                title : '卷数',
                width : 50,
                align : 'center'
            },
            {
                field : 'compress',
                title : '压缩',
                width : 50,
                align : 'center'
            },
            {
                field : 'size',
                title : '数据大小',
                width : 50,
                align : 'center'
            },
            {
                field : 'time',
                title : '备份时间',
                width : 100,
                align : 'center'
            },
            {
                field : 'operate',
                title : '操作',
                width : 80,
                align : 'center',
                formatter: function(value, row, index){
                    return '<a class="datagrid-cell-btn btn-success" onClick="Tool.import(\''+row.name+'\');">还原</a> <a class="datagrid-cell-btn btn-danger" onClick="Tool.delete(\''+row.name+'\');">删除</a>';
                }
            }
        ]]
    });

    Tool = {
        import : function(name){
            $.messager.confirm({
                title : '恢复确认',
                msg   : '恢复后数据库将被覆盖，您确定要恢复此备份项目数据吗？',
                fn    : function(r){
                    // true and delete
                    if (r) {
                        $.ajax({
                            type : 'POST',
                            url  : './doImport',
                            data : {
                                name : name
                            },
                            beforeSend : function () {
                                $('#table').datagrid('loading');
                                window.onbeforeunload = function(){ return "正在还原数据库，请不要关闭！" }
                            },
                            success : function ( data ) {
                                $('#table').datagrid('loaded');
                                window.onbeforeunload = function(){ return null; }
                                if ( data.state ) {
                                    $('#table').datagrid('load');
                                    $.messager.alert('恢复成功！', data.msg, 'info');
                                } else {
                                    $.messager.alert('恢复失败！', data.msg, 'error');
                                }
                            }
                        });
                    }
                }
            });
        },
        delete : function(name){
            $.messager.confirm({
                title : '删除确认',
                msg   : '您确定要删除此备份项目吗？',
                fn    : function(r){
                    // true and delete
                    if (r) {
                        $.ajax({
                            type : 'POST',
                            url  : './deleteBackup',
                            data : {
                                name : name
                            },
                            beforeSend : function () {
                                $('#table').datagrid('loading');
                            },
                            success : function ( data ) {
                                $('#table').datagrid('loaded');
                                if ( data.state ) {
                                    $('#table').datagrid('load');
                                } else {
                                    $.messager.alert('删除失败！', data.msg, 'error');
                                }
                            }
                        });
                    }
                }
            });
        }

    };


});