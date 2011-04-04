<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<div class="wrap">
	<h2><?php _e('PhotoXhibit Usage', 'photoxhibit'); ?></h2>
	<blockquote>
		<h4><?php _e('For use in your theme', 'photoxhibit'); ?></h4>
		<ol>
			<li><?php _e('Open <strong>wp-content/themes/&lt;YOUR THEME NAME&gt;/sidebar.php</strong> or where ever you want to put the gallery', 'photoxhibit'); ?></li>
			<li>
				<?php _e('Add', 'photoxhibit'); ?>:
				<blockquote>
					<pre>&lt;?php if (function_exists('photoxhibit')): ?&gt;
&lt;li&gt;
&nbsp;&nbsp;&nbsp;&lt;?php photoxhibit(2); ?&gt;
&lt;/li&gt;
&lt;?php endif; ?&gt;</pre>
			</blockquote>
			</li>
			<li>
				<?php _e('Change the "2" to the id of the gallery you want to show, you will find this id in the "Manage Gallery" tab. <strong> NOTE:</strong> if you are not going to use it with in you sidebar.php\'s List structure, just get rid of the &lt;li&gt; and &lt;/li&gt;', 'photoxhibit'); ?>
			</li>
		</ol>
	</blockquote>
	<blockquote>
		<h4><?php _e('For use in your post', 'photoxhibit'); ?></h4>
		<ol>
			<li><pre class="wp-polls-usage-pre">[photoxhibit=<strong>2</strong>]</pre></li>
			<li><?php _e('Change the "2" to the id of the gallery you want to show, you will find this id in the "Manage Gallery" tab.', 'photoxhibit'); ?></li>
		</ol>
	</blockquote>
</div>