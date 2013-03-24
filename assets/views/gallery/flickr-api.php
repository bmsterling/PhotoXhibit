<div class="stuffbox" id="flickr-api-panel>
    <form action="" method="post">
        <h3><span><?php _e('Flickr API', 'photoxhibit'); ?></span></h3>
        <div class="inside">
            <div class="action-area">
                <table width="100%" cellpadding="3" cellspacing="3" border="0">
                    <tr>
                        <td width="18%">Flickr API Key</td>
                        <td width="235"><input type="text" size="30" value="" name="flickr_api_key" id="flickr_api_key"/></td>
                        <td>Get your <a href="http://www.flickr.com/services/api/keys/apply/" target="_blank">Flickr Services API Key</a>; if you provided one under "Flickr Params" then just select from the below dropdown.</td>
                    </tr>
                    <tr>
                        <td width="18%">Flickr Stored API Keys</td>
                        <td width="235">
                            <select name="flickr_api_key_dd" id="flickr_api_key_dd">
                <?php if(isset($this['options']['flickr_api_key'])):?>
                                <option selected="selected"></option>
                <?php 
                $flickr_api_key = explode(',', $this['options']['flickr_api_key']);
                while(list($key,$value) = each($flickr_api_key)){?>
                                <option value="<?php echo trim($value);?>"><?php echo trim($value);?></option>
                <?php }?>
                <?php else:?>
                                <option selected="selected">No API Keys stored</option>
                <?php endif;?>
                            </select>
                        </td>
                        <td></td>
                    </tr>
                </table>
            </div>
            <div class="action-button">
                <?php echo submit_button("Next Step", "primary", "flickr-api-btn", false);?>
                <?php echo submit_button("Previous Step", "secondary", "previous-btn", false, array("id"=>"flickr-api-previous-btn","previous"=>"select-service-panel"));?>
            </div>
        </div>
    </form>
</div>