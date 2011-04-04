<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<h2><?php _e('Options Overview', 'photoxhibit'); ?></h2>
<table width="100%" cellpadding="3" cellspacing="3" border="0">
	<tr>
		<td width="18%" valign="top"><?php _e('Check the services you want to use:', 'photoxhibit'); ?></td>
		<td width="235">
			<ul>
				<li>
					<?php _e('Use Picasa', 'photoxhibit'); ?>:  <?php _e('yes', 'photoxhibit'); ?> 
					<input type="radio" value="1" name="use_picasa" <?php echo ($this->vars['use_picasa']==1)?' checked="checked" ':'';?>/>
					 | <?php _e('no', 'photoxhibit'); ?> <input type="radio" value="0" name="use_picasa"  <?php echo ($this->vars['use_picasa']==0)?' checked="checked" ':'';?>/>
				</li>
				<li>
					<?php _e('Use Flickr', 'photoxhibit'); ?>:  <?php _e('yes', 'photoxhibit'); ?> 
					<input type="radio" value="1" name="use_flickr" <?php echo ($this->vars['use_flickr']==1)?' checked="checked" ':'';?>/>
					 | <?php _e('no', 'photoxhibit'); ?> <input type="radio" value="0" name="use_flickr"  <?php echo ($this->vars['use_flickr']==0)?' checked="checked" ':'';?>/>
				</li>
				<li>
					<?php _e('Use SmugMug', 'photoxhibit'); ?>:  <?php _e('yes', 'photoxhibit'); ?> 
					<input type="radio" value="1" name="use_smugmug" <?php echo ($this->vars['use_smugmug']==1)?' checked="checked" ':'';?>/>
					 | <?php _e('no', 'photoxhibit'); ?> <input type="radio" value="0" name="use_smugmug"  <?php echo ($this->vars['use_smugmug']==0)?' checked="checked" ':'';?>/>
				</li>
				<li>
					<?php _e('Use Album', 'photoxhibit'); ?>:  <?php _e('yes', 'photoxhibit'); ?> 
					<input type="radio" value="1" name="use_album" <?php echo ($this->vars['use_album']==1)?' checked="checked" ':'';?>/>
					 | <?php _e('no', 'photoxhibit'); ?> <input type="radio" value="0" name="use_album"  <?php echo ($this->vars['use_album']==0)?' checked="checked" ':'';?>/>
				</li>
				<li>
					<?php _e('Use Local', 'photoxhibit'); ?>:  <?php _e('yes', 'photoxhibit'); ?> 
					<input type="radio" value="1" name="use_local" <?php echo ($this->vars['use_local']==1)?' checked="checked" ':'';?>/>
					 | <?php _e('no', 'photoxhibit'); ?> <input type="radio" value="0" name="use_local"  <?php echo ($this->vars['use_local']==0)?' checked="checked" ':'';?>/>
				</li>
				<!--<li>
					<?php _e('Use Browse', 'photoxhibit'); ?>:  <?php _e('yes', 'photoxhibit'); ?>
					<input type="radio" value="1" name="use_browse" <?php echo ($this->vars['use_browse']==1)?' checked="checked" ':'';?>/>
					 | <?php _e('no', 'photoxhibit'); ?> <input type="radio" value="0" name="use_browse"  <?php echo ($this->vars['use_browse']==0)?' checked="checked" ':'';?>/>
					 <em><?php _e('Note: This option needs to be reworked.  I am keeping this option here to force myself to get it working correctly', 'photoxhibit'); ?></em>
				</li>-->
			</ul>
		</td>
	</tr>
</table>