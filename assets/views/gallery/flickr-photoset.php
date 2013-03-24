<div class="stuffbox" id="flickr-photoset-panel">
    <form action="" method="post">
        <h3><span><?php _e('Flickr Photoset', 'photoxhibit'); ?></span></h3>
        <div class="inside">
            <div class="action-area">
                <table width="100%" cellpadding="3" cellspacing="3" border="0">
                    <tr>
                        <td width="18%"><?php _e('Flickr Photoset ID', 'photoxhibit'); ?></td>
                        <td width="235"><input type="text" size="30" value="" name="flickr_photoset_id" id="flickr_photoset_id"/></td>
                        <td><?php _e('The photoset id for the Flickr set you want to pull from; if you provided one under "Flickr Params" then just select from the below dropdown', 'photoxhibit'); ?></td>
                    </tr>
                    <tr>
                        <td width="18%"><?php _e('Flickr Stored Photoset ID', 'photoxhibit'); ?></td>
                        <td width="235">
                            <select name="flickr_photoset_id_dd" id="flickr_photoset_id_dd">
                <?php if(isset($this['options']['flickr_photoset_id'])):?>
                                <option selected="selected"></option>
                <?php
                    $flickr_photoset_id = explode(',', $this['options']['flickr_photoset_id']); 
                    while(list($key,$value) = each($flickr_photoset_id)){?>
                                <option value="<?php echo trim($value);?>"><?php echo trim($value);?></option>
                <?php }?>
                <?php else:?>
                                <option selected="selected"><?php _e('No Photoset ID stored', 'photoxhibit'); ?></option>
                <?php endif;?>
                            </select>
                        </td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <div class="action-button">
                <?php echo submit_button("Next Step", "primary", "flickr-photoset-btn", false);?>
                <?php echo submit_button("Previous Step", "secondary", "previous-btn", false, array("id"=>"flickr-photoset-previous-btn","previous"=>"flickr-initial-panel"));?>
            </div>
        </div>
    </form>
</div>