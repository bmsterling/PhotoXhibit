<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<a href="#goBack" name="px_buildFlickrOptions" class="goBack px_flickrApi">&laquo; Go back one step</a>
<fieldset class="options">
	<legend>Flickr API KEY</legend>
	<table width="100%" cellpadding="3" cellspacing="3" border="0">
		<tr>
			<td width="18%">Flickr API Key</td>
			<td width="235"><input type="text" size="30" value="" name="flickr_api_key" id="flickr_api_key"/></td>
			<td>Get your <a href="http://www.flickr.com/services/api/keys/apply/" target="_blank">Flickr Services API Key</a>; if you provided one under "Flickr Params" then just select from the below dropdown.</td>
		</tr>
		<tr>
			<td width="18%">Flickr Stored API Keys</td>
			<td width="235">
				<select name="flickr_api_key_dd" id="flickr_api_key_dd">
	<?php if(isset($this->vars['flickr_api_key'])):?>
					<option selected="selected"></option>
	<?php 
	$flickr_api_key = explode(',', $this->vars['flickr_api_key']);
	while(list($key,$value) = each($flickr_api_key)){?>
					<option value="<?php echo trim($value);?>"><?php echo trim($value);?></option>
	<?php }?>
	<?php else:?>
					<option selected="selected">No API Keys stored</option>
	<?php endif;?>
				</select>
			</td>
			<td></td>
		</tr>
	</table>
	<p class="submit">
		<input type="submit" name="px_goNext" title="px_buildFlickrThumbnails" class="px_flickrApiToTn" value="<?php _e('Next &raquo;'); ?>" />
	</p>
</fieldset>
<a href="#goBack" name="px_buildFlickrOptions" class="goBack px_flickrApi">&laquo; Go back one step</a>