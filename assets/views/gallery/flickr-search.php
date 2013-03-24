<div class="stuffbox" id="flickr-search-panel">
    <form action="" method="post">
        <h3><span><?php _e('Flickr Search', 'photoxhibit'); ?></span></h3>
        <div class="inside">
            <div class="action-area">
                <table width="100%" cellpadding="3" cellspacing="3" border="0">
                    <tr>
                        <td width="18%"><?php _e('Flickr User ID', 'photoxhibit'); ?></td>
                        <td width="235"><input type="text" size="30" value="" name="flickr_user_id" id="flickr_user_id"/></td>
                        <td><?php _e('The userid for the Flickr account you want to pull from; if you provided one under "Flickr Params" then just select from the below dropdown', 'photoxhibit'); ?></td>
                    </tr>
                    <tr>
                        <td width="18%"><?php _e('Flickr Stored User ID', 'photoxhibit'); ?></td>
                        <td width="235">
                            <select name="flickr_user_id_dd" id="flickr_user_id_dd">
                <?php if(isset($this['options']['flickr_user_id'])):?>
                                <option selected="selected"></option>
                <?php
                    $flickr_user_id = explode(',', $this['options']['flickr_user_id']); 
                    while(list($key,$value) = each($flickr_user_id)){?>
                                <option value="<?php echo trim($value);?>"><?php echo trim($value);?></option>
                <?php }?>
                <?php else:?>
                                <option selected="selected"><?php _e('No User ID stored', 'photoxhibit'); ?></option>
                <?php endif;?>
                            </select>
                        </td>
                        <td></td>
                    </tr>

                    <tr>
                        <td width="18%"><?php _e('Flickr Group ID', 'photoxhibit'); ?></td>
                        <td width="235"><input type="text" size="30" value="" name="flickr_group_id" id="flickr_group_id"/></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td width="18%"><?php _e('Flickr Tags', 'photoxhibit'); ?></td>
                        <td width="235"><input type="text" size="30" value="" name="flickr_tags" id="flickr_tags"/></td>
                        <td><?php _e('Comma separated tag list', 'photoxhibit'); ?></td>
                    </tr>

                    <tr>
                        <td width="18%"><?php _e('Flickr Tag Mode', 'photoxhibit'); ?></td>
                        <td width="235">
                            <select name="flickr_tag_mode" id="flickr_tag_mode">
                                <option value="" selected="selected"></option>
                                <option value="any"><?php _e('Any (or)', 'photoxhibit'); ?></option>
                                <option value="all"><?php _e('All (and)', 'photoxhibit'); ?></option>
                            </select>
                        </td>
                        <td></td>
                    </tr>

                    <tr>
                        <td width="18%"><?php _e('Flickr Sort Option', 'photoxhibit'); ?></td>
                        <td width="235">
                            <select name="flickr_sort" id="flickr_sort">
                                <option value="" selected="selected"></option>
                                <option value="date-posted-asc"><?php _e('Date Posted Ascending', 'photoxhibit'); ?></option>
                                <option value="date-posted-desc"><?php _e('Date Posted Descending', 'photoxhibit'); ?></option>
                                <option value="date-taken-asc"><?php _e('Date Taken Ascending', 'photoxhibit'); ?></option>
                                <option value="date-taken-desc"><?php _e('Date Taken Descending', 'photoxhibit'); ?></option>
                                <option value="interestingness-asc"><?php _e('Interestingness Ascending', 'photoxhibit'); ?></option>
                                <option value="interestingness-desc"> <?php _e('Interestingness Descending', 'photoxhibit'); ?></option>
                                <option value="relevance"><?php _e('Relevance', 'photoxhibit'); ?></option>
                            </select>
                        </td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <div class="action-button">
                <?php echo submit_button("Next Step", "primary", "flickr-search-btn", false);?>
                <?php echo submit_button("Previous Step", "secondary", "previous-btn", false, array("id"=>"flickr-search-previous-btn","previous"=>"flickr-initial-panel"));?>
            </div>
        </div>
    </form>
</div>