/**
 *  index.js
 * Created by Administrator on 2017/2/12.
 */
$(function () {
    $('#worker-category-table').datagrid({
        url : './getWorkerCategory',
        idField : 'id',
        treeField : 'text',
        fit : true,
        fitColumns : true,
        striped : true,
        rownumbers : true,
        pagination : true,
        singleSelect : false,
        checkOnSelect : false,
        toolbar: '#worker-category-tool',
        onClickRow : function( rowIndex, rowData ){
            $(this).datagrid('unselectRow', rowIndex);
        },
        columns : [[
            {
                field : 'check',
                title : 'check',
                width : 100,
                checkbox : true
            },
            {
                field : 'myorder',
                title : '排序',
                width : 30,
                align : 'center',
            },
            {
                field : 'id',
                title : 'ID',
                width : 30,
                align : 'center'
            },
            {
                field : 'text',
                title : '名称',
                width : 100,
            },
            {
                field : 'desc',
                title : '描述信息',
                width : 200
            },
            {
                field : 'operate',
                title : '操作',
                width : 100,
                align : 'center',
                formatter: function(value, row, index){
                    return '<a class="datagrid-cell-btn btn-danger" onClick="workerCategoryTool.edit('+row.id+');">修改</a>';
                }
            }
        ]]
    });

    workerCategoryTool = {
        reload : function () {
            $('#worker-category-table').datagrid('load');
        },
        add : function() {
            $('<form id="worker-category-form" method="post"></form>').dialog({
                width : 350,
                top : 115,
                title : '添加类别',
                modal : true,
                closed : false,
                resizable : true,
                iconCls : 'icon-group_add',
                href : './getWorkerCategoryForm',
                onClose : function(){
                    $(this).dialog('destroy');
                },
                buttons : [{
                    text : '提交',
                    iconCls : 'icon-tick',
                    handler : function () {
                        $('#worker-category-form').form('submit', {
                            url  : './addWorkerCategory',
                            onSubmit : function(){
                                if( !$(this).form('validate') ){
                                    return false;
                                }
                                $.messager.progress({
                                    text : '提交中，请稍等...'
                                });
                                return true;
                            },
                            success : function(data){
                                data = eval('(' + data + ')');
                                $.messager.progress('close');
                                if ( data.state ) {
                                    $('#worker-category-form').dialog('close');
                                    $('#worker-category-table').datagrid('load');
                                } else {
                                    $.messager.alert('添加失败！', data.msg, 'error');
                                }
                            }
                        });

                    },
                },{
                    text : '取消',
                    iconCls : 'icon-cross',
                    handler : function () {
                        $('#systemmenu-form').dialog('close');
                    }
                }]
            });
        },
        edit : function(id){
            $('<form id="worker-category-form" method="post"></form>').dialog({
                width : 350,
                top : 115,
                title : '修改类别',
                modal : true,
                closed : false,
                resizable : true,
                iconCls : 'icon-group_edit',
                href : './getWorkerCategoryForm?id='+id,
                onClose : function(){
                    $(this).dialog('destroy');
                },
                buttons : [{
                    text : '提交',
                    iconCls : 'icon-tick',
                    handler : function () {
                        $('#worker-category-form').form('submit', {
                            url  : './saveWorkerCategory',
                            onSubmit : function(){
                                if( !$(this).form('validate') ){
                                    return false;
                                }
                                $.messager.progress({
                                    text : '提交中，请稍等...'
                                });
                            },
                            success : function(data){
                                $.messager.progress('close');
                                data = eval('(' + data + ')');
                                if(data.state){
                                    $('#worker-category-form').dialog('close');
                                    $('#worker-category-table').datagrid('reload');
                                } else {
                                    $.messager.alert('添加失败！', data.msg, 'error');
                                }

                            }
                        });
                    },
                },{
                    text : '取消',
                    iconCls : 'icon-cross',
                    handler : function () {
                        $('#worker-category-form').dialog('close');
                    }
                }]
            });
        },
        delete : function() {
            var rows = $('#worker-category-table').datagrid('getSelections');
            if (rows.length > 0) {
                $.messager.confirm({
                    title : '删除确认',
                    msg   : '您确定要删除此记录吗？',
                    fn    : function(r){
                        // true and delete
                        if (r) {
                            var ids = [];
                            for (var i = 0; i < rows.length; i ++) {
                                ids.push(rows[i].id);
                            }
                            $.ajax({
                                type : 'POST',
                                url  : './deleteWorkerCategory',
                                data : {
                                    ids : ids.join(',')
                                },
                                beforeSend : function () {
                                    $('#worker-category-table').datagrid('loading');
                                },
                                success : function ( data ) {
                                    if ( data.state ) {
                                        $('#worker-category-table').datagrid('loaded');
                                        $('#worker-category-table').datagrid('load');
                                    } else {
                                        $.messager.alert('删除失败！', data.msg, 'error');
                                    }

                                }
                            });
                        }
                    }
                });
            } else {
                $.messager.alert('提示', '请选择要删除的记录！', 'info');
            }
        }
    };


});