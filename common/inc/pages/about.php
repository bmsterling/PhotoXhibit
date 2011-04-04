<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
	<!--- start bsg: about -->
	<div class="wrap">
		<h2><?php _e('Credits / Copyrights / Communications', 'photoxhibit') ;?></h2>
		<fieldset class="options">
			<legend><?php _e("Development", 'photoxhibit'); ?></legend>
			<p><?php _e("As it stands now, Benjamin Sterling is the sole developer of the PhotoXhibit Wordpress plugin but can't do it all, so if you are interested in  helping with the development of PhotoXhibit, please contact <a href=\"http://benjaminsterling.com/contact-me/\" target=\"_blank\">Benjamin Sterling</a>", 'photoxhibit'); ?></p>
		</fieldset>
		<fieldset class="options">
			<legend><?php _e("Do Respect", 'photoxhibit'); ?></legend>
			<ul>
				<li><?php _e("Error Icon from http://www.everaldo.com/", 'photoxhibit'); ?></li>
				<li><?php _e("XML Parser Class (Eric Rosebrock) http://www.phpfreaks.com", 'photoxhibit'); ?></li>
				<li><?php _e("JSON Class (Cesar D. Rodas) http://cesars.users.phpclasses.org/json", 'photoxhibit'); ?>  </li>
			</ul>
			<legend><?php _e("How to Help", 'photoxhibit'); ?></legend>
			<dl>
				<dt><strong><?php _e("Send bugs / bug fixes / ideas / suggestions", 'photoxhibit'); ?></strong></dt>
				<dd>
					<?php _e("The best way to improve the plugin is to communicate bugs, the possible fixes for those bugs, the ideas that will make this 			plugin unmatched, and suggestions on how to grow my hair back.", 'photoxhibit'); ?>
				</dd>
				<dt><strong><?php _e("Translations", 'photoxhibit'); ?></strong></dt>
				<dd>
					<?php _e("I would like to make this plugin accessible to as many people as possible, so if you are willing to translate everything into 					the language that you are fluent in, please let me know.", 'photoxhibit'); ?>
				</dd>
			</dl>
		</fieldset>
		<fieldset class="options">
			<legend><?php _e("How to Support", 'photoxhibit'); ?></legend>
			<dl>
				<dt><strong><?php _e("Place a link to the plugin in your blog/webpage", 'photoxhibit'); ?></strong></dt>
				<dd>
					<?php _e("A link /  a post reviewing this plugin is a great way to get the word out.", 'photoxhibit'); ?>
				</dd>
				<dt><strong><?php _e("Make a donation", 'photoxhibit'); ?></strong></dt>
				<dd>
					<?php _e("Hosting cost a lot, I try to off load as much bandwidth as possible, but there is only so much I can do; so making a donation is a great way help keep the project going.", 'photoxhibit'); ?>
					<form action="https://www.paypal.com/cgi-bin/webscr" target="_blank" method="post"><input type="hidden" name="cmd" value="_s-xclick"><input type="image" src="https://www.paypal.com/en_US/i/btn/x-click-butcc-donate.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!"><img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1"><input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----"></form>
				</dd>
			</dl>
		</fieldset>
	</div>
	<!--- end bsg: about -->