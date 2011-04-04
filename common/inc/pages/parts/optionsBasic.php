<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<h2><?php _e('Options Overview', 'photoxhibit'); ?></h2>
<table width="100%" cellpadding="3" cellspacing="3" border="0">
	<tr>
		<td width="18%" valign="top"><?php _e('Effects that can be turned off:', 'photoxhibit'); ?></td>
		<td width="235">
			<ul>
				<li>
					<?php _e('Use Slide Effect on "Select services"', 'photoxhibit'); ?>:  

					<?php _e('yes', 'photoxhibit'); ?> 
					<input type="radio" value="1" name="use_effectSlide" <?php echo ($this->vars['use_effectSlide']==1)?' checked="checked" ':'';?>/>
					 | 
					 <?php _e('no', 'photoxhibit'); ?> 
					 <input type="radio" value="0" name="use_effectSlide"  <?php echo ($this->vars['use_effectSlide']==0)?' checked="checked" ':'';?>/>
				</li>
				<li>
					<?php _e('Show PhotoXhibit Manager on the write/edit pages for photo insertion', 'photoxhibit'); ?>:  

					<?php _e('yes', 'photoxhibit'); ?> 
					<input type="radio" value="1" name="use_manager" <?php echo ($this->vars['use_manager']==1)?' checked="checked" ':'';?>/>
					 | 
					 <?php _e('no', 'photoxhibit'); ?> 
					 <input type="radio" value="0" name="use_manager"  <?php echo ($this->vars['use_manager']==0)?' checked="checked" ':'';?>/>
				</li>
				<li>
					<?php _e('If you are having issues with the Album photo uploader, ie. 403 errors, or you don\'t have Flash 9 installed, set this to no', 'photoxhibit'); ?>:  

					<?php _e('yes', 'photoxhibit'); ?> 
					<input type="radio" value="1" name="flash_version_multi_upload" <?php echo ($this->vars['flash_version_multi_upload']==1)?' checked="checked" ':'';?>/>
					 | 
					 <?php _e('no', 'photoxhibit'); ?> 
					 <input type="radio" value="0" name="flash_version_multi_upload"  <?php echo ($this->vars['flash_version_multi_upload']==0)?' checked="checked" ':'';?>/>
				</li>
				<li>
					<?php _e('If you are having issues with the Styles not updating when trying to edit styles, set this to no', 'photoxhibit'); ?>:  

					<?php _e('yes', 'photoxhibit'); ?> 
					<input type="radio" value="1" name="none_ajax_styles" <?php echo ($this->vars['none_ajax_styles']==1)?' checked="checked" ':'';?>/>
					 | 
					 <?php _e('no', 'photoxhibit'); ?> 
					 <input type="radio" value="0" name="none_ajax_styles"  <?php echo ($this->vars['none_ajax_styles']==0)?' checked="checked" ':'';?>/>
				</li>
			</ul>
		</td>
	</tr>
</table>