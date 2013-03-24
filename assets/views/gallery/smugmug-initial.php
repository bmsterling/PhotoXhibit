<div class="stuffbox" id="smugmug-initial-panel">
    <form action="" method="post">
        <h3><span><?php _e('Smugmug', 'photoxhibit'); ?></span></h3>
        <div class="inside">
            <div class="action-area">
            
                <table width="100%" cellpadding="3" cellspacing="3" border="0">
                    <tr>
                        <td width="18%"><?php _e('SmugMug User ID', 'photoxhibit'); ?></td>
                        <td width="235"><input type="text" size="30" value="" name="smugmug_user_id" id="smugmug_user_id"/></td>
                        <td><?php _e('if you provided one under "SmugMug Params" then just select from the below dropdown.', 'photoxhibit'); ?></td>
                    </tr>
                    <tr>
                        <td width="18%"><?php _e('SmugMug Stored User ID', 'photoxhibit'); ?></td>
                        <td width="235">
                            <select name="smugmug_user_id_dd" id="smugmug_user_id_dd">
                <?php if(isset($this['options']['smugmug_user_id'])):?>
                                <option selected="selected"></option>
                <?php 
                $smugmug_user_id = explode(',', $this['options']['smugmug_user_id']);
                while(list($key,$value) = each($smugmug_user_id)){?>
                                <option value="<?php echo trim($value);?>"><?php echo trim($value);?></option>
                <?php }?>
                <?php else:?>
                                <option selected="selected"><?php _e('No User IDs stored', 'photoxhibit'); ?></option>
                <?php endif;?>
                            </select>
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="18%"><?php _e('SmugMug Album ID', 'photoxhibit'); ?></td>
                        <td width="235"><input type="text" size="30" value="" name="smugmug_album_id" id="smugmug_album_id"/></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td width="18%" class="submit">
                            <?php echo submit_button("Grab", "secondary", "px_smugmugAlbum_grab", false);?>
                        </td>
                        <td width="235">
                            <select name="smugmug_album_id_dd" id="smugmug_album_id_dd">
                                <option selected="selected"></option>
                            </select>
                        </td>
                        <td id="px_smugmugAlbum_grab_notice">
                            <div id="smugmug-start"><?php _e('Finding SmugMug Albums for that ID', 'photoxhibit');?></div>
                            <div id="smugmug-build"><?php _e('Ok, got them, now building the dropdown.','photoxhibit');?></div>
                            <div id="smugmug-done"><?php _e('Ok, Done!  Just to note, depending on the browser, the last one added may be the one that gets selected.  So be sure to select the one you want.', 'photoxhibit');?></div>
                        </td>
                    </tr>
                </table>
            
            </div>
            <div class="action-button">
                <?php echo submit_button("Next Step", "primary", "smugmug-initial-btn", false);?>
                <?php echo submit_button("Previous Step", "secondary", "previous-btn", false, array("id"=>"smugmug-initial-previous-btn","previous"=>"select-service-panel"));?>
            </div>
        </div>
    </form>
</div>