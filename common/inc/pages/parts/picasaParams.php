<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<h2><?php _e('Picasa Params', 'photoxhibit'); ?></h2>
<table width="100%" cellpadding="3" cellspacing="3" border="0">
	<tr>
		<td width="18%"><?php _e('Picasa Userid', 'photoxhibit'); ?></td>
		<td width="235"><input type="text" size="30" value="<?php echo $this->vars['picasa_user_id'];?>" name="picasa_user_id" id="picasa_user_id"/></td>
		<td><?php _e('The userid for the Picasa account you want to pull from; you can enter multiple USERIDes but they must be separated by a comma. (eg: userid#1, userid#2)', 'photoxhibit'); ?></td>
	</tr>
</table>