<?php
/* Smarty version 3.1.30, created on 2016-12-15 15:11:05
  from "D:\PHP\wamp\www\php2\template\test.html" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_5852a4797a2f50_84474316',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f355142d709bd99efde4a644bb40873055f025c2' => 
    array (
      0 => 'D:\\PHP\\wamp\\www\\php2\\template\\test.html',
      1 => 1481810974,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5852a4797a2f50_84474316 (Smarty_Internal_Template $_smarty_tpl) {
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>无标题文档</title>
</head>

<body>



<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['newsArray']->value, 'newArr');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['newArr']->value) {
?> 
<?php echo $_smarty_tpl->tpl_vars['contnet']->value;?>

新闻编号：<?php echo $_smarty_tpl->tpl_vars['newArr']->value['newsID'];?>
 
新闻标题：<?php echo $_smarty_tpl->tpl_vars['newArr']->value['newsTitle'];?>
 
<?php
}
} else {
?>

 对不起，没有任何新闻
 输入! <?php
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl);
?>

</body>
</html>
<?php }
}
