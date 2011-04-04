<?php
header('Content-Type: text/html; charset=utf-8');
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>

<div class="wrap">
	<h2><?php _e('Image Editor', 'photoxhibit'); ?></h2>
	<p>
		<?php _e('Still in developement, but the goal is to give the ability to minipulate you photos in what ever way possible.', 'photoxhibit'); ?>
		<?php _e('There is not ETA on completion, but updates will come as soon as possible.', 'photoxhibit'); ?>
	</p>
</div>