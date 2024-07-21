<?php
//Exit if accessed directly

if (!defined('ABSPATH')) {
    return;
}
class Synk_Email_Core_Functions_Pro
{
    protected static $instance = null;
    public function __construct()
    {
        add_action('init',array($this,'synk_email_value_action_pro'));
    }
    //Get class instance
    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    function synk_email_value_action_pro(){
        $synk_email_status_value = sanitize_text_field(get_option('synk-email-on-off','true'));
        if($synk_email_status_value){
            add_action( 'user_register', array($this, 'synkemail_check_register_users_pro'), 999, 1 );
            add_action('init', array($this,'custom_email_verification_endpoint_pro'),999,1);
            add_filter('login_message',array($this,'synkemail_custom_login_message_pro'));
            add_filter('login_message',array($this,'synkemail_custom_resend_email_pro'));
            add_action('woocommerce_thankyou',array($this,'synkeamil_custom_check_mail_pro'));
        }
    }
    function synkemail_check_register_users_pro( $user_id ) {
        $user_info = get_userdata($user_id);
        $code = md5(time());
        $string = array('id'=>$user_id, 'code'=>$code);
        $user_meta = get_userdata($user_id);
        $user_email = $user_meta->user_email;
        $user_roles = $user_meta->roles;
        update_user_meta($user_id, '_is_disabled', 1);
        update_user_meta($user_id,'user_old_role',$user_roles[0]);
        update_user_meta($user_id,'user_email_send_status',1);
        if (!is_wp_error($user_id)) {
            // Generate a unique verification token and store it in user meta
            $verification_token = wp_generate_password(32, false);
            update_user_meta($user_id, 'verification_token', $verification_token);
            date_default_timezone_set("Asia/Karachi");
            $current_email_time = date("Y-m-d H:i");

            $verification_link = site_url("/?token=$verification_token&userid=$user_id");
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
            $sessions = WP_Session_Tokens::get_instance( $user_id );
            $sessions->destroy_all();
            if (class_exists('WooCommerce') && is_checkout()) {

            }else{
                $main_login_url = wp_login_url() . "/?custom_resend_email_pro=true&user_id=$user_id";
                wp_redirect($main_login_url);
                die();
            }
//            // Destroy all the sessions for the user.
//            if($email_status){
//                echo "Email Send Successfully";
//                die();
//                return true;
//            }else{
//                echo "Sorry something went wrong";
//                return false;
//                die();
//            }

        } else {
            return $user_id->get_error_message();
        }
    }
    function custom_email_verification_endpoint_pro($request) {
        if (isset($_GET['token'])) {
            $token = sanitize_text_field($_GET['token']);
            $meta_key = 'verification_token';
            $meta_value = $token;
            $us_id=$_GET['userid'];

            $args = array(
                'meta_key' => $meta_key,
                'meta_value' => $meta_value,
                'fields' => 'ID', // You can change this to 'all' to get full user objects
            );
            $user_data = get_users($args);
            $user_id=isset($user_data[0]) ? $user_data[0]:'';
            if (!empty($user_data)) {
                foreach ($user_data as $user_id) {
                  $user = get_userdata($user_id);
                  $expiry_email_status=check_expiry_email_token($user->ID);
                  if($expiry_email_status){
                      delete_user_meta($user->ID, 'verification_token');
                      update_user_meta($user->ID, '_is_disabled', 0);
                      $main_login_url=wp_login_url()."/?custom_message_pro=true";
                      wp_redirect($main_login_url);
                      exit();
                  }else{
                      $main_login_url=wp_login_url()."/?custom_resend_email_pro_expire=true&user_id=$user_id";
                      wp_redirect($main_login_url);
                      die();
                  }
                }

            }else {
                //echo 'Invalid verification token.';
                $main_login_url=wp_login_url()."/?custom_resend_email_pro_expire=true&user_id=$us_id";
                wp_redirect($main_login_url);
                die();
            }

        }
        if(empty($_GET['token'])) {

            $meta_key = 'resend_expire_hours'; // Replace with your actual meta key
            $users = get_users(array(
                'meta_key' => $meta_key,
            ));
//            echo "This is expire hours".get_user_meta(97,'resend_expire_hours',true);
//            echo "<br>";
//            echo "This is time".get_user_meta(97,'current_time',true);
            if(!empty($users)) {
                foreach ($users as $user) {
                    $resent_expire_hours = get_user_meta($user->ID, $meta_key, true);
                    $email_was_sended = get_user_meta($user->ID, 'current_time', true);
//                    echo "The user id which belong to data==".$user->ID;
//                    echo "<br>";
//                    echo "Time the expire time is set==".$resent_expire_hours;
//                    echo "<br>";
//                    echo "Time when the email was send==".$email_was_sended;
//                    echo "<br>";
                    update_user_meta_resend_expiry($user->ID, $email_was_sended, $resent_expire_hours);
                }
              //  die();
            }
        }
    }
    function synkemail_custom_login_message_pro($message) {
        if (isset($_GET['custom_message_pro'])) {
            $message ='<div id="login_error"><strong>'.esc_html__('Notification','synkeverify').'</strong>: '.esc_html__('Thank you! Your account has been verified successfully, you can login now.','synkeverify').'<br></div>';
        }
        return $message;
    }
    function synkemail_custom_resend_email_pro($message) {
        if (isset($_GET['custom_resend_email_pro'])) {
            $user_id=$_GET['user_id'];
            $user_meta = get_userdata($user_id);
            $user_email = $user_meta->user_email;
            $email_sent_status= get_user_meta($user_id,'user_email_send_status',true);
            $synk_email_number_value = sanitize_text_field(get_option('synk-email-limit-email-send-pro','4'));
            $message ='<div id="login_error"><strong>'.esc_html__('Notification','synkeverify').'</strong><span id="custom-msg">:'.esc_html__('Thank you! We have sent you an verification email on ','synkeverify').'  <span id="email-name">'.$user_email.  '</span>  '.esc_html__('to login your account','synkeverify').'  <span id="email-counter" style="background-color: #0c88b4;color: white;padding: 4px 8px;border-radius: 50%;width: 10px;height: 10px;display: table-cell;text-align: center;">'.$email_sent_status.'</span> Time</span><br></div>';
            $message .='<div style="text-align: center;margin:15px 0px">
        <button class="pro" id="resend-email" data-user-id="'.$user_id.'" data-resend-count="'.$email_sent_status.'" data-email-set-count="'.$synk_email_number_value.'" style="display: inline-block; padding: 10px 20px; background-color: #0073e6; color: #fff; text-decoration: none;border:0px;cursor:pointer">'.esc_html__('Resend Verify Email','synkeverify').'</button>
       <input type="hidden" id="resend-count" value="'.$email_sent_status.'">
       <input type="hidden" id="email-set-cout" value="'.$synk_email_number_value.'">
    </div>';
        }
        if (isset($_GET['custom_resend_email_pro_expire'])) {
            $user_id=$_GET['user_id'];
            $user_meta = get_userdata($user_id);
            $user_email = $user_meta->user_email;
            $main_login_url=wp_login_url()."/?custom_resend_email_pro=true&user_id=$user_id";
            $email_sent_status= get_user_meta($user_id,'user_email_send_status',true);
            $synk_email_number_value = sanitize_text_field(get_option('synk-email-limit-email-send-pro','4'));
            $message ='<div id="login_error"><strong>'.esc_html__('Notification','synkeverify').'</strong><span id="custom-msg">:'.esc_html__('Sorry! The link has been expired, please go the login page and send a new one','synkeverify').'<br></div>';
            $message .='<div style="text-align: center;margin:15px 0px">
        <button id="resend-email"  data-user-id="'.$user_id.'" data-resend-count="'.$email_sent_status.'" data-email-set-count="'.$synk_email_number_value.'" style="display: inline-block; padding: 10px 20px; background-color: #0073e6; color: #fff; text-decoration: none;border:0px;cursor:pointer">'.esc_html__('Resend Verify Email','synkeverify').'</>
       <input type="hidden" id="resend-count" value="'.$email_sent_status.'">
       <input type="hidden" id="email-set-cout" value="'.$synk_email_number_value.'">
    </div>';
        }
        return $message;
    }
    function synkeamil_custom_check_mail_pro() {
        $user_id = get_current_user_id();
        $user_status=get_user_meta($user_id, '_is_disabled', 1);
        if($user_status==1){
            $main_login_url = wp_login_url();
            $mail_button_verify='<a href="'.$main_login_url.'" id="resend-email" data-user-id="'.$user_id.'" style="display: inline-block; padding: 10px 20px; background-color: #0073e6; color: #fff; text-decoration: none;border:0px;cursor:pointer;">'.esc_html__('Login To Verify','synkeverify').'</button>';
            echo "<div class='custom-message' style='background-color: #949494;position: absolute;top: 15px;left:25%;padding-left: 15px;z-index:9999;'>".esc_html__("Email Send To Your Account Verification or Click Button to Login ").$mail_button_verify."</div>";
            wp_logout();
        }else{

        }
    }
}
