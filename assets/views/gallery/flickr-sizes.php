<div class="stuffbox" id="flickr-size-panel">
    <form action="" method="post">
        <h3><span><?php _e('Flickr Sizes', 'photoxhibit'); ?></span></h3>
        <div class="inside">
            <div class="action-area">
                <table width="100%" cellpadding="3" cellspacing="3" border="0">
                    <tr class="">
                        <td width="18%"><?php _e('Select a thumbnail size for Flickr', 'photoxhibit'); ?></td>
                        <td width="235">
                            <select name="bsg_flickr_thumbnailSelect" id="bsg_flickr_thumbnailSelect">
                                <option value="_s"><?php _e('Square', 'photoxhibit'); ?></option>
                                <option value="_q"><?php _e('Large Square', 'photoxhibit'); ?></option>
                                <option value="_t"><?php _e('Thumbnail', 'photoxhibit'); ?></option>
                                <option value="_m"><?php _e('Small', 'photoxhibit'); ?></option>
                                <option value="_n"><?php _e('Small 320', 'photoxhibit'); ?></option>
                                <option value=""  ><?php _e('Medium', 'photoxhibit'); ?></option>
                                <option value="_z"><?php _e('Medium 640', 'photoxhibit'); ?></option>
                                <option value="_c"><?php _e('Medium 800', 'photoxhibit'); ?></option>
                                <option value="_b"><?php _e('Large', 'photoxhibit'); ?></option>
                            </select>
                        </td>
                        <td>
                            <?php _e('Select the size of the thumbnail you want to display below.  This thumbnail size will also be used for the gallery you will choose.  The large option is only available from flickr if the original is very large.', 'photoxhibit'); ?>
                        </td>
                    </tr>
                    <tr class="">
                        <td width="18%"><?php _e('Select a Large size for Flickr', 'photoxhibit'); ?></td>
                        <td width="235">
                            <select name="px_flickr_largeSelect" id="px_flickr_largeSelect">
                                <option value="_m"><?php _e('Small', 'photoxhibit'); ?></option>
                                <option value="_n"><?php _e('Small 320', 'photoxhibit'); ?></option>
                                <option value=""  ><?php _e('Medium', 'photoxhibit'); ?></option>
                                <option value="_z"><?php _e('Medium 640', 'photoxhibit'); ?></option>
                                <option value="_c"><?php _e('Medium 800', 'photoxhibit'); ?></option>
                                <option value="_b"><?php _e('Large', 'photoxhibit'); ?></option>
                            </select>
                        </td>
                        <td>
                        <?php _e('The large option is only available from flickr if the original is very large.', 'photoxhibit'); ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="action-button">
                <?php echo submit_button("Next Step", "primary", "flickr-size-btn", false);?>
                <?php echo submit_button("Previous Step", "secondary", "previous-btn", false, array("id"=>"flickr-basic-previous-btn","previous"=>""));?>
            </div>
        </div>
    </form>
</div>