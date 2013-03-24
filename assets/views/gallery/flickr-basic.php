<div class="stuffbox" id="flickr-basic-panel">
    <form action="" method="post">
        <h3><span><?php _e('Flickr Basic', 'photoxhibit'); ?></span></h3>
        <div class="inside">
            <div class="action-area">
                <table width="100%" cellpadding="3" cellspacing="3" border="0">
                    <tr>
                        <td width="18%"><?php _e('Your Flickr URL', 'photoxhibit'); ?></td>
                        <td width="235"><input type="text" size="30" value="" name="flickr-basic-url" id="flickr-basic-url"/></td>
                        <td><?php _e('Input the URL for the RSS feed for your Flickr account', 'photoxhibit'); ?></td>
                    </tr>
                </table>
            </div>
            <div class="action-button">
                <?php echo submit_button("Next Step", "primary", "flickr-basic-btn", false);?>
                <?php echo submit_button("Previous Step", "secondary", "previous-btn", false, array("id"=>"flickr-basic-previous-btn","previous"=>"flickr-initial-panel"));?>
            </div>
        </div>
    </form>
</div>