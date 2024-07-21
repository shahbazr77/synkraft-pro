<?php /**
 * Plugin Name: Synkraft Email Verification Pro
 * Plugin URI: https://synkemailverifypro/
 * Description: This plugin is essential for configure email for singup verification.
 * Version: 0.01
 * Author: Email Verification, Emails, Verification
 * Author URI: https://synkemailverifypro/
 * Text Domain: synkeverifypro
 * Requires at least:Synk_Email_Admin_main
 * Requires PHP:synk_email_settings_fun
 */

//Exit if accessed directly
if(!defined('ABSPATH')){
    return;
}
define("SYNKEmail_Verify_Pro_PATH", plugin_dir_path(__FILE__));
define("SYNKEmail_Verify_Pro_URL", plugins_url('',__FILE__));
define("SYNKEmail_Verify_Pro_VERSION",0.01);

class Synkraft_Email_Verify_Pro{
    protected static $instance = null;

    //Get instance
    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct(){
        $this->synkemail_verify_load_file_pro();
    }
    public function synkemail_verify_load_file_pro(){
        require_once SYNKEmail_Verify_Pro_PATH.'/classes/inc/class-synkemail-verify-scripts-pro.php';
        Synk_Email_Verify_Scripts_Pro::get_instance();
         require_once SYNKEmail_Verify_Pro_PATH.'/classes/inc/class-synkemail-core-functions-pro.php';
         Synk_Email_Core_Functions_Pro::get_instance();
        require_once SYNKEmail_Verify_Pro_PATH.'/classes/inc/class-synkemail-verify-disable-user-pro.php';
        Synk_Email_Disable_User_Pro::get_instance();
        require_once SYNKEmail_Verify_Pro_PATH.'/classes/inc/class-synkemail-support-fun-pro.php';
        SYNK_Email_Support_Function_Pro::get_instance();
        require_once SYNKEmail_Verify_Pro_PATH.'/classes/inc/synk-email-actions-pro.php';
        SYNK_Email_Actions_Function_Pro::get_instance();
    }
}

Synkraft_Email_Verify_Pro::get_instance();

