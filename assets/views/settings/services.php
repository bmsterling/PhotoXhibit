<h2><?php _e('Services', 'photoxhibit'); ?></h2>
<div class="content">
    <?php _e('Check the services you want to use:', 'photoxhibit'); ?>
    <table class="form-table">
        <tr>
            <th scope="row"><?php _e('Use Picasa', 'photoxhibit'); ?></th>
            <td>[discontinued]</td>
        </tr>
        <tr>
            <th scope="row"><?php _e('Use Flickr', 'photoxhibit'); ?></th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text"><span><?php _e('Use Flickr', 'photoxhibit'); ?></span></legend>
                    <p>
                        <label for="">
                            <input type="radio" value="1" name="use_flickr" <?php echo ($this['use_flickr']==1)?' checked="checked" ':'';?>/>
                            <?php _e('yes', 'photoxhibit'); ?> 
                        </label>
                        <br/>
                        <label for="">
                            <input type="radio" value="0" name="use_flickr"  <?php echo ($this['use_flickr']==0)?' checked="checked" ':'';?>/>
                            <?php _e('no', 'photoxhibit'); ?>
                        </label>
                    </p>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e('Use SmugMug', 'photoxhibit'); ?></th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text"><span><?php _e('Use SmugMug', 'photoxhibit'); ?></span></legend>
                    <p>
                        <label for="">
                        
                            <input type="radio" value="1" name="use_smugmug" <?php echo ($this['use_smugmug']==1)?' checked="checked" ':'';?>/>
                            <?php _e('yes', 'photoxhibit'); ?>
                        </label>
                        <br/>
                        <label for="">
                            <input type="radio" value="0" name="use_smugmug"  <?php echo ($this['use_smugmug']==0)?' checked="checked" ':'';?>/>
                            <?php _e('no', 'photoxhibit'); ?>
                        </label>
                    </p>
                </fieldset>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e('Use Album', 'photoxhibit'); ?></th>
            <td>[discontinued]
                <p class="description">See album tab for more information</p>
            </td>
        </tr>
        <tr>
            <th scope="row"><?php _e('Use Local', 'photoxhibit'); ?></th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text"><span><?php _e('Use Local', 'photoxhibit'); ?></span></legend>
                    <p>
                        <label for="">
                            <input type="radio" value="1" name="use_local" <?php echo ($this['use_local']==1)?' checked="checked" ':'';?>/>
                            <?php _e('yes', 'photoxhibit'); ?>
                        </label>
                        <br/>
                        <label for="">
                            <input type="radio" value="0" name="use_local"  <?php echo ($this['use_local']==0)?' checked="checked" ':'';?>/>
                            <?php _e('no', 'photoxhibit'); ?>
                        </label>
                    </p>
                </fieldset>
            </td>
        </tr>
    </table>
</div>