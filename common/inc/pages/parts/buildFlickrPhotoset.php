<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<a href="#goBack" name="px_buildFlickrOptions" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>
<fieldset class="options">
	<legend><?php _e('Flickr Photoset', 'photoxhibit'); ?></legend>
<table width="100%" cellpadding="3" cellspacing="3" border="0">
	<tr>
		<td width="18%"><?php _e('Flickr Photoset ID', 'photoxhibit'); ?></td>
		<td width="235"><input type="text" size="30" value="" name="flickr_photoset_id" id="flickr_photoset_id"/></td>
		<td><?php _e('The photoset id for the Flickr set you want to pull from; if you provided one under "Flickr Params" then just select from the below dropdown', 'photoxhibit'); ?></td>
	</tr>
	<tr>
		<td width="18%"><?php _e('Flickr Stored Photoset ID', 'photoxhibit'); ?></td>
		<td width="235">
			<select name="flickr_photoset_id_dd" id="flickr_photoset_id_dd">
<?php if(isset($this->vars['flickr_photoset_id'])):?>
				<option selected="selected"></option>
<?php
	$flickr_photoset_id = explode(',', $this->vars['flickr_photoset_id']); 
	while(list($key,$value) = each($flickr_photoset_id)){?>
				<option value="<?php echo trim($value);?>"><?php echo trim($value);?></option>
<?php }?>
<?php else:?>
				<option selected="selected"><?php _e('No Photoset ID stored', 'photoxhibit'); ?></option>
<?php endif;?>
			</select>
		</td>
		<td></td>
	</tr>
</table>
	<p class="submit">
		<input type="submit" name="px_goNext" title="px_buildFlickrThumbnails" class="px_flickrPSApi" value="<?php _e('Next &raquo;', 'photoxhibit'); ?>" />
	</p>
</fieldset>
<a href="#goBack" name="px_buildFlickrOptions" class="goBack">&laquo; <?php _e('Go back one step', 'photoxhibit'); ?></a>