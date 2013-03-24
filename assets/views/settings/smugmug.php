<h2><?php _e('SmugMug', 'photoxhibit'); ?></h2>
<div class="content">

    <table class="form-table">
        <tr>
            <th scope="row"><?php _e('SmugMug Userid', 'photoxhibit'); ?></th>
            <td width="235">
                <input type="text" size="30" value="<?php echo $this['smugmug_user_id'];?>" name="smugmug_user_id" id="smugmug_user_id"/>
                <p class="description"><?php _e('The userid for the SmugMug account you want to pull from; you can enter multiple USERIDes but they must be separated by a comma. (eg: userid#1, userid#2)', 'photoxhibit'); ?></p>
            </td>
        </tr>
    </table>
</div>