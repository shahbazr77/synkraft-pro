<?php 
/**
 * Plugin Name: Synkraft Pro
 * Plugin URI: https://synkraft-pro/
 * Description: This plugin is Synkraft Pro Plugin.
 * Version: 0.01
 * Requires at least:  5.2
 * Requires PHP: 7.2
 * Author: Yodo Developers
 * Author URI: https://synkraft-pro/
 * Text Domain: synkraftpro
 */

//Exit if accessed directly
if(!defined('ABSPATH')){
    return;
}
define('Pro_SYNKRAFT_Plugin_Path', plugin_dir_path(__FILE__));
define('Pro_SYNKRAFT_Plugin_Url', plugin_dir_url(__FILE__));
define("Pro_SYNKRAFT_Plugin_VERSION",0.01);


class Pro_Synkraft_Main
{
    public static $instance=null;
    //Get instance
    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
        add_action('plugins_loaded', array($this,'pro_synkraft_framework_load_plugin_textdomain'));
        add_action('admin_init',array($this,'synk_check_free_activation'));
        register_activation_hook(__FILE__,array($this,'synkraft_pro_plugin_create_table'));
         if (in_array('synkraft-pro/synkraft-pro.php', apply_filters('active_plugins', get_option('active_plugins')))) {
             require_once Pro_SYNKRAFT_Plugin_Path . '/classes/class-synk-endpoint-callback-pro.php';
             PRO_SYNK_Endpoint_Callback::get_instance();
             require_once Pro_SYNKRAFT_Plugin_Path . '/classes/class-synk-support-pro.php';
             SYNK_Support_Function_pro::get_instance();
         }
      //  register_activation_hook(__FILE__,array($this,'pro_synkraft_plugin_create_table'));
        register_uninstall_hook(__FILE__,'pro_synkraft_plugin_drop_table');
        function pro_synkraft_plugin_drop_table(){
            global $wpdb;
            $table_name_main = $wpdb->prefix . 'synkraft_plugin_settings';
            $wpdb->query("DROP TABLE IF EXISTS $table_name_main");

        }

    }

    function pro_synkraft_framework_load_plugin_textdomain(){
        load_plugin_textdomain( 'synkraftpro', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
    }

    function synk_check_free_activation() {
        if (!class_exists('Synkraft_Main')) {
            deactivate_plugins(plugin_basename(__FILE__));
            add_action('admin_notices',array($this,'synkraft_active_plugins_for_pro'));
        }
    }
    function synkraft_active_plugins_for_pro() {
        $plugin_name = 'Synkraft';
        ?>
        <div class="notice notice-error">
            <p><?php echo esc_html(sprintf('%s plugin requires Synkraft Pro plugin to be installed and activated.', $plugin_name)); ?></p>
        </div>
        <?php
    }

    function synkraft_pro_plugin_create_table() {
        global $wpdb;
        $table_name_main = $wpdb->prefix.'synkraft_plugin_settings';
        // Create the table SQL statement
        $sql_primary = "CREATE TABLE IF NOT EXISTS $table_name_main (
            id INT(11) NOT NULL AUTO_INCREMENT,
            wp_user_id INT(11) NOT NULL,
            api_user_id INT(11) NOT NULL,
            api_secert_key TEXT(255) NOT NULL,
            api_email VARCHAR(255) NOT NULL,
            api_is_active INT(11) NOT NULL,
            PRIMARY KEY (id)
        )";
        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
        dbDelta( $sql_primary );

    }


}
Pro_Synkraft_Main::get_instance();