<?php
/*
Plugin Name: Google Maps WordPress Store Locator
Plugin URI: http://www.viadat.com/store-locator/
Description: A full-featured map maker & location management interface for creating WordPress store locators and address location maps using Google Maps, featuring several addons & themes.  Manage a few or thousands of locations effortlessly with setup in minutes.
Version: 3.98.2
Author: Viadat Creations
Author URI: http://www.viadat.com
Text Domain: store-locator
Domain Path: /sl-admin/languages/
License: GPLv3

Google Maps WordPress Store Locator
Copyright (C) 2008 - 2016 Viadat Creations | info [at] viadat.com

This program is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 3 of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.

You should have received a copy of the GNU General Public License along with this program; if not, see <http://www.gnu.org/licenses>.
*/

$sl_version="3.98.2";
define('SL_VERSION', $sl_version);
$sl_db_version=3.0;
include_once("sl-define.php");
include_once(SL_INCLUDES_PATH."/copyfolder.lib.php");

add_action('admin_menu', 'sl_add_options_page');
add_action('wp_head', 'sl_head_scripts', 1001);


include_once("sl-functions.php");
include_once(SL_INCLUDES_PATH."/via-latest.php");
include_once(SL_INCLUDES_PATH."/update-keys.php");

register_activation_hook( __FILE__, 'sl_install_tables');

add_action('the_content', 'sl_template');
	
if (preg_match("@$sl_dir@", $_SERVER['REQUEST_URI'])) {
	add_action("admin_print_scripts", 'sl_add_admin_javascript');
	add_action("admin_print_styles",'sl_add_admin_stylesheet');
}
load_plugin_textdomain("store-locator", "", "../uploads/sl-uploads/languages/");

//add_filter('option_update_plugins', 'sl_plugin_prevent_upgrade');
//add_filter('transient_update_plugins', 'sl_plugin_prevent_upgrade');

function sl_plugin_prevent_upgrade($opt) {
	global $update_class;
	$plugin = plugin_basename(__FILE__);
	if ( $opt && isset($opt->response[$plugin]) ) {
		//Theres an update. Remove automatic upgrade:
		//$opt->response[$plugin]->package = '';
		//Show div update class
		$update_class="update-message";
		//Now we've prevented the upgrade taking place, It might be worth to give users a note that theres an update available:
		//add_action("after_plugin_row_$plugin", 'sl_plugin_update_disabled_notice');
	}
	return $opt;
}

function sl_update_db_check() {
    global $sl_db_version;
    if (sl_data('sl_db_version') != $sl_db_version) {
        sl_install_tables();
    }
}
add_action('plugins_loaded', 'sl_update_db_check');

/*add_action('activated_plugin','save_error');
function save_error(){
    update_option('plugin_error',  ob_get_contents());
}*/
?>