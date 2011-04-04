<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<a href="#goBack" name="px_services" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<fieldset class="options">
	<legend><?php _e('Local Call', 'photoxhibit'); ?></legend>
	<p><?php _e('This option will get all the images that were inserted into the database via the basic wordpress upload.', 'photoxhibit'); ?></p>
	<p class="submit">
		<input type="submit" name="px_getPhotos" class="px_getPhotos" value="<?php _e('Get Photos', 'photoxhibit'); ?>" />
	</p>
</fieldset>
<a href="#goBack" name="px_services" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>