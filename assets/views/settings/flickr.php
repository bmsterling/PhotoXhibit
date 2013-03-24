<h2><?php _e('Flickr', 'photoxhibit'); ?></h2>
<div class="content">
    <table class="form-table">
        <tr>
            <th scope="row"><?php _e('Flickr Userid', 'photoxhibit'); ?></th>
            <td>
                <input type="text" size="30" value="<?php echo $this['flickr_user_id'];?>" name="flickr_user_id" id="flickr_user_id"/>
                <p class="description"><?php _e('The userid for the Flickr account you want to pull from; you can enter multiple USERIDes but they must be separated by a comma. (eg: userid#1, userid#2)  You must obtain an API if you want to pull via user id.', 'photoxhibit'); ?></p></td>
        </tr>
        <tr>
            <th scope="row"><?php _e('Photoset ID', 'photoxhibit'); ?></th>
            <td><input type="text" size="30" value="<?php echo $this['flickr_photoset_id'];?>" name="flickr_photoset_id" id="flickr_photoset_id"/>
            
            <p class="description"><?php _e('If there are certain sets you want to pull from mutliple times, post those ids here separated by a comma.    You must obtain an API if you want to pull via photoset id.', 'photoxhibit'); ?></p>
            </td>
            
        </tr>
    </table>
</div>