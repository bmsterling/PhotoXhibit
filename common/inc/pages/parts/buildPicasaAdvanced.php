<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<a href="#goBack" name="px_picasaOptions" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<fieldset class="options">
	<legend><?php _e('Picasa Advanced', 'photoxhibit'); ?></legend>
	<table width="100%" cellpadding="3" cellspacing="3" border="0">
		<tr>
			<td width="18%"><?php _e('Picasa User ID', 'photoxhibit'); ?></td>
			<td width="235"><input type="text" size="30" value="" name="picasa_user_id" id="picasa_user_id"/></td>
			<td><?php _e('if you provided one under "Picasa Params" then just select from the below dropdown.', 'photoxhibit'); ?></td>
		</tr>
		<tr>
			<td width="18%"><?php _e('Picasa Stored User ID', 'photoxhibit'); ?></td>
			<td width="235">
				<select name="picasa_user_id_dd" id="picasa_user_id_dd">
	<?php if(isset($this->vars['picasa_user_id'])):?>
					<option selected="selected"></option>
	<?php 
	$picasa_user_id = explode(',', $this->vars['picasa_user_id']);
	while(list($key,$value) = each($picasa_user_id)){?>
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
			<td width="18%"><?php _e('Picasa Album ID', 'photoxhibit'); ?></td>
			<td width="235"><input type="text" size="30" value="" name="picasa_album_id" id="picasa_album_id"/></td>
			<td><?php _e('You have three options here, you can enter the album name that comes after the user id in the url of your album (eg. /myid/ThisIsAAlbum == ThisIsAAlbum) or you can enter the number id that you can get from the rss feed itself, or you can hit "grab" just below and grab what you need from the dropdown.', 'photoxhibit'); ?></td>
		</tr>
		<tr>
			<td width="18%" class="submit"><input type="submit" value="grab" id="bsg_picasa_grab"/></td>
			<td width="235">
				<select name="picasa_album_id_dd" id="picasa_album_id_dd">
					<option selected="selected"></option>
				</select>
			</td>
			<td id="bsg_picasa_grab_notice"></td>
		</tr>
	</table>
	<p class="submit">
		<input type="submit" name="px_goNext" title="px_picasaThumbnails" class="px_pxOptAdv" value="<?php _e('Next &raquo;', 'photoxhibit'); ?>" />
	</p>
</fieldset>
<a href="#goBack" name="px_picasaOptions" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>