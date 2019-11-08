/**
 *  alarm/index.js
 * Created by Administrator on 2017/2/12.
 */
$(function () {

    $('#main-layout').layout({
        height : '100%'
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

        $('#alarm-list').edatagrid({
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
            sortName : 'alarmnumber',
            sortOrder : 'desc',
            checkOnSelect : false,
            multiSort : true,
            toolbar: '#alarm-tool',
            columns : [[
                {
                    field : 'check',
                    title : 'check',
                    checkbox : true,
                },
                {
                    field : 'id',
                    hidden : true
                },
                {
                    field : 'alarmnumber',
                    title : '警情编号',
                    width : 280,
                    halign : 'center',
                    align : 'left',
                    sortable : true,
                    editor:{
                        type : 'textbox',
                        options : {
                            validType : 'length[0,255]',
                            invalidMessage : '长度不能超过255个字符'
                        }
                    }
                },
                {
                    field : 'alarmtype',
                    title : '警情性质',
                    width : 150,
                    align : 'center',
                    sortable : false,
                    editor:{
                        type : 'textbox',
                        options : {
                            validType : 'length[0,255]',
                            invalidMessage : '长度不能超过255个字符'
                        }
                    }
                },
                {
                    field : 'phonenumber',
                    title : '报警电话',
                    width : 150,
                    align : 'center',
                    sortable : false,
                    editor:{
                        type : 'textbox',
                        options : {
                            validType : 'length[0,255]',
                            invalidMessage : '长度不能超过255个字符'
                        }
                    }
                },
                {
                    field : 'alarminfo',
                    title : '报警信息',
                    width : 400,
                    align : 'center',
                    sortable : false,
                    editor:{
                        type : 'textbox',
                        options : {
                            validType : 'length[0,255]',
                            invalidMessage : '长度不能超过255个字符'
                        }
                    }
                }
            ]],
            rowStyler : function( index, row ){
                if ( row.categoryid > 1 ) {
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
            }
        });
    });

    alarmTool = {
        add : function () {
            $('#alarm-list').edatagrid('addRow');
        },
        delete : function() {
            $('#alarm-list').edatagrid('destroyRow');
        },
        save: function () {

        },
        reload : function () {
            $('#alarm-list').edatagrid('load');
        }
    };

});