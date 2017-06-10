/**
 *  index.js
 * Created by Administrator on 2017/2/12.
 */
$(function () {
    easyloader.load('plugins/jquery.edatagrid.js', function(){
        var editRowIndex;

        $.fn.edatagrid.defaults.destroyMsg = {
            norecord:{
                title:'警告',
                msg:'请选择要删除的记录.'
            },
            confirm:{
                title:'确认',
                msg:'您确定要删除选中的记录吗？'
            }
        };

        $('#table').edatagrid({
            url : '../Employee/getWorktime',
            fit : true,
            fitColumns : false,
            striped : true,
            rownumbers : true,
            border : false,
            pagination : true,
            pageSize : 20,
            pageList : [10, 20, 30, 40, 50],
            pageNumber : 1,
            sortName : 'id',
            sortOrder : 'desc',
            toolbar: '#employee-worktime-tool',
            checkOnSelect : false,
            columns : [[
                {
                    field : 'check',
                    title : 'check',
                    checkbox : true
                },
                {
                    field : 'id',
                    title : 'ID',
                    width : 100,
                    halign : 'center',
                    align : 'right'
                },
                {
                    field : 'time',
                    title : '时间',
                    width : 100,
                    halign : 'center',
                    editor:{
                        type : 'datebox',
                        options : {
                            tipPosition : 'top',
                            required : true
                        }
                    }
                },
                {
                    field : 'name',
                    title : '员工姓名',
                    width : 100,
                    halign : 'center',
                    editor:{
                        type : 'combogrid',
                        options : {
                            required : true,
                            tipPosition : 'top',
                            url : '../Employee/getWorkerList',
                            mode : 'remote',
                            loadMsg : '正在查找，请稍等...',
                            delay : 1000,
                            panelWidth : 302,
                            panelHeight : 350,
                            pagination : true,
                            pageSize : 10,
                            pageList : [10, 20],
                            pageNumber : 1,
                            idField : 'name',
                            textField : 'name',
                            columns : [[
                                {
                                    field : 'id',
                                    title : 'ID',
                                    width : 100,
                                    align : 'center'
                                },
                                {
                                    field : 'name',
                                    title : '姓名',
                                    width : 200,
                                    align : 'center'
                                },
                            ]],
                            onSelect : function( rowIndex, rowData ){
                                if( rowData.workerid == '' ) return;
                                var editors  = $('#table').edatagrid('getEditors', editRowIndex);
                                var workerid = editors[2];
                                workerid.target.val(rowData.id);
                            }
                        }
                    }
                },
                {
                    field : 'workerid',
                    title : '员工ID',
                    width : 100,
                    halign : 'center',
                    editor:{
                        type : 'text',
                        required : true
                    }
                },
                {
                    field : 'checkindate',
                    title : '报到日期',
                    width : 100,
                    halign : 'center',
                    editor:{
                        type : 'datebox'
                    }
                },
                {
                    field : 'leavedate',
                    title : '离职日期',
                    width : 100,
                    halign : 'center',
                    editor:{
                        type : 'datebox'
                    }
                },
                {
                    field : 'isagreement',
                    title : '是否满协议',
                    width : 80,
                    align : 'center',
                    halign : 'center',
                    editor:{
                        type : 'checkbox',
                        options : {
                            on  : 'Y',
                            off : 'N'
                        }
                    }

                },
                {
                    field : 'price',
                    title : '工价/元',
                    width : 100,
                    halign : 'center',
                    align : 'right',
                    editor:{
                        type : 'numberbox',
                        options : {
                            groupSeparator : ',',
                            precision : 2
                        }
                    }
                },
                {
                    field : 'totaltime',
                    title : '总工时/小时',
                    width : 100,
                    halign : 'center',
                    align : 'right',
                    editor:{
                        type : 'numberbox',
                        options : {
                            precision : 2
                        }
                    }
                },
                {
                    field : 'overallcost',
                    title : '工衣/元',
                    width : 100,
                    halign : 'center',
                    align : 'right',
                    editor:{
                        type : 'numberbox',
                        options : {
                            groupSeparator : ',',
                            precision : 2
                        }
                    }
                },
                {
                    field : 'iccard',
                    title : 'IC卡/元',
                    width : 100,
                    halign : 'center',
                    align : 'right',
                    editor:{
                        type : 'numberbox',
                        options : {
                            groupSeparator : ',',
                            precision : 2
                        }
                    }
                },
                {
                    field : 'waterandelectricity',
                    title : '水电/元',
                    width : 100,
                    halign : 'center',
                    align : 'right',
                    editor:{
                        type : 'numberbox',
                        options : {
                            groupSeparator : ',',
                            precision : 2
                        }
                    }
                },
                {
                    field : 'penalty',
                    title : '罚款/元',
                    width : 100,
                    halign : 'center',
                    align : 'right',
                    editor:{
                        type : 'numberbox',
                        options : {
                            groupSeparator : ',',
                            precision : 2
                        }
                    }
                },
                {
                    field : 'commercialinsurance',
                    title : '商保/元',
                    width : 100,
                    halign : 'center',
                    align : 'right',
                    editor:{
                        type : 'numberbox',
                        options : {
                            groupSeparator : ',',
                            precision : 2
                        }
                    }
                },
                {
                    field : 'managementcost',
                    title : '管理费/元',
                    width : 100,
                    halign : 'center',
                    align : 'right',
                    editor:{
                        type : 'numberbox',
                        options : {
                            groupSeparator : ',',
                            precision : 2
                        }
                    }
                },
                {
                    field : 'carfare',
                    title : '车费/元',
                    width : 100,
                    halign : 'center',
                    align : 'right',
                    editor:{
                        type : 'numberbox',
                        options : {
                            groupSeparator : ',',
                            precision : 2
                        }
                    }
                },
                {
                    field : 'borrow',
                    title : '借资/元',
                    width : 100,
                    halign : 'center',
                    align : 'right',
                    editor:{
                        type : 'numberbox',
                        options : {
                            groupSeparator : ',',
                            precision : 2
                        }
                    }
                },
                {
                    field : 'liquidateddamages',
                    title : '违约金/元',
                    width : 100,
                    halign : 'center',
                    align : 'right',
                    editor:{
                        type : 'numberbox',
                        options : {
                            groupSeparator : ',',
                            precision : 2
                        }
                    }
                },
                {
                    field : 'addedinfo',
                    title : '备注',
                    width : 300,
                    editor:{
                        type : 'textbox',
                        options : {
                            validType : 'length[0,255]',
                            invalidMessage : '长度不能超过255个字符'
                        }
                    }
                },
                {
                    field : 'categoryid',
                    title : '员工分类id',
                    hidden: true
                }
            ]],
            rowStyler : function( index, row ){
                if ( row.categoryid > 1 ) {
                    return 'background-color:#e0f8fa;';
                }
            },
            onClickRow : function( rowIndex, rowData ){
                $(this).edatagrid('unselectRow', rowIndex);
            },
            onEdit : function( rowIndex, rowData ){
                editRowIndex = rowIndex;
            },
            onAdd : function( rowIndex, rowData ){
                editRowIndex = rowIndex;
            },
            onCheck : function( rowIndex, rowData ){
                var rows = $('#table').edatagrid('getChecked');
                if ( rows.length > 0 ){
                    $('#tool-delete').linkbutton('enable');
                }
            },
            onCheckAll : function(){
                $('#tool-delete').linkbutton('enable');
            },
            onUncheck : function( rowIndex, rowData ){
                var rows = $('#table').edatagrid('getChecked');
                if ( rows.length <= 0 ){
                    $('#tool-delete').linkbutton('disable');
                }
            },
            onUncheckAll : function(){
                $('#tool-delete').linkbutton('disable');
            },
            onBeforeEdit : function( rowIndex, rowData ){
                $('#tool-cancel').linkbutton('enable');
                $('#tool-save').linkbutton('enable');
            },
            onDestroy : function( index, row ){
                $('#tool-delete').linkbutton('disable');
                $('#tool-cancel').linkbutton('enable');
                $('#tool-save').linkbutton('enable');
            }
        });

        tool = {
            add : function(){
                $('#table').edatagrid('addRow');
            },
            delete : function(){
                $('#table').edatagrid('destroyRow');
            },
            reload : function(){
                $('#tool-query input').val('');
                $('#table').edatagrid('load',{});
                $('#tool-delete').linkbutton('disable');
                $('#tool-cancel').linkbutton('disable');
                $('#tool-save').linkbutton('disable');
            },
            cancel : function(){
                $('#table').edatagrid('rejectChanges');
                $('#tool-cancel').linkbutton('disable');
                $('#tool-save').linkbutton('disable');
            },
            save : function(){
                $('#table').edatagrid( 'saveRow' );
                var $edataGrid = $('#table');
                var rowsChanged = $edataGrid.edatagrid( 'getChanges' );
                if ( rowsChanged.length > 0 ) {
                    $('#table').edatagrid('loading');
                    var inserted = $edataGrid.edatagrid( 'getChanges', 'inserted' );
                    var deleted  = $edataGrid.edatagrid( 'getChanges', 'deleted' );
                    var updated  = $edataGrid.edatagrid( 'getChanges', 'updated' );

                    var data = {};
                    if ( inserted.length > 0 ) {
                        data['inserted'] = JSON.stringify(inserted);
                    }
                    if ( deleted.length > 0 ) {
                        data['deleted'] = JSON.stringify(deleted);
                    }
                    if ( updated.length > 0 ) {
                        data['updated'] = JSON.stringify(updated);
                    }
                    $.post( '../Employee/batchProcessWorketime', data, function( response ) {
                        $('#table').edatagrid('loaded');
                        if( response.state ) {
                            $('#table').edatagrid('load');
                            $('#table').edatagrid('acceptChanges');
                            $('#tool-delete').linkbutton('disable');
                            $('#tool-cancel').linkbutton('disable');
                            $('#tool-save').linkbutton('disable');
                        } else {
                            $.messager.alert('错误！', response.msg, 'error');
                        }
                    } );
                }
            },
            query : function (){
                $('#table').datagrid('load', {
                    'name' : $('#tool-query input[name="name"]').val(),
                    'idcard' : $('#tool-query input[name="idcard"]').val(),
                    'timef' : $('#tool-query input[name="time-from"]').val(),
                    'timet' : $('#tool-query input[name="time-to"]').val()
                });
            }
        }


    });



});