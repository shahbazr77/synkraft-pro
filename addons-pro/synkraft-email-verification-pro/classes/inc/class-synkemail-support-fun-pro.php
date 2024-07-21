<?php
if(!defined('ABSPATH')) {
    return;
}
class SYNK_Email_Support_Function_Pro{
    protected static $instance = null;
    public static function get_instance(){
        if(self::$instance===null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct(){
        function synk_email_verify_nonce_pro($nonce, $key)
        {
            if (!wp_verify_nonce($nonce, $key)) {
                $return = array('message' => esc_html__('Direct access not allowed', 'synkraft'));
                wp_send_json_error($return);
            }
        }
        function check_expiry_email_token($user_id){
            $link_send_time=get_user_meta($user_id,'user_email_send_time',true);
            $synk_hour_timer_set = sanitize_text_field(get_option('synk-email-expiry-time-limit'));
            $synk_hour_timer = intval($synk_hour_timer_set);
            date_default_timezone_set("Asia/Karachi");
            $current_time = date("Y-m-d H:i");
            $email_was_send = new DateTime($link_send_time);
            $email_link_click = new DateTime($current_time);
            $interval = $email_was_send->diff($email_link_click);
            $hours = $interval->days * 24 + $interval->h + $interval->i / 60 + $interval->s / 3600;
             if($synk_hour_timer >= $hours){
                return true;
             }else{
                 return false;
             }

        }
        function update_user_meta_resend_expiry($user_id,$email_was_sended,$resent_expire_hours){
            $synk_hour_timer = intval($resent_expire_hours);
            date_default_timezone_set("Asia/Karachi");
            $current_time = date("Y-m-d H:i");
            $email_was_send = new DateTime($email_was_sended);
            $email_link_click = new DateTime($current_time);
            $interval = $email_was_send->diff($email_link_click);
            $hours = $interval->days * 24 + $interval->h + $interval->i / 60 + $interval->s / 3600;
            //update_user_meta($user_id,'resend_expire_hours',1);
//            echo "This is User Id======".$user_id;
//            echo "<br>";
//            echo "The Email was Sended======".$email_was_sended;
//            echo "<br>";
//            echo "This Curent Time ======".$current_time;
//            echo "<br>";
//            echo "Two time diffrence ======".$hours;
//            echo "<br>";
//            echo "set time for expire hours ======".$synk_hour_timer;

            if($hours >= $synk_hour_timer){
                update_user_meta($user_id,'user_email_send_status',0);
                delete_user_meta($user_id,'resend_expire_hours');
                delete_user_meta($user_id,'current_time');
            }


        }






    }
}