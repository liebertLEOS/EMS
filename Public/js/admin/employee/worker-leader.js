/**
 *  index.js
 * Created by Administrator on 2017/2/12.
 */
$(function () {

    $('#main-layout').layout({
        height : '100%'
    });
    $('#worker-tree').tree({
        url : './getWorkerTree',
        lines: true,
        onLoadSuccess : function ( node, data ) {
        },
        onClick : function ( node ) {
        }
    });

    using('plugins/jquery.edatagrid.js', function(){
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
            url : './getWorker?cate=2',
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
            multiSort : true,
            toolbar: '#tool',
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
                    width : 80,
                    halign : 'center',
                    align : 'right',
                    sortable : true
                },
                {
                    field : 'name',
                    title : '姓名',
                    width : 100,
                    halign : 'center',
                    sortable : true,
                    editor:{
                        type : 'validatebox',
                        options : {
                            required : true,
                            validType : 'length[0,50]',
                            tipPosition : 'top',
                            invalidMessage : '长度不能超过50个字符'
                        }
                    }
                },
                {
                    field : 'idcard',
                    title : '身份证号码',
                    width : 250,
                    halign : 'center',
                    editor:{
                        type : 'text'
                    }
                },
                {
                    field : 'phone',
                    title : '联系电话',
                    width : 150,
                    halign : 'center',
                    editor:{
                        type : 'text'
                    }
                },
                {
                    field : 'undercontractwage',
                    title : '未满协议工价',
                    width : 100,
                    halign : 'center',
                    align : 'right',
                    editor:{
                        type : 'numberbox',
                        options : {
                            value : 0,
                            groupSeparator : ',',
                            precision : 2
                        }
                    }
                },
                {
                    field : 'fullagreementwage',
                    title : '满协议工价',
                    width : 100,
                    halign : 'center',
                    align : 'right',
                    editor:{
                        type : 'numberbox',
                        options : {
                            value : 0,
                            groupSeparator : ',',
                            precision : 2
                        }
                    }
                },
                {
                    field : 'commission',
                    title : '工头提成',
                    width : 100,
                    halign : 'center',
                    align : 'right',
                    editor:{
                        type : 'numberbox',
                        options : {
                            value : 0,
                            groupSeparator : ',',
                            precision : 4
                        }
                    }
                },
                {
                    field : 'deliverydate',
                    title : '送厂日期',
                    width : 100,
                    halign : 'center',
                    align : 'center',
                    sortable : true,
                    editor:{
                        type : 'datebox',
                        tipPosition : 'top',
                        required : true
                    }
                },
                {
                    field : 'terminationdate',
                    title : '合同终止日期',
                    width : 100,
                    halign : 'center',
                    align : 'center',
                    sortable : true,
                    editor:{
                        type : 'datebox',
                        tipPosition : 'top',
                        required : true
                    }
                },
                {
                    field : 'isinservice',
                    title : '是否在职',
                    width : 80,
                    align : 'center',
                    halign : 'center',
                    sortable : true,
                    editor:{
                        type : 'checkbox',
                        options : {
                            on  : 'Y',
                            off : 'N'
                        }
                    }

                },
                {
                    field : 'factory',
                    title : '工厂',
                    width : 200,
                    halign : 'center',
                    editor:{
                        type : 'text',
                        options : {
                            required : true,
                            validType : 'length[0,255]',
                            tipPosition : 'top',
                            invalidMessage : '长度不能超过255个字符'
                        }
                    }
                },
                {
                    field : 'addedinfo',
                    title : '备注',
                    width : 300,
                    editor:{
                        type : 'validatebox',
                        options : {
                            validType : 'length[0,255]',
                            invalidMessage : '长度不能超过255个字符'
                        }
                    }
                }
            ]],
            rowStyler : function( index, row ){
                if ( row.originid == 0 ) {
                    return 'background-color:#e0f8fa;';
                }
            },
            onClickRow:function( rowIndex, rowData ){
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
                $('#worker-tree').tree('reload');
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
                    $.post( './batchProcessWorker?cate=2', data, function( response ) {
                        $('#table').edatagrid('loaded');
                        if( response.state ) {
                            $('#table').edatagrid('load');
                            $('#worker-tree').tree('reload');
                            $('#table').edatagrid('acceptChanges');
                            $('#tool-delete').linkbutton('disable');
                            $('#tool-cancel').linkbutton('disable');
                            $('#tool-save').linkbutton('disable');
                            $.messager.alert('提示！', response.msg, 'info');
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
                    'deliverydateFrom' : $('#tool-query input[name="deliverydateFrom"]').val(),
                    'deliverydateTo' : $('#tool-query input[name="deliverydateTo"]').val(),
                    'isinservice' : $('#tool-query input[name="isinservice"]').is(':checked')
                });
            }
        }

    });

});