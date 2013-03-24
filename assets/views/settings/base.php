<div class="wrap settings-wrap" id ="">
    <form action="<?php echo admin_url('admin.php?page=photoxhibit-settings');?>" method="post">
        <h2><?php _e('PhotoXhibit Settings', 'photoxhibit'); ?></h2>
        
        <?php if (!empty($_POST)) : ?>
        <div id="message" class="updated below-h2">
            <p>
                <?php _e('Settings updated.', 'photoxhibit'); ?>
            </p>
        </div>
        <?php endif; ?>
        
        <div class="tabs" id="settings">
            <ul>
                <li><a href="#fragment-1">Basics</a></li>
                <li><a href="#fragment-2">Services</a></li>
                <li><a href="#fragment-3">Flickr</a></li>
                <li><a href="#fragment-4">Picasa</a></li>
                <li><a href="#fragment-5">SmugMug</a></li>
                <li><a href="#fragment-6">Album</a></li>
            </ul>
            
            <div class="tab" id="fragment-1">
                <?php echo $this['basics'];?>
            </div>
            <div class="tab" id="fragment-2">
                <?php echo $this['services'];?>
            </div>
            <div class="tab" id="fragment-3">
                <?php echo $this['flickr'];?>
            </div>
            <div class="tab" id="fragment-4">
                [discontinued]
            </div>
            <div class="tab" id="fragment-5">
                <?php echo $this['smugmug'];?>
            </div>
            <div class="tab" id="fragment-6">
                <?php echo $this['album'];?>
            </div>
            
        </div>
        
        <?php echo submit_button();?>
    </form>
</div>