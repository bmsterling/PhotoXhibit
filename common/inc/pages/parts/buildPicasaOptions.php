<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<!-- start: Picasa basic -->
<a href="#goBack" name="px_services" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<fieldset class="options">
	<legend><?php _e('Picasa Options', 'photoxhibit'); ?></legend>
	<table width="100%" cellpadding="3" cellspacing="3" border="0">
		<tr class="">
			<td width="18%"><?php _e('What Options?', 'photoxhibit'); ?></td>
			<td width="235">
				<select name="px_picasaOptionsDD" id="px_picasaOptionsDD">
					<option selected="selected"></option>
					<option value="px_picasaBasic"><?php _e('Basic', 'photoxhibit'); ?></option>
					<option value="px_picasaAdvance"><?php _e('Advanced', 'photoxhibit'); ?></option>
				</select>
			</td>
			<td>
				<?php _e('Select the set of Picasa options you would like to work with', 'photoxhibit'); ?>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<ul>
					<li><?php _e('Basic: This option will will allow you to just supply the RSS feed url for a Picasa album', 'photoxhibit'); ?></li>
					<li><?php _e('Advanced: This option will accept your picasa username and will allow you to grab a list of albums to pull photos from', 'photoxhibit'); ?></li>
				</ul>
			</td>
		</tr>
	</table>
	<p class="submit">
		<input type="submit" name="px_goNext" title="px_picasaOpt" value="<?php _e('Next &raquo;', 'photoxhibit'); ?>" />
	</p>
</fieldset>
<a href="#goBack" name="px_services" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<!-- end: Picasa basic -->