<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<h2><?php _e('SmugMug Params', 'photoxhibit'); ?></h2>
<table width="100%" cellpadding="3" cellspacing="3" border="0">
<!--
	<tr>
		<td width="18%">SmugMug api key</td>
		<td width="235"><input type="text" size="30" value="<?php echo $this->vars['smugmug_api_key'];?>" name="smugmug_api_key" id="smugmug_api_key"/></td>
		<td>Get your <a href="http://www.smugmug.com/hack/apikeys" target="_blank">SmugMug API Key</a>.  You can enter multiple api keys but they must be separated by a comma and the api key must match up with the userid(s) below.</td>
	</tr>
-->
	
	<tr>
		<td width="18%"><?php _e('SmugMug Userid', 'photoxhibit'); ?></td>
		<td width="235"><input type="text" size="30" value="<?php echo $this->vars['smugmug_user_id'];?>" name="smugmug_user_id" id="smugmug_user_id"/></td>
		<td><?php _e('The userid for the SmugMug account you want to pull from; you can enter multiple USERIDes but they must be separated by a comma. (eg: userid#1, userid#2)', 'photoxhibit'); ?></td>
	</tr>
</table>