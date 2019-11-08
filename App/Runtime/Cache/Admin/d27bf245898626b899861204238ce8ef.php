<?php if (!defined('THINK_PATH')) exit();?><div id="system-menu-form-id">
<?php if(empty($data)): ?><table width="100%" style="padding:20px 35px;">
    <tbody>
    <tr>
        <td style="width:30%">上级菜单：</td>
        <td style="width:70%"><input name="nid" value="1"></td>
    </tr>
    <tr>
        <td>菜单名称：</td>
        <td><input name="text" type="text"></td>
    </tr>
    <tr>
        <td>菜单图标：</td>
        <td><input name="icon" type="text" value="icon-folder"></td>
    </tr>
    <tr>
        <td>URL：</td>
        <td><input name="url" type="text"></td>
    </tr>
    <tr>
        <td>权限规则：</td>
        <td><input name="authrule" type="text"></td>
    </tr>
    <tr>
        <td>排序：</td>
        <td><input name="myorder" type="text" value="0"></td>
    </tr>
    <tr>
        <td>是否隐藏：</td>
        <td><input name="hide" type="text" value="0"></td>
    </tr>

    </tbody>
</table>
<?php else: ?>
<table width="100%" style="padding:20px 35px;">
    <tbody>
    <tr>
        <td style="width:30%">上级菜单：</td>
        <td style="width:70%"><input name="nid" value="<?php echo ($data["nid"]); ?>"></td>
    </tr>
    <tr>
        <td width="100">菜单名称：</td>
        <td><input name="text" type="text" value="<?php echo ($data["text"]); ?>"></td>
    </tr>
    <tr>
        <td width="100">菜单图标：</td>
        <td><input name="icon" type="text" value="<?php echo ($data["icon"]); ?>"></td>
    </tr>
    <tr>
        <td>URL：</td>
        <td><input name="url" type="text" value="<?php echo ($data["url"]); ?>"></td>
    </tr>
    <tr>
        <td>权限规则：</td>
        <td><input name="authrule" type="text" value="<?php echo ($data["authrule"]); ?>"></td>
    </tr>
    <tr>
        <td>排序：</td>
        <td><input name="myorder" type="text" value="<?php echo ($data["myorder"]); ?>"></td>
    </tr>
    <tr>
        <td>是否隐藏：</td>
        <td><input name="hide" <?php if(($data["hide"]) == "1"): ?>checked<?php endif; ?>></td>
    </tr>
    <input name="id" type="hidden" value="<?php echo ($data["id"]); ?>">
    </tbody>
</table><?php endif; ?>
</div>

<script>
    $('#system-menu-form-id input[name="text"]').textbox({
        width : '100%',
        iconCls : 'icon-text_allcaps',
        required : true
    });
    $('#system-menu-form-id input[name="url"]').textbox({
        width : '100%',
        iconCls : 'icon-link'
    });
    $('#system-menu-form-id input[name="authrule"]').textbox({
        width : '100%',
        iconCls : 'icon-key',
        required : true,
        missingMessage : '配合权限校验匹配的规则，如果不填写此节点将无法通过校验！'

    });
    $('#system-menu-form-id input[name="myorder"]').numberbox({
        width : '100%',
        min:0,
        precision:0
    });
    $('#system-menu-form-id input[name="nid"]').combotree({
        width: '100%',
        url : '../Index/getMenuTree?root=0',
        required : true
    });
    $('#system-menu-form-id input[name="icon"]').combotree({
        width: '100%',
        url : '../Index/getIconList'
    });
    $('#system-menu-form-id input[name="hide"]').switchbutton({
        onText: '是',
        offText: '否',
        value : 1
    });
</script>