<div class="wrap settings-wrap" id ="">
    <h2><?php _e('PhotoXhibit Galleries', 'photoxhibit'); ?></h2>
    
    <table class="wp-list-table widefat fixed posts">
        <thead>
            <tr>
                <th scope="col" id="" class="manage-column column-cb check-column">
                    <label class="screen-reader-text" for="cb-select-all-1">Select All</label>
                    <input id="cb-select-all-1" type="checkbox">
                </th>
                <th scope="col" id="id" class="manage-column column-id sortable">
                    <a href="">
                        <span><?php _e('ID', 'photoxhibit'); ?></span>
                        <span class="sorting-indicator"></span>
                    </a>
                </th>
                <th scope="col" id="title" class="manage-column column-title sortable">
                    <a href="">
                        <span><?php _e('Title', 'photoxhibit'); ?></span>
                        <span class="sorting-indicator"></span>
                    </a>
                </th>
                <th scope="col" id="code" class="manage-column column-code">
                    <?php _e('Code', 'photoxhibit'); ?>
                </th>
                <th scope="col" id="type" class="manage-column column-type">
                    <?php _e('Type', 'photoxhibit'); ?>
                </th>
                <th scope="col" id="styles" class="manage-column column-styles">
                    <?php _e('Edit Styles', 'photoxhibit'); ?>
                </th>
                <th scope="col" id="images" class="manage-column column-images">
                    <?php _e('Edit Images', 'photoxhibit'); ?>
                </th>
                <th scope="col" id="delete" class="manage-column column-delete">
                    <?php _e('Delete', 'photoxhibit'); ?>
                </th>
            </tr>
        </thead>
        
        <?php 
        if ($this['galleries']) {
            $i = 0;
            foreach ($this['galleries'] as $gallery) {
                if ($i%2 == 0) {
                    $cls = "alternate";
                }
                else {
                    $cls = "";
                }
                
                echo '<tr class="'.$cls.'">';
                    echo '<th scope="row" class="check-column">';
                    echo '<label class="screen-reader-text" for="cb-select-'.$gallery->gallery_id.'">Select '.$gallery->gallery_title.'</label>';
                    echo '<input id="cb-select-'.$gallery->gallery_id.'" type="checkbox" name="gallery[]" value="'.$gallery->gallery_id.'">';
                    echo '</th>';
                    echo '<td>'.$gallery->gallery_id.'</td>';
                    echo '<td><a href="';
                    echo admin_url('admin.php?page=photoxhibit-edit&action=edit&gid='.$gallery->gallery_id);
                    echo '">'.$gallery->gallery_title.'</a>';
                    echo '</td>';
                    echo '<td><input type="text" readonly value="[photoxhibit=' . $gallery->gallery_id.']"/></td>';
                    echo '<td>';
                    echo '<a href="'.$gallery->plugin_example.'" target="_blank" title="example">'.$gallery->plugin_title.' (' . __('new window', 'photoxhibit') . ')</a>';
                    echo '</td>';
                    echo '<td><a href="';
                    echo admin_url('admin.php?page=photoxhibit-edit&action=edit_styles&gid='.$gallery->gallery_id);
                    echo '">'.__('Edit Styles', 'photoxhibit').'</a>';
                    echo '</td>';
                    echo '<td><a href="';
                    echo admin_url('admin.php?page=photoxhibit-edit&action=edit_image_attr&gid='.$gallery->gallery_id);
                    echo '">'.__('Edit Images', 'photoxhibit').'</a>';
                    echo '</td>';
                    echo '<td><a href="';
                    echo admin_url('admin.php?page=photoxhibit-edit&action=delete&gid='.$gallery->gallery_id);
                    echo '">'.__('Delete', 'photoxhibit').'</a>';
                    echo '</td>';
                echo '</tr>';
            }
        }
        else {
            echo '<tr><td colspan="8" align="center"><strong>' . __('No Galleries Found', 'photoxhibit') .'</strong></td></tr>';
            
        }
        ?>
    </table>
    
</div>