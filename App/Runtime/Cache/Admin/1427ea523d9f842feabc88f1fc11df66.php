<?php if (!defined('THINK_PATH')) exit();?><div id="form-id">
<?php if(empty($data)): ?><table style="width:100%; padding:20px 35px;">
        <tbody>
        <tr>
            <td width="20%">上级规则：</td>
            <td width="80%"><input name="pid" value="1"></td>
        </tr>
        <tr>
            <td>规则类型：</td>
            <td><input name="type" value="1"></td>
        </tr>
        <tr>
            <td>规则名称：</td>
            <td><input name="title" type="text"></td>
        </tr>
        <tr>
            <td>模块名称：</td>
            <td><input name="module" type="text"></td>
        </tr>
        <tr>
            <td>规则URL：</td>
            <td><input name="name" type="text"></td>
        </tr>
        <tr>
            <td>附加条件：</td>
            <td><input name="condition" type="text"></td>
        </tr>
        <tr>
            <td>是否启用：</td>
            <td><input name="status" checked></td>
        </tr>
        <tr>
            <td>规则描述：</td>
            <td><input name="description" type="text"></td>
        </tr>
        </tbody>
    </table>
<?php else: ?>
    <table style="width:100%; padding:20px 35px;">
        <tbody>
        <tr>
            <td width="20%">上级规则：</td>
            <td width="80%"><input name="pid" value="<?php echo ($data["pid"]); ?>"></td>
        </tr>
        <tr>
            <td>规则类型：</td>
            <td><input name="type" value="<?php echo ($data["type"]); ?>"></td>
        </tr>
        <tr>
            <td>规则名称：</td>
            <td><input name="title" type="text" value="<?php echo ($data["title"]); ?>"></td>
        </tr>
        <tr>
            <td>模块名称：</td>
            <td><input name="module" type="text" value="<?php echo ($data["module"]); ?>"></td>
        </tr>
        <tr>
            <td>规则URL：</td>
            <td><input name="name" type="text" value="<?php echo ($data["name"]); ?>"></td>
        </tr>
        <tr>
            <td>附加条件：</td>
            <td><input name="condition" type="text" value="<?php echo ($data["condition"]); ?>"></td>
        </tr>
        <tr>
            <td>是否启用：</td>
            <td><input name="status" <?php if(($data["status"]) == "1"): ?>checked<?php endif; ?>></td>
        </tr>
        <tr>
            <td>规则描述：</td>
            <td><input name="description" type="text" value="<?php echo ($data["description"]); ?>"></td>
        </tr>
        <input name="id" type="hidden" value="<?php echo ($data["id"]); ?>">
        </tbody>
    </table><?php endif; ?>
</div>

<script type="text/javascript">
    $('#form-id input[name="pid"]').combotree({
        width: '100%',
        url : './getRuleTree',
        required : true
    });
    $('#form-id input[name="type"]').combobox({
        width: '100%',
        valueField : 'value',
        textField  : 'label',
        data : [{
            label : 'URL',
            value : 1
        },{
            label : '菜单',
            value : 2
        }]
    });
    $('#form-id input[name="title"]').textbox({
        width : '100%',
        validType:['length[1,20]'],
        required : true
    });
    $('#form-id input[name="module"]').textbox({
        width : '100%',
        validType:['length[1,20]']
    });
    $('#form-id input[name="name"]').textbox({
        width : '100%',
        validType:['length[0,80]']
    });
    $('#form-id input[name="condition"]').textbox({
        width : '100%',
        validType:['length[0,300]']
    });
    $('#form-id input[name="status"]').switchbutton({
        onText: '是',
        offText: '否'
    });
    $('#form-id input[name="description"]').textbox({
        width : '100%',
        multiline : true,
        validType:['length[0,255]']
    });
</script>