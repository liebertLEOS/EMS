/**
 * Created by Administrator on 2017/03/09.
 */
$(function(){
    $('#table').treegrid({
        url : './getRule',
        idField : 'id',
        treeField : 'title',
        fit : true,
        fitColumns : true,
        striped : true,
        rownumbers : true,
        border : false,
        pagination : false,
        toolbar: '#tool',
        checkOnSelect : false,
        onClickRow : function( row ){
            $(this).treegrid('unselect', row.id);
        },
        columns : [[
            {
                field : 'title',
                title : '规则名称',
                width : 80,
                halign : 'center'
            },
            {
                field : 'type',
                title : '规则类型',
                width : 30,
                align : 'center',
                formatter: function(value, row, index){
                    switch(value){
                        case '1' : return 'URL';
                        case '2' : return '菜单';
                    }
                }
            },
            {
                field : 'module',
                title : '模块名称',
                width : 30,
                halign : 'center'
            },
            {
                field : 'name',
                title : '规则URL',
                width : 120,
                halign : 'center'
            },
            {
                field : 'condition',
                title : '附加条件',
                width : 120,
                halign : 'center'
            },
            {
                field : 'description',
                title : '描述',
                width : 150,
                halign : 'center'
            },
            {
                field : 'status',
                title : '是否启用',
                width : 30,
                align : 'center',
                formatter: function(value, row, index){
                    return value == 1 ? '是' : '否' ;
                }
            },
            {
                field : 'operate',
                title : '操作',
                width : 60,
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
        add : function () {
            $('<form id="form" method="post"></form>').dialog({
                width : 400,
                top   : 115,
                title : '添加规则',
                modal : true,
                iconCls : 'icon-lock_add',
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
                                    $('#table').treegrid('reload');
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
        edit : function ( id ) {
            $('<form id="form" method="post"></form>').dialog({
                width : 400,
                top   : 115,
                title : '修改规则',
                modal : true,
                iconCls : 'icon-lock_edit',
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
                                    $('#table').treegrid('reload');
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
        delete : function( id ){
            $.messager.confirm({
                title : '删除确认',
                msg   : '节点及其子节点将一并删除，您确定要删除吗？',
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
                                } else {
                                    $.messager.alert('删除失败！', data.msg, 'error');
                                }
                            }
                        });
                    }
                }
            });
        }
    }


});