<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<div class="overViewLeft">
	<h2><?php _e('PhotoXhibit Overview', 'photoxhibit'); ?> v<?php echo $this->version;?></h2>
	<h3><?php _e('Welcome to PhotoXhibit Administator Overview', 'photoxhibit'); ?></h3>
	<p><?php _e('Here you will be able to manage your images, feeds from your account with Flickr, Picasa, and / or SmugMug.', 'photoxhibit'); ?></p>
	<h3><?php _e('FAQ', 'photoxhibit'); ?></h3>
	<dl id="px_structureFAQ" class="ui-accordion-container" >
		<dt><?php _e('What is the difference between Gallery and Album?', 'photoxhibit'); ?></dt>
		<dd><?php _e('The best I can explain is that Gallery is a show room and a Album is grouping of photos that you would use for a Gallery showing', 'photoxhibit'); ?></dd>
		<dt><?php _e('Do I need to set up options?', 'photoxhibit'); ?></dt>
		<dd><?php _e('No, not really, it will only make your life so much easier especially if you are going to be repeating your efforts', 'photoxhibit'); ?></dd>
	</dl>
</div>
<div class="overViewRight">
	<h4><?php _e('System Configuration', 'photoxhibit'); ?></h4>
	<ul>
		<li>
			<strong>allow_url_fopen</strong> is 
			<?php if(!(ini_get('allow_url_fopen') == '1')):?>
				<?php _e('<strong>off</strong> on your server, there may be some things you can\'t do with this plugin.', 'photoxhibit'); ?>
			<?php else: ?>
				<strong><?php _e('on', 'photoxhibit'); ?></strong>
			<?php endif; ?>
		</li>
		<li><?php _e('System memory limit:', 'photoxhibit'); ?> <strong><?php echo ini_get('memory_limit'); ?></strong></li>
		<li>
			<?php _e('Maximum uploadable file size:', 'photoxhibit'); ?> <strong><?php echo ini_get('upload_max_filesize'); ?></strong><br />
			<?php _e('Make sure this size is large enough, you won\'t be able to upload an image whose file size is bigger than this value.', 'photoxhibit'); ?></li>
		<li>
			<?php _e('Maximum POST size:', 'photoxhibit'); ?> <strong><?php echo ini_get('post_max_size'); ?></strong><br />
			<?php _e('If you want to upload more than one image at a time, make sure this limit is greater than the maximum file size x the number of images you want to upload at once.', 'photoxhibit'); ?>
		</li>
<?php
	if(function_exists("gd_info")){
		echo '<li>'. __('GD support:', 'photoxhibit') .' <strong>'. __('Yes', 'photoxhibit') . '</strong><ul>';
	}
	else {
		echo '<li><strong>'. __('No GD support!', 'photoxhibit') . '</strong></li>';
	}
?>
  </ul>
 </div>
<div class="clearfix"></div>
<?php $this->get_pagePart('usage');?>