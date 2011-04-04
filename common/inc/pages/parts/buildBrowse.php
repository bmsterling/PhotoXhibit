<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<!-- start: browse basic -->
<a href="#goBack" name="px_services" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<fieldset class="options">
	<legend><?php _e('Browse', 'photoxhibit'); ?></legend>
	<table width="100%" cellpadding="3" cellspacing="3" border="0">
		<tr>
			<td width="18%"><?php _e('Your browsable directory URL', 'photoxhibit'); ?></td>
			<td width="235"><input type="text" size="30" value="<?php echo $_SERVER['DOCUMENT_ROOT'];?>/wp-content/uploads/" name="browseBasic_url" id="browseBasic_url"/></td>
			<td><?php _e('Input the URL for the "browsable" directory, default:', 'photoxhibit'); ?> /wp-content/uploads/</td>					
		</tr>
		<!--
		<tr>
			<td width="18%"><?php _e('Your thumbnail prefix', 'photoxhibit'); ?></td>
			<td width="235"><input type="text" size="30" value=".thumbnail" name="browseBasic_prefix" id="browseBasic_prefix"/></td>
			<td><?php _e('default:', 'photoxhibit'); ?> .thumbnail</td>					
		</tr>
		-->
	</table>
</fieldset>
	<p class="submit">
		<input type="submit" name="px_getPhotos" class="px_getPhotos" value="<?php _e('Get Photos', 'photoxhibit'); ?>" />
	</p>
<a href="#goBack" name="px_services" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<!-- end: browse basic -->