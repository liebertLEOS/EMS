/**
 *  index.js
 * Created by Administrator on 2017/2/12.
 */
$(function () {
/*
    easyloader.load(['plugins/jquery.datagrid-filter.js'], function(){

    });
*/
    $('#table').datagrid({
        url : '../Employee/getWorkSum',
        fit : true,
        fitColumns : false,
        striped : true,
        rownumbers : true,
        border : false,
        pagination : true,
        pageSize : 20,
        pageList : [10, 20, 30, 40, 50],
        pageNumber : 1,
        sortName : 'time',
        sortOrder : 'desc',
        multiSort : true,
        toolbar: '#tool',
        checkOnSelect : true,
        onClickRow : function( rowIndex, rowData ){
            $(this).datagrid('unselectRow', rowIndex);
        },
        columns : [[
            {
                field : 'id',
                title : 'ID',
                width : 100,
                halign : 'center',
                align : 'right',
                sortable : true
            },
            {
                field : 'time',
                title : '时间',
                width : 100,
                align : 'center',
                sortable : true
            },
            {
                field : 'name',
                title : '员工姓名',
                width : 100,
                align : 'center',
                sortable : true
            },
            {
                field : 'idcard',
                title : '身份证号',
                width : 250,
                halign : 'center',
                editor:{
                    type : 'text'
                }
            },
            {
                field : 'phone',
                title : '电话',
                width : 100,
                halign : 'center'
            },
            {
                field : 'factory',
                title : '工厂',
                width : 100,
                align : 'center',
                sortable : true
            },
            {
                field : 'categoryid',
                title : '类别',
                width : 100,
                align : 'center',
                sortable : true
            },
            {
                field : 'deliverydate',
                title : '送厂日期',
                width : 100,
                align : 'center'
            },
            {
                field : 'terminationdate',
                title : '合同终止日期',
                width : 100,
                align : 'center'
            },
            {
                field : 'checkindate',
                title : '报到日期',
                width : 100,
                align : 'center'
            },
            {
                field : 'leavedate',
                title : '离职日期',
                width : 100,
                align : 'center'
            },
            {
                field : 'isinservice',
                title : '是否在职',
                width : 100,
                align : 'center',
                formatter : function (value, row, index) {
                    return value == 'Y' ? '是' : '否';
                },
                sortable : true
            },
            {
                field : 'price',
                title : '单价/元',
                width : 100,
                halign : 'center',
                align : 'right'
            },
            {
                field : 'undercontractwage',
                title : '未满协议工价/元',
                width : 100,
                halign : 'center',
                align : 'right'
            },
            {
                field : 'fullagreementwage',
                title : '满协议工价/元',
                width : 100,
                halign : 'center',
                align : 'right'
            },
            {
                field : 'isagreement',
                title : '是否满协议',
                width : 80,
                align : 'center'
            },
            {
                field : 'totaltime',
                title : '总工时/小时',
                width : 100,
                halign : 'center',
                align : 'right'
            },
            {
                field : 'overallcost',
                title : '工衣/元',
                width : 100,
                halign : 'center',
                align : 'right'
            },
            {
                field : 'iccard',
                title : 'IC卡/元',
                width : 100,
                halign : 'center'
            },
            {
                field : 'waterandelectricity',
                title : '水电/元',
                width : 100,
                halign : 'center',
                align : 'right'
            },
            {
                field : 'penalty',
                title : '罚款/元',
                width : 100,
                halign : 'center',
                align : 'right'
            },
            {
                field : 'commercialinsurance',
                title : '商保/元',
                width : 100,
                halign : 'center',
                align : 'right'
            },
            {
                field : 'managementcost',
                title : '管理费/元',
                width : 100,
                halign : 'center',
                align : 'right'
            },
            {
                field : 'carfare',
                title : '车费/元',
                width : 100,
                halign : 'center',
                align : 'right'
            },
            {
                field : 'borrow',
                title : '借资/元',
                width : 100,
                halign : 'center',
                align : 'right'
            },
            {
                field : 'liquidateddamages',
                title : '违约金/元',
                width : 100,
                halign : 'center',
                align : 'right'
            },
            {
                field : 'worktime_wages',
                title : '员工工时工资/元',
                width : 100,
                halign : 'center',
                align : 'right'
            },
            {
                field : 'commission_wages',
                title : '工头提成工资/元',
                width : 100,
                halign : 'center',
                align : 'right'
            },
            {
                field : 'deductions',
                title : '员工扣除工资/元',
                width : 100,
                halign : 'center',
                align : 'right'
            },
            {
                field : 'real_wages',
                title : '员工实发工资/元',
                width : 100,
                halign : 'center',
                align : 'right'
            },
            {
                field : 'worktime_income',
                title : '公司工时收入/元',
                width : 100,
                halign : 'center',
                align : 'right'
            },
            {
                field : 'real_income',
                title : '公司实际收入/元',
                width : 100,
                halign : 'center',
                align : 'right'
            },
            {
                field : 'worker_addedinfo',
                title : '工人信息备注',
                width : 300
            },
            {
                field : 'worktime_addedinfo',
                title : '工时信息备注',
                width : 300
            },
            {
                field : 'categoryid',
                title : '员工类别id',
                hidden:true
            }
        ]],
        rowStyler : function( index, row ){
            if ( row.categoryid > 1 ) {
                return 'background-color:#e0f8fa';
            }
        }
        /*onCheck : function( rowIndex, rowData ){
         var rows = $('#table').datagrid('getChecked');
         if ( rows.length > 0 ){
         $('#tool-delete').linkbutton('enable');
         }
         },
         onCheckAll : function(){
         $('#tool-delete').linkbutton('enable');
         },
         onUncheck : function( rowIndex, rowData ){
         var rows = $('#table').datagrid('getChecked');
         if ( rows.length <= 0 ){
         $('#tool-delete').linkbutton('disable');
         }
         },
         onUncheckAll : function(){
         $('#tool-delete').linkbutton('disable');
         }*/
    });



    tool = {
        /*delete : function(){
            var $tables = $('#table');
            var $rows = $tables.datagrid('getChecked');
            for ( var i=0; i<$rows.length; i++ ){
                var index = $tables.datagrid( 'getRowIndex',$rows[i] );
                $tables.datagrid('deleteRow',index);
            }
        },*/
        reload : function(){
            $('#tool-query input').val('');
            $('#tool-delete').linkbutton('disable');
            $('#table').datagrid('load',{});
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