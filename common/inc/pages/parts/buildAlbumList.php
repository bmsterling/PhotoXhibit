<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<a href="#goBack" name="px_services" class="goBack">&laquo; Go back one step</a>
<fieldset class="options">
	<legend><?php _e('Album Select', 'photoxhibit'); ?></legend>
	<p>
		<select name="px_album_list_sm" id="px_album_list_sm">
			<option value="0">-: <?php _e('Select One', 'photoxhibit'); ?> :-</option>
<?php 
	while(list($key,$value) = each($this->album_list)){?>
				<option value="<?php echo trim($value->album_id);?>" meta="<?php echo get_bloginfo('wpurl').'/'.$this->vars["options_path"].'/'.sanitize_title($value->album_name);?>"><?php echo trim($value->album_name);?></option>
<?php }?>

		</select>
	</p>
	<p class="submit">
		<input type="submit" name="px_goNext" title="px_buildAlbumThumbnails" class="px_buildAlbumList" value="<?php _e('Next &raquo;'); ?>" />
	</p>
</fieldset>
</fieldset>
<a href="#goBack" name="px_services" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>