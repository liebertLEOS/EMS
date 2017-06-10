/**
 *  index.js
 * Created by Administrator on 2017/2/12.
 */
$(function () {
    $('#table').treegrid({
        url : './getMenu',
        idField : 'id',
        treeField : 'text',
        fit : true,
        fitColumns : true,
        striped : true,
        rownumbers : true,
        pagination : false,
        singleSelect : false,
        checkOnSelect : false,
        toolbar: '#tool',
        onClickRow : function( row ){
            $(this).treegrid('unselect', row.id);
        },
        columns : [[
            {
                field : 'id',
                title : 'ID',
                width : 30,
                align : 'center'
            },
            {
                field : 'myorder',
                title : '排序',
                width : 30,
                align : 'center',
            },
            {
                field : 'text',
                title : '名称',
                width : 100,
            },
            {
                field : 'url',
                title : 'URL',
                width : 100
            },
            {
                field : 'authrule',
                title : '权限规则',
                width : 100
            },
            {
                field : 'hide',
                title : '是否隐藏',
                width : 100,
                align : 'center',
                formatter: function(value){
                    return value == 0 ? '否' : '是';
                }
            },
            {
                field : 'operate',
                title : '操作',
                width : 100,
                align : 'center',
                formatter: function(value, row, index){
                    return '<a class="datagrid-cell-btn btn-success" onClick="Tool.edit('+row.id+');">修改</a> <a class="datagrid-cell-btn btn-danger" onClick="Tool.delete('+row.id+');">删除</a>';
                }
            }
        ]]
    });


    Tool = {
        reload : function () {
            $('#table').treegrid('load');
        },
        add : function() {
            $('<form id="form" method="post"></form>').dialog({
                width : 450,
                top : 115,
                title : '添加菜单',
                modal : true,
                closed : false,
                resizable : true,
                iconCls : 'icon-add-new',
                href : './getForm',
                onClose : function(){
                    $(this).dialog('destroy');
                },
                buttons : [{
                    text : '提交',
                    iconCls : 'icon-tick',
                    handler : function () {
                        $('#form').form('submit', {
                            url  : './add',
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
                                    $('#form').dialog('close');
                                    $('#table').treegrid('load');
                                    parent.$('#side-menu').tree('reload');
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
                    }
                }]
            });
        },
        edit : function(id){
            $('<form id="form" method="post"></form>').dialog({
                width : 450,
                top : 115,
                title : '编辑菜单',
                modal : true,
                closed : false,
                resizable : true,
                iconCls : 'icon-add-new',
                href : './getForm?id='+id,
                onClose : function(){
                    $(this).dialog('destroy');
                },
                buttons : [{
                    text : '提交',
                    iconCls : 'icon-tick',
                    handler : function () {
                        $('#form').form('submit', {
                            url  : './save',
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
                                    $('#form').dialog('close');
                                    $('#table').treegrid('reload');
                                    parent.$('#side-menu').tree('reload');
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
                    }
                }]
            });
        },
        delete : function(id) {
            $.messager.confirm({
                title : '删除确认',
                msg   : '菜单及其子菜单将一并删除，您确定要删除吗？',
                fn    : function(r){
                    // true and delete
                    if (r) {
                        $.ajax({
                            type : 'POST',
                            url  : './delete',
                            data : {
                                id : id
                            },
                            beforeSend : function () {
                                $('#table').treegrid('loading');
                            },
                            success : function ( data ) {
                                if ( data.state ) {
                                    $('#table').treegrid('loaded');
                                    $('#table').treegrid('load');
                                    parent.$('#side-menu').tree('reload');
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