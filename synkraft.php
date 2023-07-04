<?php /**
 * Plugin Name: Synkraft
 * Plugin URI: https://synkraft/
 * Description: This plugin is essential for configure elementor.
 * Version: 0.01
 * Requires at least:  5.2
 * Requires PHP: 7.2
 * Author: Yodo Developers
 * Author URI: https://synkraft/
 * Text Domain: synkraft
 */

//Exit if accessed directly
if(!defined('ABSPATH')){
    return;
}
define('SYNKRAFT_Plugin_Path', plugin_dir_path(__FILE__));
define('SYNKRAFT_Plugin_Url', plugin_dir_url(__FILE__));
define("SYNKRAFT_Plugin_VERSION",0.01);


/*Load text domain*/
add_action( 'plugins_loaded', 'synkraft_framework_load_plugin_textdomain',999 );
function synkraft_framework_load_plugin_textdomain()
{
    load_plugin_textdomain( 'synkraft', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}

if (in_array('synkraft/synkraft.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    require_once SYNKRAFT_Plugin_Path.'/classes/inc/class-synk-admin-menu.php';
    //Start the plugin
    SYNK_Register_Menu::get_instance();

}

