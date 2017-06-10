/**
 *  index.js
 * Created by Administrator on 2017/2/12.
 */
$(function () {
    $('#table').datagrid({
        url : './getUser',
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
                width : 15,
                align : 'center'
            },
            {
                field : 'userpic',
                title : '头像',
                width : 25,
                align : 'center',
                formatter : function (value) {
                    return '<img src="' + value + '" style="width:25px;height:25px;"/>';
                }
            },
            {
                field : 'name',
                title : '用户名',
                width : 100,
                align : 'center'
            },
            {
                field : 'loginallowed',
                title : '是否允许登陆',
                width : 100,
                align : 'center',
                formatter : function (value) {
                    return value==1 ? '是' : '否';
                }
            },
            {
                field : 'registertime',
                title : '注册时间',
                width : 100,
                align : 'center'
            },
            {
                field : 'lasttime',
                title : '最后登录时间',
                width : 100,
                align : 'center'
            },
            {
                field : 'lastip',
                title : '最后登录ip',
                width : 100,
                align : 'center'
            },
            {
                field : 'operate',
                title : '操作',
                width : 100,
                align : 'center',
                formatter: function(value, row, index){
                    return '<a class="datagrid-cell-btn btn-danger" onClick="Tool.edit('+row.id+');">修改</a>';
                }
            }
        ]]
    });

    Tool = {
        reload : function () {
            $('#tool-query input').val('');
            $('#table').datagrid('load',{});
        },
        edit : function( id ) {
            $('<form id="form" enctype="multipart/form-data" method="post"></form>').dialog({
                width : 400,
                top : 115,
                title : '修改用户信息',
                modal : true,
                closed : false,
                iconCls : 'icon-user-add',
                href : './getForm?id='+id,
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
                                    parent.$('#side-menu').tree('reload');
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
                }],
            });
        },
        delete : function() {
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
                                        parent.$('#side-menu').tree('reload');
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
        },
        add : function(){
            $('<form id="form" enctype="multipart/form-data" method="post"></form>').dialog({
                width : 400,
                top : 115,
                title : '添加用户',
                modal : true,
                closed : false,
                iconCls : 'icon-user-add',
                href : './getForm',
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
                }],
            });
        },
        query: function(){
            $('#table').datagrid('load', {
                'username' : $('#tool-query input[name="username"]').val()
            });
        }
    }

});