<?php if (!defined('THINK_PATH')) exit();?><div id="userrole-form-id">
<?php if(empty($data)): ?><table style="width:100%; padding:20px 35px;">
        <tbody>
        <tr>
            <td width="20%">角色名：</td>
            <td width="80%"><input name="title" type="text"></td>
        </tr>
        <tr>
            <td>描述：</td>
            <td><input name="description" type="text"></td>
        </tr>
        <tr>
            <td>权限：</td>
            <td><input name="rules[]"></td>
        </tr>
        <tr>
            <td>是否启用：</td>
            <td><input name="status" checked></td>
        </tr>
        </tbody>
    </table>
<?php else: ?>
    <table style="width:100%; padding:20px 35px;">
        <tbody>
        <tr>
            <td width="30%">角色名：</td>
            <td width="70%"><input name="title" type="text" value="<?php echo ($data["title"]); ?>"></td>
        </tr>
        <tr>
            <td>描述：</td>
            <td><input name="description" type="text" value="<?php echo ($data["description"]); ?>"></td>
        </tr>
        <tr>
            <td>权限：</td>
            <td><input name="rules[]" value="<?php echo ($data["rules"]); ?>"></td>
        </tr>
        <tr>
            <td>是否启用：</td>
            <td><input name="status" <?php if(($data["status"]) == "1"): ?>checked<?php endif; ?>></td>
        </tr>
        <input name="id" type="hidden" value="<?php echo ($data["id"]); ?>">
        </tbody>
    </table><?php endif; ?>
</div>

<script type="text/javascript">
    $('#userrole-form-id input[name="description"]').textbox({
        width : '100%',
        multiline : true
    });

    $('#userrole-form-id input[name="title"]').textbox({
        width : '100%',
        validType:['length[1,100]'],
        required : true
    });
    $('#userrole-form-id input[name="rules[]"]').combotree({
        width : '100%',
        url : '../Rule/getRuleTree',
        panelHeight : 300,
        lines : true,
        multiple : true,
        required : true
    });
    $('#userrole-form-id input[name="status"]').switchbutton({
        onText: '是',
        offText: '否'
    });
</script>