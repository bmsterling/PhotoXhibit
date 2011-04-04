<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<div id="px_message" class="updated" style="display:none"><p></p></div>

<div id="px_gallery" class="wrap" <?php if(empty($_GET['gid'])){?> style="display:none" <?php }?>>
	<div style="margin: auto; width: 650px; padding-bottom:15px; ">
		<a class="editLinks" href="admin.php?page=px_manage&amp;action=edit_styles&amp;gid=<?php echo $_GET['gid'];?>"><?php _e('Edit Styles', 'photoxhibit'); ?></a>
		|
		<a class="editLinks" href="admin.php?page=px_manage&amp;action=edit_image_attr&amp;gid=<?php echo $_GET['gid'];?>"><?php _e('Edit Images', 'photoxhibit'); ?></a>
	</div>
	<div style="width:650px;margin:0 auto;">
	<?php $this->build_image_set($_GET['gid']);?>
	</div>
</div>

<div class="wrap">
	<a name="error" id="error"></a>
	<div id="loaderAnimation"></div>
	<h2><?php _e('PhotoXhibit Build', 'photoxhibit'); ?></h2>
	<input type="hidden" id="px_gidHidden" name="px_gidHidden" value="<?php echo $_GET['gid'];?>"/>
	<input type="hidden" id="px_pluginid" name="px_pluginid" value="<?php echo $this->cur_gallery_info->plugin_id;?>"/>
	<input type="hidden" name="px_serviceHidden" value=""/>
	<input type="hidden" name="px_goBackToHidden" value=""/>
	<input type="hidden" name="px_currentScreen" value="px_services"/>
	<div id="px_holder">
		<div id="px_gut">
			<div id="px_services" class="px_child">
				<?php $this->get_pagePart('buildServices');?>
			</div>
			<?php if($this->vars['use_picasa']==1):?>
			<div id="px_picasaOptions" class="px_child">
				<?php $this->get_pagePart('buildPicasaOptions');?>
			</div>
			<div id="px_picasaBasic" class="px_child">
				<?php $this->get_pagePart('buildPicasaBasic');?>
			</div>
			<div id="px_picasaAdvance" class="px_child">
				<?php $this->get_pagePart('buildPicasaAdvanced');?>
			</div>
			<div id="px_picasaThumbnails" class="px_child">
				<?php $this->get_pagePart('buildPicasaThumbnails');?>
			</div>
			<?php endif;?>
			<?php if($this->vars['use_flickr']==1):?>
			<div id="px_buildFlickrOptions" class="px_child">
				<?php $this->get_pagePart('buildFlickrOptions');?>
			</div>
			<div id="px_buildFlickrBasic" class="px_child">
				<?php $this->get_pagePart('buildFlickrBasic');?>
			</div>
			<div id="px_buildFlickrPhotoset" class="px_child">
				<?php $this->get_pagePart('buildFlickrPhotoset');?>
			</div>
			<div id="px_buildFlickrSearch" class="px_child">
				<?php $this->get_pagePart('buildFlickrSearch');?>
			</div>
			<div id="px_buildFlickrAPI" class="px_child">
				<?php $this->get_pagePart('buildFlickrAPI');?>
			</div>
			<div id="px_buildFlickrThumbnails" class="px_child">
				<?php $this->get_pagePart('buildFlickrThumbnails');?>
			</div>
			<?php endif;?>
			<?php if($this->vars['use_smugmug']==1):?>
			<div id="px_buildSmugMugAdvance" class="px_child">
				<?php $this->get_pagePart('buildSmugMugAdvance');?>
			</div>
			<div id="px_buildSmugMugThumbnails" class="px_child">
				<?php $this->get_pagePart('buildSmugMugThumbnails');?>
			</div>			
			<?php endif;?>
			<?php if($this->vars['use_album']==1):?>
			<div id="px_buildAlbumList" class="px_child">
				<?php $this->get_pagePart('buildAlbumList');?>
			</div>
			<div id="px_buildAlbumThumbnails" class="px_child">
				<?php $this->get_pagePart('buildAlbumThumbnails');?>
			</div>
			<?php endif;?>
			<?php if($this->vars['use_local']==1):?>
			<div id="px_buildLocal" class="px_child">
				<?php $this->get_pagePart('buildLocal');?>
			</div>
			<?php endif;?>
			<?php if($this->vars['use_browse']==1):?>
			<div id="px_buildBrowse" class="px_child">
				<?php $this->get_pagePart('buildBrowse');?>
			</div>
			<?php endif;?>
		</div>
	</div>
</div>
<div class="wrap" id="px_notice" style="display:none;"></div>
<div class="wrap">
		<table width="100%" cellspacing="15" style="width:650px;margin:0 auto;">
			<thead>
				<tr>
					<th><?php _e('Doubleclick on the images you want to add and they will be moved to the box on the right.', 'photoxhibit'); ?></th>
					<th><?php _e('Below, if you have not figured it out, is the box on the right.  Doubleclick on a image if you want to remove it.  Click and drag an image if you want to reorder it.', 'photoxhibit'); ?></th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td width="50%" valign="top" align="center">
						<a href="#" id="px_add_all"><?php _e('Add All', 'photoxhibit'); ?></a><br/>
						<?php _e('note: if you have a lot of images the browser may hang for a second or so', 'photoxhibit'); ?>
					</td>
					<td width="50%" valign="top" align="center">
						<a href="#" id="px_remove_all"><?php _e('Remove All', 'photoxhibit'); ?></a><br/>
						<?php _e('note: if you have a lot of images the browser may hang for a second or so', 'photoxhibit'); ?>
					</td>
				</tr>
				<tr>
					<td width="50%" style="border:1px solid #ccc;" valign="top">
						<ul id="selectList"></ul>
					</td>
					<td width="50%" style="border:1px solid #ccc;" valign="top">
						<ul id="imageList"><?php $this->build_img_admin_list();?></ul>
					</td>
				</tr>
			</tbody>
		</table>
</div>
<?php $this->get_pagePart('buildStructure');?>
<div id="px_message2" class="updated" style="display:none"><p></p></div>
<?php $this->get_pagePart('buildGalleryOptions');?>