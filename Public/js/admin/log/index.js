/**
 *  index.js
 * Created by Administrator on 2017/2/12.
 */
$(function () {
    $('#table').datagrid({
        url : './getLog',
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
        columns : [[
            {
                field : 'check',
                title : 'check',
                width : 100,
                checkbox : true
            },
            {
                field : 'id',
                title : 'ID',
                width : 50,
                align : 'center'
            },
            {
                field : 'type',
                title : '类型',
                width : 50,
                align : 'center'
            },

            {
                field : 'content',
                title : '日志内容',
                width : 300
            },
            {
                field : 'username',
                title : '操作者',
                width : 100,
                align : 'center',
            },
            {
                field : 'time',
                title : '发生时间',
                width : 100,
                align : 'center',
                sortable : true
            },
            {
                field : 'userip',
                title : '操作者ip',
                width : 100,
                align : 'center'
            },
        ]]
    });


    Tool = {
        reload : function () {
            $('#tool-query input').val('');
            $('#table').datagrid('load',{});
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
                                success : function () {
                                    $('#table').datagrid('loaded');
                                    $('#table').datagrid('load');
                                }
                            });
                        }
                    }
                });
            } else {
                $.messager.alert('提示', '请选择要删除的记录！', 'info');
            }
        },
        query: function(){
            $('#table').datagrid('load', {
                'datefrom' : $('#tool-query input[name="date-from"]').val(),
                'dateto'   : $('#tool-query input[name="date-to"]').val()
            });
        }
    }


});