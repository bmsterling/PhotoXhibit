<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<!-- start: Picasa basic -->
<a href="#goBack" name="px_services" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<fieldset class="options">
	<legend><?php _e('SmugMug Options', 'photoxhibit'); ?></legend>
	<table width="100%" cellpadding="3" cellspacing="3" border="0">
		<tr class="">
			<td width="18%"><?php _e('What Options?', 'photoxhibit'); ?></td>
			<td width="235">
				<select name="px_smugMugOptionsDD" id="px_smugMugOptionsDD">
					<option selected="selected"></option>
					<!--<option value="px_buildSmugMugBasic"><?php _e('Basic', 'photoxhibit'); ?></option>-->
					<option value="px_buildSmugMugAdvance"><?php _e('Advanced', 'photoxhibit'); ?></option>
				</select>
			</td>
			<td>
				<?php _e('Select the set of  SmugMug options you would like to work with', 'photoxhibit'); ?>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<?php _e('For SmugMug you have two options:', 'photoxhibit'); ?>
				<ol>

					<!--<li>Basic will bring you to a frame that you can enter your SmugMug RSS feed into.  At this time, it has to be a SmugMug url.</li>-->

					<li><?php _e('Advance will bring you to a screen where you will need to enter your API key and then you will be able to select albums based on your username', 'photoxhibit'); ?></li>
				</ol>
			</td>
		</tr>
	</table>
	<p class="submit">
		<input type="submit" name="px_goNext" title="px_smugMugOpt" value="<?php _e('Next &raquo;', 'photoxhibit'); ?>" />
	</p>
</fieldset>
<a href="#goBack" name="px_services" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<!-- end: Picasa basic -->