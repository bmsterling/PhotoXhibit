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

?>

<div id="px_message" class="updated" style="display:none"><p></p></div>
<form action="admin.php?page=px_manage&action=edit_styles&amp;do=editStyles&amp;gid=<?php echo $_GET['gid'];?>" method="post">
<div class="wrap" id="finGallery">
	<a name="topGal" id="topGal"></a>
	<h2><?php _e('PhotoXhibit Style Editor', 'photoxhibit'); ?></h2>

	<div style="margin: auto; width: 650px; padding-bottom:15px; ">
		<a class="editLinks" href="admin.php?page=px_manage&amp;action=edit_image_attr&amp;gid=<?php echo $_GET['gid'];?>"><?php _e('Edit Images', 'photoxhibit'); ?></a>
		|
		<a class="editLinks" href="admin.php?page=px_build&amp;gid=<?php echo $_GET['gid'];?>"><?php _e('Edit Gallery', 'photoxhibit'); ?></a>
	</div>
	<div style="margin: auto; width: 650px; " id="parent">
		<?php $this->build_image_set($_GET['gid']);?>
	</div>
</div>
<script type="text/javascript" src="<?php echo $this->parentFileUrl.'?option=edit_styles&'.time();?>"></script>

<div class="wrap">
	<p class="submit">
		<input type="hidden" name="gid" id="px_gid" value="<?php echo $_GET['gid'];?>"/>
	<?php if( $this->vars['none_ajax_styles'] == 1 ):?>
		<input type="submit" name="px_processStyles" id="px_processStyles" value="<?php _e('Process Styles', 'photoxhibit'); ?>" />
	<?php else: ?>
		<input type="submit" name="px_processStylesNoneAjax" id="px_processStylesNoneAjax" value="<?php _e('Process Styles', 'photoxhibit'); ?>" />
	<?php endif;?>
	</p>
<textarea style="width:97%;height:300px;" id="px_stylesTextarea" name="px_stylesTextarea"><?php echo $this->cur_gallery_info->gallery_css;?></textarea>
</div>
</form>
<?php
}
?>