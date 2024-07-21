<?php
/*
* Synkraft Recaptcha Option Page
*/
class Recaptcha_Option_Page {

    public function __construct() {

        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
        add_action('wp_ajax_update_recaptcha_version', array( $this, 'update_recaptcha_version_callback'));
        add_action('wp_ajax_nopriv_update_recaptcha_version', array( $this, 'update_recaptcha_version_callback'));
    }

    public function add_plugin_page() {
        echo "<br>";
        add_menu_page(
            'Synkraft Google Recaptcha Plugin Settings',
            'Recaptcha Settings',
            'manage_options',
            'recaptcha-settings',
            array( $this, 'create_admin_page' ),
            'dashicons-shield', 
            30
        );

    }

    public function create_admin_page() {
        ?>
        <div class="wrap">
            <h4><?php echo esc_html__( 'Synkraft Google Recaptcha Settings', 'syn-google-cpatcha-plugin' );?></h4>
            <form method="post" action="options.php" id="add_captcha_fields">
                <?php
                settings_fields('recaptcha_group');
                do_settings_sections('recaptcha-settings');
                ?>
            
                <table class="form-table">
                    <?php
                    $recaptcha_v2_site_key =    get_option('synkraft_google_recaptcha_v2_key');
                    $recaptcha_v3_site_key =    get_option('synkraft_google_recaptcha_v3_key');
                    $url = 'https://www.google.com/recaptcha/admin';
                    
                    ?>
                    <tr id="recaptcha_v2_site_key_field">
                        <th><?php echo esc_html__( 'Recaptcha V2 Site Key:', 'syn-google-cpatcha-plugin' );?> </th>
                        <tr></tr>


                            <td class="col-12 captcha_inputs">
                                    <input type="text" name="recaptcha_v2_site_key" id="g_recaptcha_v2_site_key" value="<?php if(isset($recaptcha_v2_site_key) && $recaptcha_v2_site_key !==''){echo $recaptcha_v2_site_key;} ?>" placeholder="Enter reCaptcha V2 Site Key" />
                                    <?php
                                        if(isset($recaptcha_v2_site_key) && $recaptcha_v2_site_key = '' ){
                                    ?>
                                    <div class="notice notice-error" id="v2_notice_error">
                                        <p><b><?php echo esc_html__('Warning: Google reCAPTCHA is disabled!', 'syn-google-cpatcha-plugin'); ?></b></p>
                                        <p><?php echo esc_html__('You have to', 'syn-google-cpatcha-plugin');?>  <a href="<?php echo esc_url($url);?>" target='_blank'> <?php echo esc_html__('register your domain,', 'syn-google-cpatcha-plugin')?></a> <?php echo esc_html__('get required Google reCAPTCHA keys v2 and save them bellow.', 'syn-google-cpatcha-plugin');?></p>
                                    </div>
                                    <?php }?>
                                </td>
                    </tr>

                    <tr id="recaptcha_v3_site_key_field">
                        <th><?php echo esc_html__( 'Recaptcha V3 Site Key:', 'syn-google-cpatcha-plugin' );?> </th>
                        <tr></tr>
                        <td class="col-12 captcha_inputs">
                            <input type="text" name="recaptcha_v3_site_key" id="g_recaptcha_v3_site_key" value="<?php if(isset($recaptcha_v3_site_key) && $recaptcha_v3_site_key !==''){echo $recaptcha_v3_site_key;} ?>" placeholder="Enter reCaptcha V3 Site Key"/>
                            <?php
                                if(isset($recaptcha_v3_site_key) && $recaptcha_v3_site_key = '' ){
                            ?>
                            <div class="notice notice-error" id="v3_notice_error">
                                <p><b><?php echo esc_html__('Warning: Google reCAPTCHA is disabled!', 'syn-google-cpatcha-plugin'); ?></b></p>
                                <p><?php echo esc_html__('You have to', 'syn-google-cpatcha-plugin');?>  <a href="<?php echo esc_url($url);?>" target='_blank'> <?php echo esc_html__('register your domain,', 'syn-google-cpatcha-plugin')?></a> <?php echo esc_html__('get required Google reCAPTCHA keys v3 and save them bellow.', 'syn-google-cpatcha-plugin');?></p>
                            </div>
                            <?php }?>
                        </td>
                    </tr>
                <!-- ... Other settings ... -->
                
                </table>
                <?php
                submit_button('Save Keys');
                ?>
            </form>
        </div>
        <?php
    }
    public function page_init() {
        register_setting(
            'recaptcha_group',
            'recaptcha_version'
        );  

        add_settings_section(
            'recaptcha_section',
            '',
            array( $this, 'print_section_info' ),
            'recaptcha-settings'
        );

        add_settings_field(
            'recaptcha_version',
            'Select Recaptcha Version',
            array( $this, 'recaptcha_version_callback' ),
            'recaptcha-settings',
            'recaptcha_section'
        );
        add_settings_field(
            'show_on_login_form',
            'Show on User Login Form',
            array( $this, 'show_on_login_form_callback' ),
            'recaptcha-settings',
            'recaptcha_section'
        );

        add_settings_field(
            'show_on_wp_signup_form',
            'Show on User Sign Up Form',
            array( $this, 'show_on_signup_form_callback' ),
            'recaptcha-settings',
            'recaptcha_section'
        );
        add_settings_field(
            'show_on_checkout',
            'Show on WooCommerce Checkout Page',
            array( $this, 'show_on_woo_checkout_callback' ),
            'recaptcha-settings',
            'recaptcha_section'
        );
        
        add_settings_field(
            'show_on_woocommerce_pages',
            'Show on WooCommerce Pages',
            array( $this, 'show_on_woocommerce_pages_callback' ),
            'recaptcha-settings',
            'recaptcha_section'
        );

    }

