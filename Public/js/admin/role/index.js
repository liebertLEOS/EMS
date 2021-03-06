/**
 * Created by Administrator on 2017/03/09.
 */
$(function(){
    $('#table').datagrid({
        url : './getRole',
        fit : true,
        fitColumns : true,
        striped : true,
        rownumbers : true,
        border : false,
        pagination : true,
        pageSize : 20,
        pageList : [10, 20, 30, 40, 50],
        pageNumber : 1,
        sortName : 'id',
        sortOrder : 'desc',
        toolbar: '#tool',
        checkOnSelect : false,
        onClickRow : function( rowIndex, rowData ){
            $(this).datagrid('unselectRow', rowIndex);
        },
        columns : [[
            {
                field : 'check',
                title : 'check',
                checkbox : true
            },
            {
                field : 'id',
                title : 'ID',
                width : 30,
                align : 'center'
            },
            {
                field : 'title',
                title : '角色名称',
                width : 50,
                align : 'center'
            },
            {
                field : 'description',
                title : '描述',
                width : 200,
                halign : 'center'
            },
            {
                field : 'status',
                title : '是否启用',
                width : 50,
                align : 'center',
                formatter: function(value, row, index){
                    return value == 1 ? '是' : '否' ;
                }
            },
            {
                field : 'operate',
                title : '操作',
                width : 50,
                align : 'center',
                formatter: function(value, row, index){
                    return '<a class="datagrid-cell-btn btn-success" onClick="Tool.edit('+row.id+');">修改</a>';
                }
            }
        ]]
    });

    Tool = {
        reload : function () {
            $('#table').datagrid('load');
        },
        add : function () {
            $('<form id="form" method="post"></form>').dialog({
                width : 450,
                top   : 115,
                title : '添加角色',
                modal : true,
                iconCls : 'icon-user_suit',
                href    : './getForm',
                onClose : function(){
                    $(this).dialog('destroy');
                },
                buttons : [{
                    text : '提交',
                    iconCls : 'icon-tick',
                    handler : function () {
                        $('#form').form('submit',{
                            url : './add',
                            onSubmit : function(){
                                if( !$(this).form('validate') ){
                                    return false;
                                }
                                $.messager.progress({
                                    text : '提交中，请稍等...'
                                });
                                return true;
                            },
                            success : function( data ){
                                data = eval('(' + data + ')');
                                $.messager.progress('close');
                                if ( data.state ) {
                                    $('#form').dialog('close');
                                    $('#table').datagrid('load');
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
                        $('#form').dialog('close');
                    },
                }]
            });
        },
        edit : function ( id ) {
            $('<form id="form" method="post"></form>').dialog({
                width : 450,
                top   : 115,
                title : '修改角色',
                modal : true,
                iconCls : 'icon-user_suit',
                href    : './getForm?id='+id,
                onClose : function(){
                    $(this).dialog('destroy');
                },
                buttons : [{
                    text : '提交',
                    iconCls : 'icon-tick',
                    handler : function () {
                        $('#form').form('submit',{
                            url : './save',
                            onSubmit : function(){
                                if( !$(this).form('validate') ){
                                    return false;
                                }
                                $.messager.progress({
                                    text : '提交中，请稍等...'
                                });
                                return true;
                            },
                            success : function( data ){
                                data = eval('(' + data + ')');
                                $.messager.progress('close');
                                if ( data.state ) {
                                    $('#form').dialog('close');
                                    $('#table').datagrid('reload');
                                } else {
                                    $.messager.alert('修改失败！', data.msg, 'error');
                                }
                            }
                        });

                    },
                },{
                    text : '取消',
                    iconCls : 'icon-cross',
                    handler : function () {
                        $('#form').dialog('close');
                    },
                }]
            });
        },
        delete : function( ){
            var rows = $('#table').datagrid('getSelections');
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
                                url  : './delete',
                                data : {
                                    ids : ids.join(',')
                                },
                                beforeSend : function () {
                                    $('#table').datagrid('loading');
                                },
                                success : function (data) {
                                    $('#table').datagrid('loaded');
                                    if ( data.state ) {
                                        $('#table').datagrid('load');
                                    } else {
                                        $.messager.alert('提示', data.msg, 'error');
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
    }


});