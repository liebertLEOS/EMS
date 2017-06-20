/**
 *  index.js
 * Created by Administrator on 2017/2/12.
 */
$(function () {

    $('#main-layout').layout({
        height : '100%'
    });

    $('#uploaded-files-list').datagrid({
        url : '../Employee/getUploadedFiles',
        fit : true,
        fitColumns : true,
        striped : true,
        rownumbers : true,
        border : false,
        sortName : 'time',
        sortOrder : 'desc',
        multiSort : true,
        checkOnSelect : false,
        selectOnCheck : false,
        toolbar: '#uploaded-files-tool',
        columns : [[
            {
                field : 'check',
                title : 'check',
                checkbox : true,
            },
            {
                field : 'name',
                title : '文件名',
                width : 150,
                halign : 'center',
                align : 'left',
                sortable : true
            },
            {
                field : 'mtime',
                title : '修改日期',
                width : 120,
                align : 'center',
                sortable : true
            },
            {
                field : 'size',
                title : '大小',
                width : 70,
                halign : 'center',
                align : 'right',
                sortable : true
            }
        ]],
        onClickRow : function( rowIndex, rowData ){
            $(this).datagrid('unselectRow', rowIndex);
        },
        onRowContextMenu : function(e, rowIndex, rowData){
            e.preventDefault(); //阻止浏览器捕获右键事件
            $(this).datagrid('unselectAll');
            $(this).datagrid("selectRow", rowIndex);
            $('#uploaded-files-menu').menu('show', {
                left: e.pageX,//在鼠标点击处显示菜单
                top: e.pageY
            });
        }
    });

    using('plugins/jquery.edatagrid.js', function(){
        var editRowIndex;

        $('#data-list').edatagrid({
            fit : true,
            fitColumns : false,
            striped : true,
            rownumbers : true,
            border : false,
            toolbar: '#data-list-tool',
            columns : [[
                {
                    field : 'check',
                    title : 'check',
                    checkbox : true
                },
                {
                    field : '0',
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
                    field : '1',
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
                                var editors  = $('#data-list').edatagrid('getEditors', editRowIndex);
                                var workerid = editors[2];
                                workerid.target.val(rowData.id);
                            }
                        }
                    }
                },
                {
                    field : '2',
                    title : '员工ID',
                    width : 100,
                    halign : 'center',
                    editor:{
                        type : 'text',
                        required : true
                    }
                },
                {
                    field : '3',
                    title : '报到日期',
                    width : 100,
                    halign : 'center',
                    editor:{
                        type : 'datebox'
                    }
                },
                {
                    field : '4',
                    title : '离职日期',
                    width : 100,
                    halign : 'center',
                    editor:{
                        type : 'datebox'
                    }
                },
                {
                    field : '5',
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
                    field : '6',
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
                    field : '7',
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
                    field : '8',
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
                    field : '9',
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
                    field : '10',
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
                    field : '11',
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
                    field : '12',
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
                    field : '13',
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
                    field : '14',
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
                    field : '15',
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
                    field : '16',
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
                    field : '17',
                    title : '备注',
                    width : 300,
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
            onClickRow : function( rowIndex, rowData ){
                $(this).edatagrid('unselectRow', rowIndex);
            },
            onEdit : function( rowIndex, rowData ){
                editRowIndex = rowIndex;
            }
        });

        uploadedFilesTool = {
            reload : function () {
                $('#uploaded-files-list').datagrid('load');
            },
            upload : function () {
                $('#uploaded-files-form').form('submit',{
                    url : './uploadFiles',
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
                            $('#uploaded-files-list').datagrid('reload');
                        } else {
                            $.messager.alert('上传失败！', data.msg, 'error');
                        }
                    }
                });
            },
            delete : function () {
                var rows = $('#uploaded-files-list').datagrid('getChecked');
                if (rows.length > 0) {
                    $.messager.confirm({
                        title : '删除确认',
                        msg   : '您确定要删除此记录吗？',
                        fn    : function(r){
                            // true and delete
                            if (r) {
                                var files = [];
                                for (var i = 0; i < rows.length; i ++) {
                                    files.push(rows[i]['name']);
                                }
                                $.ajax({
                                    type : 'POST',
                                    url  : './deleteUploadedFiles',
                                    data : {
                                        files : files
                                    },
                                    beforeSend : function () {
                                        $('#uploaded-files-list').datagrid('loading');
                                    },
                                    success : function () {
                                        $('#uploaded-files-list').datagrid('loaded');
                                        $('#uploaded-files-list').datagrid('load');
                                    }
                                });
                            }
                        }
                    });
                } else {
                    $.messager.alert('提示', '请选择要删除的记录！', 'info');
                }
            },
            openFile : function(){
                var row = $('#uploaded-files-list').datagrid('getSelected');
                if ( row ) {
                    $.ajax({
                        type : 'POST',
                        url  : './getDataFromFile?f='+row['name'],
                        beforeSend : function () {
                            $('#uploaded-files-list').datagrid('loading');
                            $('#data-list').edatagrid('loading');
                        },
                        success : function ( response ) {
                            $('#uploaded-files-list').datagrid('loaded');
                            $('#data-list').edatagrid('loaded');
                            if( response.state == 1 ) {
                                $('#data-list').edatagrid({
                                    data :　response.data
                                });
                            } else {
                                alert(response.msg);
                            }

                        }
                    });
                }
            }
        };

        dataListTool = {
            done : function () {
                $('#data-list').edatagrid('saveRow');
            }
        }
    });

});