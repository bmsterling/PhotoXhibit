<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<a href="#goBack" name="px_services" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<fieldset class="options">
	<legend><?php _e('SmugMug Advanced', 'photoxhibit'); ?></legend>
	<table width="100%" cellpadding="3" cellspacing="3" border="0">
		<tr>
			<td width="18%"><?php _e('SmugMug User ID', 'photoxhibit'); ?></td>
			<td width="235"><input type="text" size="30" value="" name="smugmug_user_id" id="smugmug_user_id"/></td>
			<td><?php _e('if you provided one under "SmugMug Params" then just select from the below dropdown.', 'photoxhibit'); ?></td>
		</tr>
		<tr>
			<td width="18%"><?php _e('SmugMug Stored User ID', 'photoxhibit'); ?></td>
			<td width="235">
				<select name="smugmug_user_id_dd" id="smugmug_user_id_dd">
	<?php if(isset($this->vars['smugmug_user_id'])):?>
					<option selected="selected"></option>
	<?php 
	$smugmug_user_id = explode(',', $this->vars['smugmug_user_id']);
	while(list($key,$value) = each($smugmug_user_id)){?>
					<option value="<?php echo trim($value);?>"><?php echo trim($value);?></option>
	<?php }?>
	<?php else:?>
					<option selected="selected"><?php _e('No User IDs stored', 'photoxhibit'); ?></option>
	<?php endif;?>
				</select>
			</td>
			<td></td>
		</tr>
		<tr>
			<td width="18%"><?php _e('SmugMug Album ID', 'photoxhibit'); ?></td>
			<td width="235"><input type="text" size="30" value="" name="smugmug_album_id" id="smugmug_album_id"/></td>
			<td></td>
		</tr>
		<tr>
			<td width="18%" class="submit"><input type="submit" value="Grab" id="px_smugmugAlbum_grab"/></td>
			<td width="235">
				<select name="smugmug_album_id_dd" id="smugmug_album_id_dd">
					<option selected="selected"></option>
				</select>
			</td>
			<td id="px_smugmugAlbum_grab_notice"></td>
		</tr>
	</table>
	<p class="submit">
		<input type="submit" name="px_goNext" title="px_buildSmugMugThumbnails" class="px_buildSmugMugAdvance" value="<?php _e('Next &raquo;', 'photoxhibit'); ?>" />
	</p>
</fieldset>
<a href="#goBack" name="px_services" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>