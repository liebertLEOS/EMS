<?php if (!defined('THINK_PATH')) exit();?><div id="form-id" style="padding:20px 35px;">
    <table style="width:100%;">
        <tbody>
        <tr>
            <td width="35%">用户名：</td>
            <td width="65%"><input name="name" type="text" value="<?php echo ($data["name"]); ?>"></td>
        </tr>
        <tr>
            <td>密码：</td>
            <td><input name="password" type="text" value="<?php echo ($data["password"]); ?>"></td>
        </tr>
        <tr>
            <td>邮箱：</td>
            <td><input name="email" type="email" value="<?php echo ($data["email"]); ?>"></td>
        </tr>
        <tr>
            <td>QQ：</td>
            <td><input name="qq" type="text" value="<?php echo ($data["qq"]); ?>"></td>
        </tr>
        <tr>
            <td>手机：</td>
            <td><input name="phone" type="text" value="<?php echo ($data["phone"]); ?>"></td>
        </tr>
        <tr>
            <td>角色：</td>
            <td><input name="group_id" type="text" value="<?php echo ($data["group_id"]); ?>"></td>
        </tr>
        <tr>
            <td>头像预览：</td>
            <td><img src="<?php echo ($data["userpic"]); ?>" style="height:40px;width:40px;"></td>
        </tr>
        <tr>
            <td>头像：</td>
            <td><input name="userpic" type="text"></td>
        </tr>
        <tr>
            <td>是否允许登陆：</td>
            <td><input name="loginallowed" <?php if(($data["loginallowed"]) == "1"): ?>checked<?php endif; ?>></td>
        </tr>
        <input name="id" type="hidden" value="<?php echo ($data["id"]); ?>">
        </tbody>
    </table>
    <script>
        $('#form-id input[name="qq"]').textbox({
            width: '100%',
            iconCls : 'icon-tux'
        });
        $('#form-id input[name="phone"]').textbox({
            width: '100%',
            iconCls : 'icon-phone'
        });
        $('#form-id input[name="name"]').textbox({
            width: '100%',
            iconCls : 'icon-user',
            required : true,
            validType : 'length[1,50]',
            missingMessage : '请输入用户名，长度为1~50位',
            invalidMessage : '用户名长度为1~50位'
        });
        $('#form-id input[name="password"]').passwordbox({
            width: '100%',
            validType : 'length[6,12]',
            missingMessage : '请输入用户密码，长度为6~12位',
            invalidMessage : '密码长度为6~12位',
            showEye  : true
        });
        $('#form-id input[name="email"]').textbox({
            width: '100%',
            iconCls : 'icon-email',
            required : true,
            validType : 'email',
            missingMessage : '请输入用户邮箱',
            invalidMessage : '邮箱不合法'
        });
        $('#form-id input[name="group_id"]').combobox({
            width: '100%',
            url : '../Role/getRole',
            valueField : 'id',
            textField : 'title',
            editable : false,
            required : true,
            missingMessage : '请选择用户角色',
            invalidMessage : '请选择用户角色'
        });
        $('#form-id input[name="userpic"]').filebox({
            width: '100%',
            buttonText : '选择文件',
            accept: 'image/*'
        });
        $('#form-id input[name="loginallowed"]').switchbutton({
            onText: '是',
            offText: '否'
        });
    </script>
</div>