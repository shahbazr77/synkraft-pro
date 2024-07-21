<?php

class Synk_Email_Disable_User_Pro {
	private static $instance;
	private static $user_meta_key = '_is_disabled';
	public static function get_instance() {
		if ( empty( self::$instance ) && ! ( self::$instance instanceof Synk_Email_Disable_User_Pro ) ) {
			self::$instance = new Synk_Email_Disable_User_Pro();
			self::$instance->synkemail_add_hooks();
			//do_action( 'disable_user_login.loaded' );
		}
		return self::$instance;
	}
	private function __construct() {



    }
	private function synkemail_add_hooks() {
		if ( is_admin() ) {
            add_filter( 'manage_users_custom_column',array($this, 'synkemail_users_column_content' ), 10, 3 );
			add_action( 'admin_footer-users.php',array($this, 'synkemail_manage_users_css'));
		}
		// Filters
		add_filter('authenticate',array($this,'synkemail_user_login'), 1000, 3 );
		add_filter('manage_users_columns',array( $this,'synkemail_manage_users_columns'));
        add_filter( 'bulk_actions-users',array( $this, 'synkemail_bulk_action_disable_users'));
        add_filter( 'handle_bulk_actions-users',  array( $this, 'synkemail_handle_bulk_disable_users'   ), 10, 3 );
        add_action('admin_notices',array($this,'show_email_verification_admin_notice'));
    }
    public function can_disable( $user_id ) {
        // Don't disable super admins.
        if ( is_multisite() && is_super_admin( $user_id ) ) {
            return false;
        }
        // Don't disable the currently logged in user.
        if ( $user_id == get_current_user_id() ) {
            return false;
        }
        return true;
    }
    public function synkemail_manage_users_columns( $defaults ) {
        $defaults['disable_user_login'] = __( 'Status', 'synkeverify' );
        return $defaults;
    }
	public function synkemail_user_login( $user, $username, $password ) {
		if ( is_a( $user, 'WP_User' ) ) {
			// Is the user logging in disabled?
			if ( $this->synkemail_is_user_disabled( $user->ID ) ) {
				do_action( 'disable_user_login.disabled_login_attempt', $user );
                $user_id=$user->ID;
                $user_meta = get_userdata($user_id);
                $user_email = $user_meta->user_email;
                $main_login_url=wp_login_url()."/?custom_resend_email_pro=true&user_id=$user_id";
                $email_sent_status= get_user_meta($user_id,'user_email_send_status',true);
                $synk_email_number_value = sanitize_text_field(get_option('synk-email-limit-email-send-pro','4'));
                $message ='<strong>'.esc_html__('Notification','synkeverify').'</strong><span id="custom-msg">:'.esc_html__('Your Account Not Verified Yet Please Send Email To Verify','synkeverify').'<br>';
                $message .='<div style="text-align: center;margin:15px 0px">
        <button id="resend-email" data-user-id="'.$user_id.'" data-resend-count="'.$email_sent_status.'" data-email-set-count="'.$synk_email_number_value.'" style="display: inline-block; padding: 10px 20px; background-color: #0073e6; color: #fff; text-decoration: none;border:0px;cursor:pointer">'.esc_html__('Resend Verify Email','synkeverify').'</button>
    </div>';
                return new WP_Error( 'disable_user_login_user_disabled', apply_filters( 'disable_user_login.disabled_message', $message) );
			}
		}
		//Pass on any existing errors
		return $user;
	}
	public function synkemail_users_column_content( $output, $column_name, $user_id ) {
		if ( $column_name == 'disable_user_login' ) {
			if ( get_the_author_meta( self::$user_meta_key, $user_id ) == 1 ) {
				return __( 'Unverified', 'synkeverify' );
			}else{
                return __( 'Verifed', 'synkeverify' );
            }
		}

		return $output; // always return, otherwise we overwrite stuff from other plugins.
	}
	public function synkemail_manage_users_css() {
		echo '<style type="text/css">.column-disable_user_login { width: 80px; }</style>';
	}
	private function synkemail_is_user_disabled( $user_id ) {
	    $disabled = get_user_meta( $user_id, self::$user_meta_key, true );
		if ( $disabled == '1' ) {
			return true;
		}
		return false;
	}
    private function synkemail_maybe_trigger_enabled_disabled_actions( $user_id, $originally_disabled, $disabled ) {

        /**
         * Trigger an action when a disabled user's account has been
         * enabled.
         *
         * @since 1.2.0
         * @param int $user_id The ID of the user being enabled
         */
        if ( $originally_disabled && $disabled == 0 ) {
            do_action( 'disable_user_login.user_enabled', $user_id );
        }
        /**
         * Trigger an action when an enabled user's account is disabled
         *
         * @since 1.2.0
         * @param int $user_id The ID of the user being disabled
         */
        if ( ! $originally_disabled && $disabled == 1 ) {
            do_action( 'disable_user_login.user_disabled', $user_id );
        }

    }
    public function synkemail_bulk_action_disable_users($bulk_actions) {
        //$bulk_actions['enable_user_login']  = _x( 'Active', 'bulk action',  'disable-user-login' );
        $bulk_actions['disable_user_login'] = _x( 'Send Email To Verify', 'bulk action', 'disable-user-login' );
        return $bulk_actions;
    }
    public function synkemail_handle_bulk_disable_users( $redirect_to, $doaction, $user_ids ) {
        if ( $doaction !== 'disable_user_login' && $doaction !== 'enable_user_login' ) {
            return $redirect_to;
        }
        $disabled = $doaction === 'disable_user_login' ? 1 : 0;
        $affected_user_count = 0;
        foreach ( $user_ids as $user_id ) {
            if ( $disabled === 1 && ! $this->can_disable( $user_id ) ) {
                continue;
            }
            // Store disabled status before update
            $originally_disabled = $this->synkemail_is_user_disabled( $user_id );
            update_user_meta( $user_id, self::$user_meta_key, $disabled );
            $this->synkemail_bulk_user_emails($user_id);
            $this->synkemail_maybe_trigger_enabled_disabled_actions( $user_id, $originally_disabled, $disabled );
            $affected_user_count++;
        }
        if ( $disabled ) {
            if($originally_disabled=="" and $_GET['email_verify_notice']=="") {
                $show=1;
                $redirect_to_message=$redirect_to."?email_verify_notice=$show";
                $redirect_to_message = add_query_arg('disable_user_login', $affected_user_count, $redirect_to_message);
                $redirect_to = remove_query_arg('disable_user_login', $redirect_to_message);
            }else{
                $redirect_to = add_query_arg('disable_user_login', $affected_user_count, $redirect_to);
                $redirect_to = remove_query_arg('disable_user_login', $redirect_to);
            }
        } else {
            $redirect_to = add_query_arg( 'disable_user_login',  $affected_user_count, $redirect_to );
            $redirect_to = remove_query_arg( 'disable_user_login', $redirect_to );
        }
        return $redirect_to;
    }
    public function synkemail_bulk_user_emails( $user_id ) {
        $user_info = get_userdata($user_id);
        $code = md5(time());
        $string = array('id'=>$user_id, 'code'=>$code);
        $user_meta = get_userdata($user_id);
        $user_email = $user_meta->user_email;
        $user_roles = $user_meta->roles;
        update_user_meta($user_id,'user_old_role',$user_roles[0]);
        update_user_meta($user_id,'user_email_send_status',1);
        if (!is_wp_error($user_id)) {
            // Generate a unique verification token and store it in user meta
            $verification_token = wp_generate_password(32, false);
            update_user_meta($user_id, 'verification_token', $verification_token);
            date_default_timezone_set("Asia/Karachi");
            $current_email_time = date("Y-m-d H:i");

            $verification_link = site_url("/?token=$verification_token");
            $email_subject = esc_html__('Verify Your Email Address','synkeverify');
            $headers[] = 'Content-Type: text/html; charset=UTF-8';
            $email_message = '<html><head><title>'.esc_html__('Verify Your Account','synkeverify').'</title></head>
            <body>
                <p>'.esc_html__('Hello','synkeverify').' '.$user_email.'</p>
                <p>'.esc_html__('Click the following Button to verify your email address:','synkeverify').'</p>
                <a href="'.$verification_link.'" target="_blank" style="background-color: #0073e6; color: #ffffff; padding: 10px 20px; text-decoration: none; border-radius: 5px;">'.esc_html__('Click To Verify','synkeverify').'</a>
                <p>'.esc_html__('Thank you','synkeverify').'.</p>
            </body>
            </html>';
            $email_status=wp_mail($user_email, $email_subject, $email_message, $headers);
            update_user_meta($user_id,'user_email_send_time',$current_email_time);

        } else {
            return $user_id->get_error_message();
        }
    }
    function show_email_verification_admin_notice() {
        if (isset($_GET['email_verify_notice']) && $_GET['email_verify_notice']) {
            echo '<div class="notice notice-success is-dismissible"><p>'.esc_html__("Email Send All User's Successfully.").'</p></div>';
        }
   }
}
//end class Synk_Email_Disable_User_Pro