    public function print_section_info() {
        // echo esc_html__( 'Choose the Recaptcha version to use:', 'syn-google-cpatcha-plugin' );
    }
  
    public function recaptcha_version_callback() {
        $recaptcha_version = get_option('synkraft_google_recaptcha_version');
        ?>
        <select id="recaptcha_version_select" name="recaptcha_version">
            <option value="recaptcha_v2" <?php selected($recaptcha_version, 'recaptcha_v2'); ?>><?php echo esc_html__( 'Recaptcha V2', 'syn-google-cpatcha-plugin' )?></option>
            <option value="recaptcha_v3" <?php selected($recaptcha_version, 'recaptcha_v3'); ?>><?php echo esc_html__( 'Recaptcha V3', 'syn-google-cpatcha-plugin' )?></option>
        </select>
        <?php
    }
    
    /**Woocommerce Checkout Fields **/
    public function show_on_woo_checkout_callback() {
        $show_on_checkout = get_option( 'enable_captcha_on_woo_checkout' );
        echo '<input type="checkbox" class="form-check-input" name="show_on_checkout" id="woo_checkout_page_check" ' .  (isset($show_on_checkout) && $show_on_checkout == 'on' ? 'checked' : '').' />';
    }


    public function show_on_woocommerce_pages_callback() {
    $show_on_woocommerce_pages = get_option('check_woo_account_status');
    ?>
    <select name="show_on_woocommerce_pages" id="show_on_woocommerce_pages">
   
        <option value="select_value"><?php echo esc_html__( 'Select Value', 'syn-google-cpatcha-plugin' ); ?></option>
     
        <option value="login" <?php selected($show_on_woocommerce_pages, 'login'); ?>><?php echo esc_html__( 'Login', 'syn-google-cpatcha-plugin' ); ?></option>
        <option value="signup" <?php selected($show_on_woocommerce_pages, 'signup'); ?>><?php echo esc_html__( 'Sign Up', 'syn-google-cpatcha-plugin' ); ?></option>
    </select>
    <?php
}

 

    public function show_on_login_form_callback() {
        $show_on_login_form = get_option( 'enable_captcha_on_login_form' );
        echo '<input type="checkbox" class="form-check-input" name="show_on_login_form" id="show_on_user_login_form" ' .  (isset($show_on_login_form) && $show_on_login_form == 'on' ? 'checked' : '').' />';
    }

    public function show_on_signup_form_callback() {
        $show_on_signup_form = get_option( 'enable_captcha_on_wp_signup_form' );
        echo '<input type="checkbox" class="form-check-input" name="show_on_wp_signup_form" id="show_on_user_signup_form" ' .  (isset($show_on_signup_form) && $show_on_signup_form == 'on' ? 'checked' : '').' />';
    }

  
    function update_recaptcha_version_callback() {

        $v2_captcha_site_key = sanitize_text_field( $_POST['v2_site_key']);
        $v3_captcha_site_key = sanitize_text_field($_POST['v3_site_key']);
        $recaptcha_version = sanitize_text_field($_POST['recaptcha_version']);
        $check_woo_status = sanitize_text_field($_POST['check_woo_status']);
        $check_login_status = sanitize_text_field($_POST['check_login_status']);
        $reset_password_status = sanitize_text_field($_POST['reset_password_status']);
        $check_wp_signup_status = sanitize_text_field($_POST['check_SignUp_status']);
        $check_woo_account_status = sanitize_text_field($_POST['check_selected_woo']);
        
        //select recaptcha version
        update_option('synkraft_google_recaptcha_version', $recaptcha_version);
        //
        update_option('enable_captcha_on_woo_checkout', $check_woo_status);
        update_option('enable_captcha_on_login_form', $check_login_status);
        update_option('enable_captcha_on_reset_pass_form', $reset_password_status);
        update_option('enable_captcha_on_signup_wp_form', $check_wp_signup_status);

        update_option('check_woo_account_status', $check_woo_account_status);
    
       
        if ($recaptcha_version === 'recaptcha_v2') {

            update_option('synkraft_google_recaptcha_v2_key', $v2_captcha_site_key);

        } elseif ($recaptcha_version === 'recaptcha_v3') {

            update_option('synkraft_google_recaptcha_v3_key', $v3_captcha_site_key);

        }
        
        wp_send_json_success('Recaptcha version updated successfully.');
    }
    
}