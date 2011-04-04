<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<a href="#goBack" name="px_buildSmugMugOptions" class="goBack">&laquo; Go back one step</a>
<fieldset class="options">
	<legend>SmugMug API KEY</legend>
	<table width="100%" cellpadding="3" cellspacing="3" border="0">
		<tr>
			<td width="18%">SmugMug API Key</td>
			<td width="235"><input type="text" size="30" value="" name="smugmug_api_key" id="smugmug_api_key"/></td>
			<td></td>
		</tr>
		<tr>
			<td width="18%">SmugMug Stored API Keys</td>
			<td width="235">
				<select name="smugmug_api_key_dd" id="smugmug_api_key_dd">
	<?php if(isset($this->vars['smugmug_api_key'])):?>
					<option selected="selected"></option>
	<?php 
	$smugmug_api_key = explode(',', $this->vars['smugmug_api_key']);
	while(list($key,$value) = each($smugmug_api_key)){?>
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
		<input type="submit" name="px_goNext" title="px_buildSmugMugAdvance" value="<?php _e('Next &raquo;'); ?>" />
	</p>
</fieldset>
<a href="#goBack" name="px_buildSmugMugOptions" class="goBack">&laquo; Go back one step</a>