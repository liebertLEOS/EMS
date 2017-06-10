/**
 *  index.js
 * Created by Administrator on 2017/2/12.
 */
$(function () {
    $('#side-menu').tree({
        url : '/Admin/Index/getSideMenu',
        lines: true,
        onLoadSuccess : function ( node, data ) {
            if (data) {
                $(data).each(function (index, value) {
                    if (this.state == 'closed') {
                        $('#nav').tree('expandAll');
                    }
                });
            }
        },
        onClick : function ( node ) {
            $tabs = $('#main-tabs');
            if ( node.url ) {
                if ($tabs.tabs('exists', node.text)){
                    $tabs.tabs('select', node.text);
                } else {
                    $tabs.tabs('add', {
                        title    : node.text,
                        iconCls  : node.iconCls,
                        height : '100%',
                        closable : true,
                        content  : '<iframe src="/' + node.url + '" scrolling="no" frameborder="0" width="100%" height="100%">'
                    });
                    $tabs.tabs('update',{
                        tab : $tabs.tabs('getSelected'),
                        options : {
                            content  : '<iframe src="/' + node.url + '" scrolling="no" frameborder="0" width="100%" height="100%">'
                        }
                    });
                }
            }
        }
    });

    User = {
        setting : function( userid ){

            $('<form id="form" enctype="multipart/form-data" method="post"></form>').dialog({
                width : 400,
                top : 115,
                title : '修改用户信息',
                modal : true,
                closed : false,
                iconCls : 'icon-user-add',
                href : '/Admin/Index/getUserSettingForm',
                onClose : function(){
                    $(this).dialog('destroy');
                },
                buttons : [{
                    text : '提交',
                    iconCls : 'icon-tick',
                    handler : function () {
                        $('#form').form('submit',{
                            url : '/Admin/Index/saveUserSetting',
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
                                    window.location.reload();
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
        }
    }

});