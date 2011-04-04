<?php
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])){
	header($_SERVER['HTTP_HOST']);
	exit();
}
?>
<h2><?php _e('Album Basics', 'photoxhibit'); ?></h2>
<table width="100%" cellpadding="3" cellspacing="3" border="0">
	<tr>
		<td width="18%"><?php _e('Upload Path', 'photoxhibit'); ?></td>
		<td width="235"><input type="text" size="30" value="<?php echo $this->vars['options_path'];?>" name="options_path" id="options_path"/></td>
		<td><?php _e('This is the default path for uploading your images', 'photoxhibit'); ?></td>
	</tr>
	<tr>
		<td width="18%"><?php _e('Album Delete All', 'photoxhibit'); ?></td>
		<td width="235"><input type="checkbox" value="1" <?php echo ($this->vars['options_dropall']==1)?' checked="checked" ':'';?> name="options_dropall" id="options_dropall"/></td>
		<td><?php _e('By default, the images and folder associated with an album will not be deleted when an album is dropped, check this box if you want to drop all associated.', 'photoxhibit'); ?></td>
	</tr>
	<tr>
		<td width="18%"><?php _e('Image Deletion', 'photoxhibit'); ?></td>
		<td width="235"><input type="checkbox" value="1" <?php echo ($this->vars['options_delete']==1)?' checked="checked" ':'';?> name="options_delete" id="options_delete"/></td>
		<td><?php _e('By default, images are deleted from the server when they are deleted from the database, uncheck this box if you don\'t want this.', 'photoxhibit'); ?></td>
	</tr>
	<tr>
		<td width="18%"><?php _e('Keep an original', 'photoxhibit'); ?></td>
		<td width="235"><input type="checkbox" value="1" <?php echo ($this->vars['options_original']==1)?' checked="checked" ':'';?> name="options_original" id="options_original"/></td>
		<td><?php _e('Check this box if you want to have an unmodified version as well as the modifed size below.', 'photoxhibit'); ?></td>
	</tr>
	<tr>
		<td width="18%"><?php _e('Max Size of Image', 'photoxhibit'); ?></td>
		<td width="235">
			<input size="4" maxlength="4" name="options_MaxWidth" id="options_MaxWidth" value="<?php echo $this->vars['options_MaxWidth'];?>" type="text"/>
			x
			<input size="4" maxlength="4" id="options_MaxHeight" name="options_MaxHeight" value="<?php echo $this->vars['options_MaxHeight'];?>" type="text"/>
		</td>
		<td><?php _e('This is the default max height and width of image uploaded (eg. if image is 1600 x 1000 it will get resized to, while keeping aspect ratio, to these numbers)', 'photoxhibit'); ?></td>
	</tr>
	<tr>
		<td width="18%"><?php _e('Image Quality', 'photoxhibit'); ?></td>
		<td width="235">
			<input size="4" maxlength="4" name="options_imageQuality" id="options_imageQuality" value="<?php echo $this->vars['options_imageQuality'];?>" type="text"/>%
		</td>
		<td> <?php _e('Specify the JPEG quality factor (from 0 to 100). This option will be used when manipulating JPEG images.', 'photoxhibit'); ?></td>
	</tr>
	<tr>
		<td width="18%" valign="top"><?php _e('Number of thumbnails and sizes', 'photoxhibit'); ?></td>
		<td width="" colspan="2">
			<ol>
				<li>
					<dl>
						<dt>
							
							<?php _e('Thumbnail set #1', 'photoxhibit'); ?>
						</dt>
						<dd>
							<?php _e('1 thumbnail at', 'photoxhibit'); ?> 
							<input size="4" maxlength="4" name="options_thumbailW" id="options_thumbailW" value="<?php echo $this->vars['options_thumbailW'];?>" type="text">
							x
							<input size="4" maxlength="4" id="options_thumbailH" name="options_thumbailH" value="<?php echo $this->vars['options_thumbailH'];?>" type="text">
						</dd>
					</dl>
				</li>
				<li>
					<dl>
						<dt>
							<input type="checkbox" name="options_thumbailSet" value="1" <?php echo ($this->vars['options_thumbailSet']==1)?' checked="checked" ':'';?>/>
							<?php _e('Thumbnail set #2 (check this if you want a second resize thumbnail)', 'photoxhibit'); ?>
						</dt>
						<dd> 
							<input size="4" maxlength="4" name="options_thumbailW2" id="options_thumbailW2" value="<?php echo $this->vars['options_thumbailW2'];?>" type="text">
							x
							<input size="4" maxlength="4" id="options_thumbailH2" name="options_thumbailH2" value="<?php echo $this->vars['options_thumbailH2'];?>" type="text">
							<br/>
						</dd>
					</dl>
				</li>
			</ol>
		</td>
	</tr>
	<tr>
		<td width="18%"><?php _e('Thumbnail Quality', 'photoxhibit'); ?></td>
		<td width="235">
			<input size="4" maxlength="4" name="options_tnimageQuality" id="options_tnimageQuality" value="<?php echo $this->vars['options_tnimageQuality'];?>" type="text"/>%
		</td>
		<td> <?php _e('Specify the JPEG quality factor (from 0 to 100). This option will be used when manipulating JPEG images.', 'photoxhibit'); ?></td>
	</tr>
</table>
