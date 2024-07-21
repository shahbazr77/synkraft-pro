<?php
/*
Plugin Name: Synkraft Google reCaptcha Pro
Plugin URI: [Plugin URI]
Description: Adds Google reCaptcha for users while login
Version: 0.01
Author: YODO Developers
Author URI: [Your Author URI]
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: syn-google-captcha-plugin
Requires at least:Recaptcha_Option_Page
Requires PHP:create_admin_page
*/
if(!defined('ABSPATH')){
    return;
}


class Google_Captcha_Main_pro {
  
    public function __construct() {
        // Define constants.
        define('SGR_PLUGIN_DIR_PRO', plugin_dir_path(__FILE__));
        define('SGR_PLUGIN_URL_PRO', plugin_dir_url(__FILE__));


        require_once SGR_PLUGIN_DIR_PRO . 'inc/classes/recaptcha-v2-pro.php';
        $recaptcha_v2_pro = new Recaptcha_V2_PRO();

        require_once SGR_PLUGIN_DIR_PRO . 'inc/classes/recaptcha-v3-pro.php';
        $recaptcha_v3_pro = new Recaptcha_V3_PRO();

        $check_if_woo_is_on =     get_option('enable_captcha_on_login_form');

        if(isset($check_if_woo_is_on) && $check_if_woo_is_on == 'on') {

            $recaptcha_version = get_option('synkraft_google_recaptcha_version');

            if(isset($recaptcha_version) && $recaptcha_version == 'recaptcha_v2') {

                add_action('login_form', array($recaptcha_v2_pro, 'display_recaptcha'));
            }

            if(isset($recaptcha_version) && $recaptcha_version == 'recaptcha_v3') {

                add_action('login_form', array($recaptcha_v3_pro, 'display_recaptcha'));
            }

        }

        // Enqueue scripts.
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_front_scripts'));

        // Localize Ajax URL.
        add_action('admin_enqueue_scripts', array($this, 'recaptcha_localize_ajax_url'));
        add_action('admin_head',  array($this,'custom_admin_styles'));
        add_action('login_enqueue_scripts', array($this, 'custom_login_styles'));
        add_action('admin_footer', array($this, 'load_and_center_recaptcha'));



    }

    public function enqueue_admin_scripts() {
        wp_enqueue_style('admin-captcha-styles', SGR_PLUGIN_URL_PRO . 'assets/css/admin-style.css');
        wp_enqueue_script('admin-captcha-scripts', SGR_PLUGIN_URL_PRO . 'assets/js/admin-scripts.js', array('jquery'), '1.0', true);
    }

    public function enqueue_front_scripts() {
        wp_enqueue_script('user-captcha-scripts', SGR_PLUGIN_URL_PRO . 'assets/js/user-scripts.js', array('jquery'), '1.0', true);
    }

    public function custom_admin_styles() {
        echo '<style>
            #synkraft-recaptcha-container {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh; /* Adjust the height as needed */
            }
            #synkraft-recaptcha-container iframe {
                max-width: 100% !important; /* Ensure the reCAPTCHA doesn\'t exceed the container\'s width */
            }
        </style>';
    }
    
    function custom_login_styles() {
        wp_enqueue_style('custom-login', SGR_PLUGIN_URL_PRO . 'assets/css//custom-login.css');
    }
    

    function load_and_center_recaptcha() {
        // Load the reCAPTCHA script
        echo '<script src="https://www.google.com/recaptcha/api.js?onload=initRecaptcha&render=explicit" async defer></script>';
        
        echo '<script>
            var recaptcha;
            
            function initRecaptcha() {
                // Render the reCAPTCHA inside the container
                recaptcha = grecaptcha.render("synkraft-recaptcha-container", {
                    sitekey: "YOUR_RECAPTCHA_SITE_KEY_HERE",
                    // Add any other reCAPTCHA options you need
                });
    
                // Center the reCAPTCHA
                centerRecaptcha();
            }
    
            function centerRecaptcha() {
                var container = document.getElementById("synkraft-recaptcha-container");
                var iframe = container.querySelector("iframe");
    
                if (container && iframe) {
                    var containerWidth = container.offsetWidth;
                    var iframeWidth = iframe.offsetWidth;
                    var margin = (containerWidth - iframeWidth) / 2;
    
                    iframe.style.marginLeft = margin + "px";
                    iframe.style.marginRight = margin + "px";
                }
            }

            function centerRecaptcha() {
                var container = document.getElementById("synkraft-register-recaptcha-container");
                var iframe = container.querySelector("iframe");
    
                if (container && iframe) {
                    var containerWidth = container.offsetWidth;
                    var iframeWidth = iframe.offsetWidth;
                    var margin = (containerWidth - iframeWidth) / 2;
    
                    iframe.style.marginLeft = margin + "px";
                    iframe.style.marginRight = margin + "px";
                }
            }

        </script>';
    }
    
    public function recaptcha_localize_ajax_url() {
        $ajax_nonce = wp_create_nonce('syn_recaptcha_nonce');

        wp_localize_script('admin-captcha-scripts', 'ajax_object', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => $ajax_nonce,
        ));
    }
}
$google_captcha_main_pro = new Google_Captcha_Main_pro();