/**
 *  alarm/index.js
 * Created by Administrator on 2017/2/12.
 */
$(function () {

    $('#main-layout').layout({
        height : '100%'
    }); 

    $('#alarm-list').datagrid({
        url : '../Alarm/getAlarm',
        fit : true,
        fitColumns : true,
        striped : true,
        rownumbers : true,
        border : false,
        pagination : true,
        pageSize : 20,
        pageList : [10, 20, 30, 40, 50],
        pageNumber : 1,
        checkOnSelect : false,
        selectOnCheck : false,
        singleSelect : true,
        toolbar: '#alarm-tool',
        columns : [[
            {
                field : 'check',
                title : 'check',
                checkbox : true,
            },
            {
                field : 'alarmnumber',
                title : '警情编号',
                width : 280,
                halign : 'center',
                align : 'left',
                sortable : true,
            },
            {
                field : 'alarmtype',
                title : '警情性质',
                width : 150,
                align : 'center',
                sortable : false,
            },
            {
                field : 'phonenumber',
                title : '报警电话',
                width : 150,
                align : 'center',
                sortable : false,
            },
            {
                field : 'alarminfo',
                title : '报警信息',
                width : 400,
                align : 'center',
                sortable : false,
            }
        ]],
        onSelect : function(rowIndex, rowData){
            alarmlogTool.reload();
        }
    });

    alarmTool = {
        query : function (){
            $('#alarm-list').datagrid('reload', {
                'alarmnumber' : $('#alarm-tool input[name="alarmnumber"]').val(),
                'time-from' :$('#alarm-tool input[name="time-from"]').val(),
                'time-end' :$('#alarm-tool input[name="time-end"]').val()
            });
        }
    };

    $('#alarmlog-list').datagrid({
        url : '../Alarm/getAlarmLog',
        fit : true,
        fitColumns : false,
        striped : true,
        rownumbers : true,
        border : false,
        pagination : true,
        pageSize : 20,
        pageList : [10, 20, 30, 40, 50],
        pageNumber : 1,
        sortName : 'alarmlogtime',
        sortOrder : 'desc',
        multiSort : true,
        checkOnSelect : false,
        toolbar: '#alarmlog-tool',
        columns : [[
            {
                field : 'check',
                title : 'check',
                checkbox : true
            },
            {
                field : 'id',
                hidden : true
            },
            {
                field : 'alarmlogtime',
                title : '时间',
                width : 150,
                halign : 'center',
                sortable : true,
            },
            {
                field : 'alarmlogcontent',
                title : '内容',
                width : 300,
            },
            {
                field : 'operate',
                title : '操作',
                width : 100,
                align : 'center',
                formatter: function(value, row, index){
                    return '<a class="datagrid-cell-btn btn-danger" onClick="alarmlogTool.edit('+row.id+');">修改</a>';
                }
            }
        ]],
        onClickRow : function( rowIndex, rowData ){
            $(this).datagrid('unselectRow', rowIndex);
        },
    });

    alarmlogTool = {
        add : function () {
            $('<form id="form" enctype="multipart/form-data" method="post"></form>').dialog({
                width : 400,
                top : 115,
                title : '添加反馈',
                modal : true,
                closed : false,
                iconCls : 'icon-user-add',
                href : './getAlarmLogForm',
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
        delete : function() {
            var rows = $('#alarmlog-list').datagrid('getSelections');
            if (rows.length > 0) {
                $.messager.confirm({
                    title : '删除确认',
                    msg   : '您确定要删除吗？',
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
                                    $('#alarmlog-list').datagrid('loading');
                                },
                                success : function () {
                                    $('#alarmlog-list').datagrid('loaded');
                                    $('#alarmlog-list').datagrid('load');
                                }
                            });
                        }
                    }
                });
            } else {
                $.messager.alert('提示', '请选择要删除的记录！', 'info');
            }
        },
        // reload data from table alarmlog
        reload : function () {
            var selectRow = $('#alarm-list').datagrid('getSelected');
            $('#alarmlog-list').datagrid('load', {
                alarmnumber : selectRow.alarmnumber,
            });
        }
    }

});