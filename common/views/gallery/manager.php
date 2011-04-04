<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}

	$px_results = $wpdb->get_results("SELECT * FROM ".$this->options['galleries']);
?>

<div id="px_message" class="updated" style="display:none"><p></p></div>

<div class="wrap">
	<h2><?php _e('PhotoXhibit Galleries', 'photoxhibit'); ?></h2>
	<table width="100%"  border="0" cellspacing="3" cellpadding="3">
		<thead>
			<tr class="thead">
				<th width="2%"><?php _e('ID', 'photoxhibit'); ?></th>	
				<th width="11%"><?php _e('Post Code', 'photoxhibit'); ?></th>	
				<th width="25%"><?php _e('Gallery Title', 'photoxhibit'); ?></th>
				<th width="25%"><?php _e('Gallery Type', 'photoxhibit'); ?></th>	
				<th><?php _e('Edit Styles', 'photoxhibit'); ?></th>
				<th><?php _e('Edit Images', 'photoxhibit'); ?></th>
				<th><?php _e('Delete', 'photoxhibit'); ?></th>
			</tr>
		</thead>
	<?php
		if($px_results) {
	?>
		<tbody>
		<?php
			$i = 0;
			foreach($px_results as $px_result) {
				if($i%2 == 0) {
					$style = 'style=\'background-color: #eee\'';
				}  else {
					$style = 'style=\'background-color: none\'';
				}
		?>
			<tr <?php echo $style;?>>
				<td><?php echo $px_result->gallery_id;?></td>
				<td>[photoxhibit=<?php echo $px_result->gallery_id;?>]</td>
				<td><a href="admin.php?page=px_build&amp;gid=<?php echo $px_result->gallery_id;?>"><?php echo $px_result->gallery_title;?>  (<?php _e('edit', 'photoxhibit');?>)</a></td>
				<td>
		<?php
			$sql = "SELECT * FROM ".$this->options['plugins']." WHERE plugin_id = ".$px_result->plugin_id;
			$r = $wpdb->get_row($sql);
			echo '<a href="'.$r->plugin_example.'" target="_blank" title="example">'.$r->plugin_title.' (' . __('new window', 'photoxhibit') . ')</a>';
		?>
				</td>
				<td><a href="admin.php?page=px_manage&amp;action=edit_styles&amp;gid=<?php echo $px_result->gallery_id;?>"><?php _e('Edit Styles', 'photoxhibit'); ?></a></td>
				<td><a href="admin.php?page=px_manage&amp;action=edit_image_attr&amp;gid=<?php echo $px_result->gallery_id;?>"><?php _e('Edit Images', 'photoxhibit'); ?></a></td>
				<td><a href="admin.php?page=px_manage&amp;action=delete_gallery&amp;gid=<?php echo $px_result->gallery_id;?>" class="px_optDelete"><?php _e('Delete', 'photoxhibit'); ?></a></td>
			</tr>
		<?php 
				$i++;
			}
		?>
		</tbody>
		<?php
		}
		else{
			echo '<tr><td colspan="7" align="center"><strong>' . __('No Galleries Found', 'photoxhibit') .'</strong></td></tr>';
		}?>
	</table>
</div>