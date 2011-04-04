<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<h2><?php _e('Flickr Params', 'photoxhibit'); ?></h2>
<table width="100%" cellpadding="3" cellspacing="3" border="0">
	<tr>
		<td width="18%"><?php _e('Flickr Userid', 'photoxhibit'); ?></td>
		<td width="235"><input type="text" size="30" value="<?php echo $this->vars['flickr_user_id'];?>" name="flickr_user_id" id="flickr_user_id"/></td>
		<td><?php _e('The userid for the Flickr account you want to pull from; you can enter multiple USERIDes but they must be separated by a comma. (eg: userid#1, userid#2)  You must obtain an API if you want to pull via user id.', 'photoxhibit'); ?></td>
	</tr>
	<tr>
		<td width="18%"><?php _e('Photoset ID', 'photoxhibit'); ?></td>
		<td width="235"><input type="text" size="30" value="<?php echo $this->vars['flickr_photoset_id'];?>" name="flickr_photoset_id" id="flickr_photoset_id"/></td>
		<td><?php _e('If there are certain sets you want to pull from mutliple times, post those ids here separated by a comma.    You must obtain an API if you want to pull via photoset id.', 'photoxhibit'); ?></td>
	</tr>			
</table>