$(function () {

	//管理员帐号验证
	$('#username').textbox({
		height: '30',
		width : '100%',
		iconCls: 'icon-user',
		required : true,
		missingMessage : '请输入管理员帐号',
		invalidMessage : '管理员帐号不得为空'
	});
	
	//管理员密码验证
	$('#password').passwordbox({
		height: '30',
		width : '100%',
		required : true,
		validType : 'length[1,30]',
		missingMessage : '请输入管理员密码',
		invalidMessage : '管理员密码长度为1—30'
	});
	$('#btn-login').click(function(){
		$('#login-form').form('submit', {
			url  : 'login',
			type : 'post',
			onSubmit : function(){
				if( !$(this).form('validate') ){
					return false;
				}
				$.messager.progress({
					text : '正在登录中，请稍等...'
				});
			},
			success : function(data){
				$.messager.progress('close');
				data = eval('(' + data + ')');
				if(data.state){
					location.href = data.url;
				} else {
					$.messager.alert('登录失败！', data.msg, 'warning', function () {
						$('#password').select();
					});
				}

			}
		});
		return false;
	});


	
});








