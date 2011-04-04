<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}

/*  Copyright 2007 Benjamin Sterling  (email : benjamin.sterling@kenzomedia.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

if( isset( $_GET['gid'] ) ){
	//$this->adminHeader();
	$this->cur_gallery_id = $_GET['gid'];
	$this->get_imgs_group();
	/*
	echo '<pre>';
	print_r($this->cur_image_group);
	echo '</pre>';
	*/
	
?>


<div class="wrap">
		<a name="topGal" id="topGal"></a>
	<h2><?php _e('PhotoXhibit Image Attribute Editor', 'photoxhibit'); ?></h2>

	<div style="margin: auto; width: 650px; padding-bottom:15px; ">
		<a class="editLinks" href="admin.php?page=px_manage&amp;action=edit_styles&amp;gid=<?php echo $_GET['gid'];?>"><?php _e('Edit Styles', 'photoxhibit'); ?></a>
		|
		<a class="editLinks" href="admin.php?page=px_build&amp;gid=<?php echo $_GET['gid'];?>"><?php _e('Edit Gallery', 'photoxhibit'); ?></a>
	</div>

	<div style="margin: auto; width: 650px; ">
		<table width="100%"  border="0" cellspacing="3" cellpadding="3">
			<thead>
				<tr class="thead">
					<th width="20%"><?php _e('Img', 'photoxhibit'); ?></th>	
					<th width="80%" colspan="2"><?php _e('Alt Tag', 'photoxhibit'); ?></th>
				</tr>
			</thead>
<?php if($this->cur_image_group): ?>
			<tbody>
			<?php
				$i = 0;
				foreach($this->cur_image_group as $image) {
					if($i%2 == 0) {
						$style = 'style=\'background-color: #eee\'';
					}  else {
						$style = 'style=\'background-color: none\'';
					}
			?>
				<tr <?php echo $style;?>>
					<td><img src="<?php echo $image->photo_tnurl;?>"/></td>
					<td><input type="text" id="photo_alt-<?php echo $image->photo_id;?>" name="photo_alt" value="<?php echo $image->photo_alt;?>" size="50"/></td>
					<td width="20%"></td>
				</tr>
			<?php 
					$i++;
				}
			?>
			</tbody>
<?php else: ?>
		
<?php endif;?>
		</table>
	</div>
</div>

<script type="text/javascript">
(function ($) {
	$(document).ready(function(){
		var jQinputs = $('input[name=photo_alt]');
		var TO = Object();
		jQinputs.keyup(function(){
			var jQthis = $(this);
			var id = jQthis.attr('id');
			clearTimeout(TO[id]);
			TO[id] = setTimeout(function(){
						var value = jQthis.val();
						jQthis.parent().next().text('Alt text is being updated');		
						$.ajax({
							url : '<?php echo str_replace( array($_SERVER['HTTP_HOST'], "http://"), "", $this->parentFileUrl);?>',
							data : 'option=update_photos&pid='+id.split('-').pop()+'&value='+value,
							dataType : 'json',
							success : function(data, textStatus){
								if(data.error == 'error_no_styles'){
									//alert('Sorry, but the styles were not passed to the server, please try again.');
								}
								else if(data.error == 'error_no_id'){
									//alert('Sorry, but the ID was not passed to the server, please try again.');
								}
								else{
									jQthis.parent().next().text('<?php _e('Alt text has been updated');?>');
								}
							}				
						});
				    }, 1000);
		});
	});
})(jQuery);
</script>
<?php
}
?>