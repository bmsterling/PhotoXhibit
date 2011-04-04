<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<div class="wrap">
	<fieldset class="options px_content" style="margin:0 auto;">
		<legend><?php _e('Structure', 'photoxhibit'); ?></legend>
		<table width="100%" cellpadding="3" cellspacing="3" border="0">
			<tr>
				<td colspan="2">
					<?php _e('Below you will find a list of possible stuctures, these structures are unstyled and will be what people will see if javascript is turned off.', 'photoxhibit'); ?>				</td>
			</tr>
			<tr>
				<td valign="top"><input type="radio" value="0" name="px_structure" <?php if($this->cur_gallery_info->gallery_structure == 0 || !isset($this->cur_gallery_info->gallery_structure)) echo 'checked="checked"';?> /> <?php _e('List Structure', 'photoxhibit'); ?></td>
				<td width="170"><img src="<?php echo $this->options['img'];?>icon_li.png"/></td>
			</tr>
			<tr>
				<td valign="top"><input type="radio" value="1" name="px_structure" <?php if($this->cur_gallery_info->gallery_structure == 1) echo 'checked="checked"';?> /> 
					<?php _e('Table Structure (image over associated text)  ', 'photoxhibit'); ?>
						<input type="text" size="1" value="<?php echo ($this->cur_gallery_info->gallery_structure == 1)? $this->cur_gallery_info->gallery_extra : '5';?>" name="px_structure_tableVar1"/></td>
				<td width="170"><img src="<?php echo $this->options['img'];?>icon_table.png"/></td>
			</tr>
			<tr>
				<td valign="top"><input type="radio" value="2" name="px_structure" <?php if($this->cur_gallery_info->gallery_structure == 2) echo 'checked="checked"';?> /> <?php _e('Table Structure (no text)', 'photoxhibit'); ?>
				<input type="text" size="1" value="<?php echo ($this->cur_gallery_info->gallery_structure == 2)? $this->cur_gallery_info->gallery_extra : '5';?>" name="px_structure_tableVar2"/></td>
				<td width="170"><img src="<?php echo $this->options['img'];?>icon_tableno.png"/></td>
			</tr>
			<tr>
				<td valign="top"><input type="radio" value="3" name="px_structure" <?php if($this->cur_gallery_info->gallery_structure == 3) echo 'checked="checked"';?> /> <?php _e('Div Structure (image over associated text)', 'photoxhibit'); ?></td>
				<td width="170"><!--<img src="<?php echo $this->options['img'];?>icon_div.png"/>--></td>
			</tr>
			<tr>
				<td valign="top"><input type="radio" value="4" name="px_structure" <?php if($this->cur_gallery_info->gallery_structure == 4) echo 'checked="checked"';?> /> <?php _e('Div Structure (no text)', 'photoxhibit'); ?></td>
				<td width="170"><!--<img src="<?php echo $this->options['img'];?>icon_divno.png"/>--></td>
			</tr>
	</table>
	</fieldset>
</div>