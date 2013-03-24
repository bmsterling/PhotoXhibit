<div class="stuffbox" id="flickr-initial-panel">
    <form action="" method="post">
        <h3><span><?php _e('Flickr', 'photoxhibit'); ?></span></h3>
        <div class="inside">
            <div class="action-area">
                <table width="100%" cellpadding="3" cellspacing="3" border="0">
                    <tr class="">
                        <td width="18%"><?php _e('What Options?', 'photoxhibit'); ?></td>
                        <td width="235">
                            <select name="flickrOptions" id="flickrOptions">
                                <option selected="selected"></option>
                                <option value="flickrBasic"><?php _e('Basic', 'photoxhibit'); ?></option>
                                <!--<option value="flickrQuickAdvanced"><?php _e('Quick Advanced', 'photoxhibit'); ?></option>-->
                                <option value="flickrPhotoset"><?php _e('Advanced Photoset', 'photoxhibit'); ?></option>
                                <option value="flickrSearch"><?php _e('Advanced Search', 'photoxhibit'); ?></option>
                            </select>
                        </td>
                        <td>
                            <?php _e('Select the set of flickr options you would like to work with', 'photoxhibit'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <?php _e('For Flickr you have three options:', 'photoxhibit'); ?>
                            <ol>
                                <li><?php _e('Basic will bring you to a frame that you can enter your Flickr RSS feed into.', 'photoxhibit'); ?></li>
                                <li><?php _e('Advance Photoset will bring you to a frame where you will be able to enter the ID to the photoset you want to grab images from.', 'photoxhibit'); ?></li>
                                <li><?php _e('Advanced Search will bring you to a frame where you will be able to enter a USER ID, a Group ID, and/or Tags to grab images from.', 'photoxhibit'); ?></li>
                            </ol>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="action-button">
                <?php echo submit_button("Next Step", "primary", "flickr-initial-btn", false);?>
                <?php echo submit_button("Previous Step", "secondary", "previous-btn", false, array("id"=>"flickr-initial-previous-btn","previous"=>"select-service-panel"));?>
            </div>
        </div>
    </form>
</div>