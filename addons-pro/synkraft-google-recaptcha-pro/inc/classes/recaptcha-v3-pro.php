<?php
/**
** Recaptcha_V3_PRO
**/
if(!defined('ABSPATH')){
    return;
}

class Recaptcha_V3_PRO {

    public function __construct(){
        
        $check_if_woo_is_on =     get_option('enable_captcha_on_woo_checkout');
        $show_on_woo_login = get_option( 'enable_captcha_on_woo_login_form' );
        $show_on_woo_login_signup = get_option( 'check_woo_account_status' );
        $show_on_wp_signup_form = get_option( 'enable_captcha_on_signup_wp_form' );
       
        // update_option('enable_captcha_on_signup_wp_form', $check_wp_signup_status);


        if(isset($check_if_woo_is_on) & $check_if_woo_is_on == 'on') {
            add_action('woocommerce_review_order_before_submit', array($this, 'display_recaptcha_v3_before_place_order_button'));
        }
        //woocoommerce login page
        if(isset($show_on_woo_login_signup) && $show_on_woo_login_signup  == 'login') {

            add_action('woocommerce_login_form', array($this, 'display_recaptcha_v3_on_login_form'));
        }
        //woocoommerce signup page
        
        if(isset($show_on_woo_login_signup) && $show_on_woo_login_signup  == 'signup') {

            add_action('woocommerce_register_form', array($this,  'display_recaptcha_v3_on_registration_form'));
        }
        
        //wordpress signup form
        if(isset($show_on_wp_signup_form) && $show_on_wp_signup_form  == 'on') {

                add_action('register_form', array($this, 'display_recaptcha_v3_on_wp_registration_form'));
        }

    }
    public function display_recaptcha() {
        $recaptcha_version = get_option('synkraft_google_recaptcha_version');
        

        if ( $recaptcha_version === 'recaptcha_v3' ) {
            $recaptcha_v3_site_key =    get_option('synkraft_google_recaptcha_v3_key');


            echo '<script src="https://www.google.com/recaptcha/api.js?render=' . esc_attr( $recaptcha_v3_site_key ) . '"></script>';
            echo '<input type="hidden" id="recaptcha-token" name="recaptcha-token" value="" />';
            echo '<script>
                grecaptcha.ready(function() {
                    grecaptcha.execute("' . esc_js( $recaptcha_v3_site_key ) . '", { action: "login" }).then(function(token) {
                        document.getElementById("recaptcha-token").value = token;
                    });
                });
            </script>';
        }
    }

    function display_recaptcha_v3_before_place_order_button()
    {
        $recaptcha_version = get_option('synkraft_google_recaptcha_version');
        if ($recaptcha_version === 'recaptcha_v3') {


            // Get the Recaptcha V2 site key from your plugin settings or replace it with your actual site key.
            $recaptcha_v3_site_key = get_option('synkraft_google_recaptcha_v3_key');


            echo '<script src="https://www.google.com/recaptcha/api.js?render=' . esc_attr($recaptcha_v3_site_key) . '"></script>';
            echo '<input type="hidden" id="recaptcha-token" name="recaptcha-token" value="" />';
            echo '<script>
                    grecaptcha.ready(function() {
                        grecaptcha.execute("' . esc_js($recaptcha_v3_site_key) . '", { action: "login" }).then(function(token) {
                            document.getElementById("recaptcha-token").value = token;
                        });
                    });
            </script>';
        }
    }

    public function display_recaptcha_v3_on_login_form() {
        $recaptcha_version = get_option('synkraft_google_recaptcha_version');

        if ($recaptcha_version === 'recaptcha_v3') {
            $recaptcha_v3_site_key = get_option('synkraft_google_recaptcha_v3_key');

            echo '<script src="https://www.google.com/recaptcha/api.js?render=' . esc_attr($recaptcha_v3_site_key) . '"></script>';
            echo '<input type="hidden" id="recaptcha-token-login" name="recaptcha-token-login" value="" />';
            echo '<script>
                grecaptcha.ready(function() {
                    grecaptcha.execute("' . esc_js($recaptcha_v3_site_key) . '", { action: "login" }).then(function(token) {
                        document.getElementById("recaptcha-token-login").value = token;
                    });
                });
            </script>';
        }
    }

    public function display_recaptcha_v3_on_registration_form() {
        $recaptcha_version = get_option('synkraft_google_recaptcha_version');

        if ($recaptcha_version === 'recaptcha_v3') {
            $recaptcha_v3_site_key = get_option('synkraft_google_recaptcha_v3_key');

            echo '<script src="https://www.google.com/recaptcha/api.js?render=' . esc_attr($recaptcha_v3_site_key) . '"></script>';
            echo '<input type="hidden" id="recaptcha-token-registration" name="recaptcha-token-registration" value="" />';
            echo '<script>
                grecaptcha.ready(function() {
                    grecaptcha.execute("' . esc_js($recaptcha_v3_site_key) . '", { action: "registration" }).then(function(token) {
                        document.getElementById("recaptcha-token-registration").value = token;
                    });
                });
            </script>';
        }
    }

    public function display_recaptcha_v3_on_wp_registration_form() {
        $recaptcha_version = get_option('synkraft_google_recaptcha_version');

        if ($recaptcha_version === 'recaptcha_v3') {
            $recaptcha_v3_site_key = get_option('synkraft_google_recaptcha_v3_key');

            echo '<script src="https://www.google.com/recaptcha/api.js?render=' . esc_attr($recaptcha_v3_site_key) . '"></script>';
            echo '<input type="hidden" id="recaptcha-token-wp-registration" name="recaptcha-token-wp-registration" value="" />';
            echo '<script>
                grecaptcha.ready(function() {
                    grecaptcha.execute("' . esc_js($recaptcha_v3_site_key) . '", { action: "wp_registration" }).then(function(token) {
                        document.getElementById("recaptcha-token-wp-registration").value = token;
                    });
                });
            </script>';
        }
    }
        
}