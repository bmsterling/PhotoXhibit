<?php if( $this->vars['use_manager'] == 1 ):?>

<div id="px_message" class="updated" style="display:none"><p></p></div>
<div class="dbx-box" id="">
	<div class="dbx-h-andle-wrapper">
		<h3 class="dbx-handle">PhotoXhibit Manager</h3>
	</div>
	<div class="dbx-c-ontent-wrapper">
		<div id="photo-content" class="dbx-content">
			<div id="photo-menu">
				<ul>
			<?php if($this->vars['use_flickr']==1):?>
					<li><a href="#fragment-0"><span><?php _e('Flickr', 'photoxhibit'); ?></span></a></li>
			<?php endif;?>
			<?php if($this->vars['use_smugmug']==1):?>
					<li><a href="#fragment-1"><span><?php _e('SmugMug', 'photoxhibit'); ?></span></a></li>
			<?php endif;?>
					<li><a href="#fragment-2"><span><?php _e('Picasa', 'photoxhibit'); ?></span></a></li>
				</ul>
			</div>
			<?php if($this->vars['use_flickr']==1):?>
			<div id="fragment-0" class="px_panel">
				<h3>Flickr Panel</h3>
				<fieldset class="px_fs1">
					<legend>Uploaded By</legend>
					<p><label><input class="px_reset" type="radio" name="flickr_uploaded_by" checked="checked" value="anyone"/> Anyone</label></p>
					<p><label for="flickr_userid">
						<input class="px_reset" type="radio" id="flickr_userid" name="flickr_uploaded_by" value="userid"/> 
						UserID:
					</label>
					<label>
						<select name="flickr_user_id">
	<?php if(isset($this->vars['flickr_user_id'])):?>
					<option selected="selected"></option>
	<?php
		$flickr_user_id = explode(',', $this->vars['flickr_user_id']); 
		while(list($key,$value) = each($flickr_user_id)){?>
					<option value="<?php echo trim($value);?>"><?php echo trim($value);?></option>
	<?php }?>
	<?php else:?>
					<option selected="selected"><?php _e('No User ID stored', 'photoxhibit'); ?></option>
	<?php endif;?>
						</select>
					</label></p>
					<p><label><input class="px_reset" type="radio" id="flickr_usernameRb" name="flickr_uploaded_by" value="username"/> Username:</label>
					<label><input type="text" name="flickr_username" style="width:102px;"/></label></p>
				</fieldset>
	
				<fieldset class="px_fs2">
					<legend>Search Type</legend>
					<p><label><input class="px_reset" type="radio" name="search_type" value="flickr.photos.getRecent" checked="checked"/> All Images</label></p>
					<p><label>
						<input class="px_reset" type="radio" name="search_type" value="flickr.photosets.getPhotos"/>
						Photoset:
					</label>
					<label>
						<select name="flickr_photoset_id" style="width:130px;">
	<?php if(isset($this->vars['flickr_photoset_id'])):?>
					<option selected="selected" leave="true"></option>
	<?php
		$flickr_photoset_id = explode(',', $this->vars['flickr_photoset_id']); 
		while(list($key,$value) = each($flickr_photoset_id)){?>
					<option leave="true" value="<?php echo trim($value);?>"><?php echo trim($value);?></option>
	<?php }?>
	<?php else:?>
					<option selected="selected"><?php _e('No Photoset ID stored', 'photoxhibit'); ?></option>
	<?php endif;?>
						</select>
					</label></p>
					<p><label>
						<input class="px_reset" type="radio" id="flickr_tagsRb" name="search_type" value="flickr.photos.search"/> 
						Tags:
					</label>
					<label>
						<input type="text" name="flickr_tags" style="width:170px;"/>
					</label></p>
				</fieldset>
				<fieldset class="px_fs3">
					<legend>Do Search</legend>
					<p class="submit"><input type="button" name="search" from="flickr" value="Search"/></p>
					<p class="submit"><input type="button" id="flickrPagePrev" disabled="disabled" name="" value="Prev"/>
					<input type="button" id="flickrPageNext" disabled="disabled" name="" value="Next"/></p>
				</fieldset>
				<div class="clearfix"></div>
				<div id="flickrHolder" class="px_holder">
	
				</div>
				<fieldset>
					<legend>Layout</legend>
					<div class="layoutGroup">
						<label>
							Alignment:
							<select name="alignment" class="" from="flickr">
								<option selected="selected"></option>
								<option value="left">left</option>
								<option value="right">right</option>
								<option value="top">top</option>
								<option value="texttop">texttop</option>
								<option value="middle">middle</option>
								<option value="absmiddle">absmiddle</option>
								<option value="baseline">baseline</option>
								<option value="bottom">bottom</option>
								<option value="absbottom">absbottom</option>
							</select>
						</label>
						
						<label>
							Border thickness:
							<input type="text" name="border" from="flickr" class="px_small_input"/>
						</label>
						
						<label>
							CSS Class:
							<input type="text" name="class" from="flickr" class="px_small_input"/>
						</label>
					</div>
				<div class="layoutGroup">
						<label>
							Horizontal spacing:
							<input type="text" name="hspace" from="flickr" class="px_small_input"/>
						</label>
						
						<label>
							Vertical spacing:
							<input type="text" name="vspace" from="flickr" class="px_small_input"/>
						</label>				
					</div>
				</fieldset>
				<fieldset>
					<legend><?php _e('Size and Insert', 'photoxhibit'); ?></legend>
					<label>
						<?php _e('Picture Size:', 'photoxhibit'); ?>
						<select name="size" from="flickr">
							<option value="square" selected="selected"><?php _e('Square', 'photoxhibit'); ?>  75x75</option>
							<option value="thumbnail"><?php _e('Thumbnail', 'photoxhibit'); ?> 100 on longside</option>
							<option value="small"><?php _e('Small', 'photoxhibit'); ?> 240 on longside</option>
							<option value="medium"><?php _e('Medium', 'photoxhibit'); ?> 500 on longside</option>
							<option value="large"><?php _e('Large', 'photoxhibit'); ?> 1024 on longside</option>
						</select>
					</label>
					<label><input type="checkbox" name="linkit" value="1"/> <?php _e('Include link to image', 'photoxhibit'); ?></label>
					<input type="button" class="button" name="insertImage" from="flickr" value="Insert Image"/>
				</fieldset>
	
			</div>
			<?php endif;?>
			<?php if($this->vars['use_smugmug']==1):?>
	
			<div id="fragment-1" class="px_panel">
				<h3>SmugMug Panel</h3>
				<fieldset class="px_fs1">
					<legend>Uploaded By</legend>
					<p><label for="flickr_userid"><?php _e('SmugMug Stored User ID', 'photoxhibit'); ?>:
					</label>
					<label>
						<select name="smugmug_user_id_dd" id="smugmug_user_id_dd">
	<?php if(isset($this->vars['smugmug_user_id'])):?>
							<option selected="selected"></option>
	<?php 
	$smugmug_user_id = explode(',', $this->vars['smugmug_user_id']);
	while(list($key,$value) = each($smugmug_user_id)){
	?>
							<option value="<?php echo trim($value);?>"><?php echo trim($value);?></option>
	<?php }
	else:?>
							<option selected="selected"><?php _e('No User IDs stored', 'photoxhibit'); ?></option>
	<?php endif;?>
						</select>
					</label></p>
					<p><label>SmugMug User ID:</label>
					<label><input type="text" title="Enter a username to build the album list" name="smugmug_user_id" style="width:102px;"/></label></p>
				</fieldset>
	
				<fieldset class="px_fs2">
					<legend>Search Type</legend>
					<p>
						<label>SmugMug Albums:
					</label>
					<label>
						<select name="smugmug_album_id_dd" id="smugmug_album_id_dd">
							<option selected="selected" disabled="disabled">Enter a username</option>
						</select>
					</label></p>
					</fieldset>
				<fieldset class="px_fs3">
					<legend>Do Search</legend>
					<p class="submit"><input type="button" name="search" from="smugmugphotos" value="Search"/></p>
				</fieldset>
				<div class="clearfix"></div>
				<div id="smugmugHolder" class="px_holder">
	
				</div>
				<fieldset>
					<legend>Layout</legend>
					<div class="layoutGroup">
						<label>
							Alignment:
							<select name="alignment" class="" from="smugmug">
								<option selected="selected"></option>
								<option value="left">left</option>
								<option value="right">right</option>
								<option value="top">top</option>
								<option value="texttop">texttop</option>
								<option value="middle">middle</option>
								<option value="absmiddle">absmiddle</option>
								<option value="baseline">baseline</option>
								<option value="bottom">bottom</option>
								<option value="absbottom">absbottom</option>
							</select>
						</label>
						
						<label>
							Border thickness:
							<input type="text" name="border" from="smugmug" class="px_small_input"/>
						</label>
						
						<label>
							CSS Class:
							<input type="text" name="class" from="smugmug" class="px_small_input"/>
						</label>
					</div>
				<div class="layoutGroup">
						<label>
							Horizontal spacing:
							<input type="text" name="hspace" from="smugmug" class="px_small_input"/>
						</label>
						
						<label>
							Vertical spacing:
							<input type="text" name="vspace" from="smugmug" class="px_small_input"/>
						</label>				
					</div>
				</fieldset>
				<fieldset>
					<legend>Size and Insert</legend>
					<label>
						Picture Size:
						<select name="size" from="smugmug">
							<option value="square" selected="selected"><?php _e('up to 100 x up to 100', 'photoxhibit'); ?></option>
							<option value="thumbnail"><?php _e('up to 150 x up to 150', 'photoxhibit'); ?></option>
							<option value="small"><?php _e('up to 400 x up to 300', 'photoxhibit'); ?></option>
							<option value="medium"><?php _e('up to 600 x up to 450', 'photoxhibit'); ?></option>
							<option value="large"><?php _e('up to 800 x up to 600', 'photoxhibit'); ?></option>
						</select>
					</label>
					<label><input from="smugmug" type="checkbox" name="linkit" value="1"/> Include link to image</label>
					<input type="button" class="button" name="insertImage" from="smugmug" value="Insert Image"/>
				</fieldset>
	
			</div>
			<?php endif;?>
			<?php if($this->vars['use_picasa']==1):?>
			<div id="fragment-2" class="px_panel">
				<h3>Picasa Panel</h3>
				<p>Coming soon</p>
			</div>
			<?php endif;?>
		</div>
	</div>
</div>		
<div style="clear: both;">&nbsp;</div>

<?php endif; ?>