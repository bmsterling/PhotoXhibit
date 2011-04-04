<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}

	$px_results = $wpdb->get_results("SELECT * FROM ".$this->options['albums']);
?>

<div id="px_message" class="updated" style="display:none"><p></p></div>

<div class="wrap">
	<?php if ( $this->safe_mode ):?>
	<div class="error"><p><?php _e('Safe Mode is turn on on this server, you will need to manually create a folder for each album you want.', 'photoxhibit'); ?></p></div>
	<?php endif; ?>

	<h2><?php _e("PhotoXhibit Albums", 'photoxhibit'); ?></h2>
	<?php if(function_exists("gd_info")):?>
	<fieldset class="options">
		<legend><?php _e("Quick Album Edit", 'photoxhibit'); ?></legend>
		<input type="hidden" name="px_albumNameHolder" id="px_albumNameHolder" value=""/>
		<table width="100%" cellspacing="3" cellpadding="3" border="0">
			<tbody>
				<tr>
					<th align="right"><?php _e("Select album", 'photoxhibit'); ?></th>  
					<td>
						<select name="px_albumSelect" id="px_albumSelect">
							<option value="0"><?php _e("No album selected", 'photoxhibit'); ?></option>
	<?php
		if($px_results) {
			foreach($px_results as $px_result) {
				echo '<option id="pxOption'.$px_result->album_id.'" value="'.$px_result->album_id.'">'.$px_result->album_name.'</option>';
			}
		}
	?>
						</select>
					</td> 
					<th align="right" id="px_addUpdateTxt"><?php _e("Add new album", 'photoxhibit'); ?></th>
					<td><input value="" name="px_addUpdateInput" id="px_addUpdateInput"/></td>
					<td>
						<p class="submit">
							<input type="submit" id="px_deleteAlbumBtn" value="<?php _e("Delete &raquo;", 'photoxhibit'); ?>" name="px_deleteAlbumBtn" style="display:none;"/>
							<input type="submit" id="px_addUpdateAlbumBtn" value="<?php _e("Add &raquo;", 'photoxhibit'); ?>" name="px_addUpdateAlbumBtn"/>
						</p>
					</td>
				</tr>
			</tbody>
		</table>
	</fieldset>
	<table width="100%"  border="0" cellspacing="3" cellpadding="3" id="px_albumTable">
		<thead>
			<tr class="thead">
				<th width="2%"><?php _e("ID", 'photoxhibit'); ?></th>	
				<th width="85%"><?php _e("Album Title", 'photoxhibit'); ?></th>
				<th><?php _e("Delete", 'photoxhibit'); ?></th>
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
			<tr <?php echo $style;?> id="pxTrId<?php echo $px_result->album_id;?>">
				<td><?php echo $px_result->album_id;?></td>
				<td><a href="admin.php?page=px_manageAlbum&amp;action=edit_images&amp;aid=<?php echo $px_result->album_id;?>"><?php echo $px_result->album_name;?> (<?php _e("Edit Images", 'photoxhibit'); ?>)</a></td>
				<td><a href="admin.php?page=px_manageAlbum&amp;action=delete_album&amp;aid=<?php echo $px_result->album_id;?>" class="px_optDelete"><?php _e("Delete", 'photoxhibit'); ?></a></td>
			</tr>
		<?php 
				$i++;
			}
		?>
		</tbody>
		<?php
		}
		else{
			echo '<tr><td colspan="7" align="center"><strong>'. __("No Albums Found</strong>", 'photoxhibit') .'</td></tr>';
		}?>
	</table>
	<?php else: ?>
		<p><?php _e("You need GD Support for you to use these functions.", 'photoxhibit'); ?></p>
	<?php endif;?>
</div>