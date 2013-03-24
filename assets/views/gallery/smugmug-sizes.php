<div class="stuffbox">
    <form action="" method="post">
        <h3><span><?php _e('Smugmug Sizes', 'photoxhibit'); ?></span></h3>
        <div class="inside">
            <div class="action-area">
            
                <table width="100%" cellpadding="3" cellspacing="3" border="0">
                    <tr class="">
                        <td width="18%"><?php _e('Select a thumbnail size for SmugMug', 'photoxhibit'); ?></td>
                        <td width="235">
                            <select name="px_smugMugThumbnailSelect" id="px_smugMugThumbnailSelect">
                                <option value="0">(<?php _e('up to 100 px up to 100px', 'photoxhibit'); ?>)</option>
                                <option value="1">(<?php _e('up to 150 px up to 150px', 'photoxhibit'); ?>)</option>
                                <option value="2">(<?php _e('up to 400 px up to 300px', 'photoxhibit'); ?>)</option>
                                <option value="3">(<?php _e('up to 600 px up to 450px', 'photoxhibit'); ?>)</option>
                                <option value="4">(<?php _e('up to 800 px up to 600px', 'photoxhibit'); ?>)</option>
                                <option value="5">(<?php _e('up to 1024 px up to 768px', 'photoxhibit'); ?>)</option>
                            </select>
                        </td>
                        <td>
                            <?php _e('Select the size of the thumbnail you want to display below.  This thumbnail size will also be used for the gallery you will choose.', 'photoxhibit'); ?>
                        </td>
                    </tr>
                    <tr class="">
                        <td width="18%">Select a full size for SmugMug', 'photoxhibit'); ?></td>
                        <td width="235">
                            <select name="px_smugMugFullSizeSelect">
                                <option value="2">(<?php _e('up to 400 x up to 300', 'photoxhibit'); ?>)</option>
                                <option value="3">(<?php _e('up to 600 x up to 450', 'photoxhibit'); ?>)</option>
                                <option value="4" selected="selected">(<?php _e('up to 800 x up to 600', 'photoxhibit'); ?>)</option>
                                <option value="5">(<?php _e('up to 1024 x up to 768', 'photoxhibit'); ?>)</option>
                            </select>
                        </td>
                        <td>
                            <?php _e('Select the size of the full size image you want to display in the plugin.', 'photoxhibit'); ?>
                        </td>
                    </tr>
                </table>
            
            </div>
            <div class="action-button">
                <?php echo submit_button("Next Step", "primary", "smugmug-sizes-btn", false);?>
            </div>
        </div>
    </form>
</div>