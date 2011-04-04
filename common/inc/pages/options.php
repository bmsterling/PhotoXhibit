<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<div id="px_message" class="updated" style="display:none"><p></p></div>

<div class="wrap">
	<div id="loaderAnimation"></div>
	<form action="" method="post" id="px_optionsPage">
		<div id="px_structureOptions" class="light">
			<ul>
				<li><a href="#fragment-0"><span><?php _e('Basics', 'photoxhibit'); ?></span></a></li>
				<li><a href="#fragment-1"><span><?php _e('Services', 'photoxhibit'); ?></span></a></li>
				<li><a href="#fragment-2"><span><?php _e('Flickr Params', 'photoxhibit'); ?></span></a></li>
				<li><a href="#fragment-3"><span><?php _e('Picasa Params', 'photoxhibit'); ?></span></a></li>
				<li><a href="#fragment-4"><span><?php _e('SmugMug Params', 'photoxhibit'); ?></span></a></li>
				<li><a href="#fragment-5"><span><?php _e('Album Basics', 'photoxhibit'); ?></span></a></li>
			</ul>
			<div id="fragment-0">
				<?php $this->get_pagePart('optionsBasic');?>
			</div>
			<div id="fragment-1">
				<?php $this->get_pagePart('optionsServices');?>
			</div>
			<div id="fragment-2">
				<?php $this->get_pagePart('flickrParams');?>
			</div>
			<div id="fragment-3">
				<?php $this->get_pagePart('picasaParams');?>
			</div>
			<div id="fragment-4">
				<?php $this->get_pagePart('smugMugParams');?>
			</div>
			<div id="fragment-5">
				<?php $this->get_pagePart('optionsBasics');?>
			</div>
		</div>
		<p class="submit">
			<input type="submit" name="px_optionsPageSubmit" id="px_optionsPageSubmit" value="<?php _e('Submit Changes', 'photoxhibit'); ?>" />
		</p>
	</form>
</div>