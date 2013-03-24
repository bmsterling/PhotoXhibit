<?php
/*
    Plugin Name: PhotoXhibit
    Plugin URI: http://benjaminsterling.com/photoxhibit/
    Description: Set up gallery widgets using Picasa / Flickr / Wordpress and jQuery
    Author: Benjamin Sterling
    Version: 3.0
    Author URI: http://www.benjaminsterling.com

    Copyright (C)  2013 by Benjamin Sterling & PhotoXhibit Development Team

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
// require('assets/class/PhotoXhibit.php');
global $px;

// set up autoloader
function photoXhibit_autoload($class) {
    $file = plugin_dir_path(__FILE__) . 'assets/classes/' . $class . '.php';
    
    // make sure we are loading something since the autoloader will 
    // loop through all the autoloaders till successfull
    if ( file_exists ($file) ) {
        include 'assets/classes/' . $class . '.php';
    }
}

// register autoloader
spl_autoload_register ('photoXhibit_autoload');

$px = new PhotoXhibit(__FILE__);
?>
