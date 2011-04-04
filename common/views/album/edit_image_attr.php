<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<br/>
<div id="edit_image_msg" style="display:none"><?php _e('Changes have been made, click the arrow in the top right corner of the modal box to close.', 'photoxhibit'); ?></div>
<input type="hidden" id="px_imageEdit_id" value="<?php echo $this->cur_image_info->albumPhotos_id;?>"/>
<table width="400" border="0" cellspacing="0" cellpadding="3" style="margin: 0pt auto; width: 400px;">
	<tr>
		<td align="left" valign="top"><?php _e('Image Alt / Title', 'photoxhibit'); ?> </td>
		<td align="left" valign="top"><input type="text" id="albumPhotos_alt" name="albumPhotos_alt" value="<?php echo $this->cur_image_info->albumPhotos_alt;?>"></td>
	</tr>
	<tr>
		<td align="left" valign="top"><?php _e('Image Tags', 'photoxhibit'); ?> </td>
		<td align="left" valign="top"><input type="text" id="albumPhotos_tags" name="albumPhotos_tags" value="<?php echo $this->cur_image_info->albumPhotos_tags;?>"> 
			<?php _e('seperate with commas', 'photoxhibit'); ?> </td>
	</tr>
	<tr>
		<td align="left" valign="top"><?php _e('Is active?', 'photoxhibit'); ?> </td>
		<td align="left" valign="top"><label>
			<input name="albumPhotos_isactive" type="radio" value="1" <?php if($this->cur_image_info->albumPhotos_isactive == 1){echo ' checked="checked" ';};?>>
		<?php _e('Yes', 'photoxhibit'); ?>
		</label>
		<label>
		<input name="albumPhotos_isactive" type="radio" value="0" <?php if($this->cur_image_info->albumPhotos_isactive == 0){echo ' checked="checked" ';};?>>
		<?php _e('No', 'photoxhibit'); ?></label></td>
	</tr>
	<tr>
		<td align="left" valign="top"><?php _e('Description', 'photoxhibit'); ?>:</td>
		<td align="left" valign="top">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" align="left" valign="top"><textarea style="width:394px;height:100px" id="albumPhotos_desc" name="albumPhotos_desc"><?php echo $this->cur_image_info->albumPhotos_desc;?></textarea></td>
	</tr>
</table>
<p class="submit" style="margin: 0pt auto; width: 400px;">
<input id="px_editImageSubmit" type="submit" value="<?php _e('Submit Changes', 'photoxhibit'); ?>" name="px_editImageSubmit"/>
</p><br/>
<br/>
