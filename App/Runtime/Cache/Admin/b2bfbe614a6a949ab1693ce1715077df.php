<?php if (!defined('THINK_PATH')) exit();?><div id="form-id">
    <?php if(empty($data)): ?><table style="width:100%; padding:20px 35px;">
        <tbody>
        <tr>
            <td width="30%">反馈时间：</td>
            <td width="70%"><input name="alarmlogtime" value="<?php echo ($alarmlogtime); ?>"></td>
        </tr>
        <tr>
            <td>反馈内容：</td>
            <td><input name="alarmlogcontent" type="text"></td>
        </tr>
        </tbody>
    </table>
    <script>
        $('#form-id input[name="alarmlogtime"]').datetimebox({
            width: '100%',
            required : true,
            missingMessage : '请输入时间',
        });
        $('#form-id input[name="alarmlogcontent"]').textbox({
            width : '100%',
            multiline : true,
            missingMessage : '请输入用户密码，长度为6~12位',
            invalidMessage : '密码长度为6~12位',
            validType:['length[0,255]']
        });
    </script>
    <?php else: ?>
    <table style="width:100%; padding:20px 35px;">
        <tbody>
        <tr>
            <td width="30%">反馈时间：</td>
            <td width="70%"><input name="alarmlogtime" value="<?php echo ($data["alarmlogtime"]); ?>"></td>
        </tr>
        <tr>
            <td>反馈内容：</td>
            <td><input name="alarmlogcontent" type="text" value=<?php echo ($data["alarmlogcontent"]); ?>></td>
        </tr>
        <input name="id" type="hidden" value="<?php echo ($data["id"]); ?>">
        </tbody>
    </table>
    <script>
        $('#form-id input[name="alarmlogtime"]').datetimebox({
            width: '100%',
            required : true,
            missingMessage : '请输入时间',
        });
        $('#form-id input[name="alarmlogcontent"]').textbox({
            width : '100%',
            multiline : true,
            missingMessage : '请输入用户密码，长度为6~12位',
            invalidMessage : '密码长度为6~12位',
            validType:['length[0,255]']
        });
    </script><?php endif; ?>
</div>