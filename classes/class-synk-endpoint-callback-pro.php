<?php
if(!defined('ABSPATH')) {
    return;
}
class PRO_SYNK_Endpoint_Callback{
    protected static $instance = null;
    private $api_url="'https://phpstack-1021230-3700270.cloudwaysapps.com";
    public static function get_instance(){
        if(self::$instance===null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct(){
        function pro_user_verification($pro_user_nonceemail,$pro_user_id,$pro_user_mail,$pro_user_pwd,$pro_user_site,$pro_user_rute){

            //https://phpstack-1021230-3700270.cloudwaysapps.com/users/login?email=teseeeet@gmail.com&password=test@gmail.com
//            $request_url = 'https://phpstack-1021230-3700270.cloudwaysapps.com/users/webAuthKey?wpnone='.$pro_user_nonceemail.'&wpid='.$pro_user_id.'&email='.$pro_user_mail.'&password='.$pro_user_pwd.'&wpsite='.$pro_user_site.'&wprute='.$pro_user_rute;
//            $request_args = array(
//                'method'  => 'GET',  // HTTP method (GET, POST, PUT, DELETE, etc.)
//                'headers' => array(
//                    'Authorization' => '',  // Replace with your API key or authentication header
//                ),
//            );

            //https://phpstack-1021230-3877718.cloudwaysapps.com
            $request_url = 'https://phpstack-1021230-3877718.cloudwaysapps.com/users/login?email='.$pro_user_mail.'&password='.$pro_user_pwd;
            $request_args = array(
                'method'  => 'POST',  // HTTP method (GET, POST, PUT, DELETE, etc.)
                'headers' => array(
                    'Authorization' => '',  // Replace with your API key or authentication header
                ),
            );


            $response = wp_remote_request($request_url, $request_args);
            if (is_wp_error($response)) {
                $error_message = $response->get_error_message();
                echo "API request failed: $error_message";
            } else {
                $response_code = wp_remote_retrieve_response_code($response);
                $response_body = wp_remote_retrieve_body($response);
                //return $response_code;
                // Output the response
            // echo "Response code: $response_code";
            // echo "Response body: $response_body";
                $response_data_code = json_decode($response_code, TRUE);
                $response_data_body = json_decode($response_body, TRUE);
                $return_array = array('response_code' => $response_data_code,'response_body' =>$response_data_body);
                
                
                $pro_activation_data = array(
                    'user_website' => array(
                        'website_url' => site_url(),
                        'website_title' => get_bloginfo(),
                    ),
                    'user_data' => array(
                        'user_email' => esc_html($pro_user_mail) ,
                    ),
                );
                
                $pro_activation_json_data = json_encode($pro_activation_data);	
                
                $pro_activation_endpoint = "https://phpstack-1021230-3877718.cloudwaysapps.com/users/ProcessProActivation";
                
                $pro_activation_args = array(
                    'body' => $pro_activation_json_data,
                    'headers' => array(
                        'Content-Type' => 'application/json',
                    ),
                );
                
                $response = wp_remote_post($pro_activation_endpoint, $pro_activation_args);
                
                
                return $return_array;

            }

       }

        function get_all_plugins_data($auth_key)
        {
            $bearer="Bearer ";
             // $auth_key="Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczpcL1wvcGhwc3RhY2stMTAyMTIzMC0zNzAwMjcwLmNsb3Vkd2F5c2FwcHMuY29tXC91c2Vyc1wvbG9naW4iLCJpYXQiOjE2ODk1ODYzNDMsImV4cCI6MTY4OTU4OTk0MywibmJmIjoxNjg5NTg2MzQzLCJqdGkiOiJaYlpUZmx4ZVg2Rk1YcDk1Iiwic3ViIjo1LCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.nOLCczax1X_PLmboNYWtuNTmZ_IEexpT8W5JxsRRBfQ";
            //https://phpstack-1021230-3700270.cloudwaysapps.com/users/login?email=teseeeet@gmail.com&password=test@gmail.com
            $request_url = 'https://phpstack-1021230-3700270.cloudwaysapps.com/plugins/getAll';
            $request_args = array(
                'method'  => 'GET',  // HTTP method (GET, POST, PUT, DELETE, etc.)
                'headers' => array(
                    'Authorization' => '',  // Replace with your API key or authentication header
                ),
            );
            $response = wp_remote_request($request_url, $request_args);
            if (is_wp_error($response)) {
                $error_message = $response->get_error_message();
               // echo "API request failed: $error_message";
                return  $error_message;
            } else {
                $response_code = wp_remote_retrieve_response_code($response);
                $response_body = wp_remote_retrieve_body($response);
                //return $response_code;
                // Output the response
                // echo "Response code: $response_code";
                 //echo "Response body: $response_body";
                $response_data_code = json_decode($response_code, TRUE);
                $response_data_body = json_decode($response_body, TRUE);
                $return_array = array('response_code' => $response_data_code,'response_body' =>$response_data_body);
                return $return_array;
            }

        }
        
        //register api against license key
        add_action('rest_api_init', array($this,'synkraft_reigist_user_callback_route'));


    }


    function synkraft_reigist_user_callback_route() {
        register_rest_route('custom/v1','/synkraf-check-secret', array(
            'methods' => 'POST',
            'callback' => array($this,'synkraft_calbak_get_api_response'),
        ));
    }
    function synkraft_calbak_get_api_response($request) {
        $data = $request->get_params();
        // Validate and sanitize input data
        $user_id = isset($data['user_id']) ? intval($data['user_id']) : 0;
        $user_email = isset($data['user_email']) ? sanitize_email($data['user_email']) : 0;
        $secret_key = isset($data['secret_key']) ? sanitize_text_field($data['secret_key']) : '';
        $secret_key_expire= isset($data['secret_key_expire']) ? sanitize_text_field($data['secret_key_expire']) : '';
        $user = get_user_by('ID', $user_id);
        if ($user) {
            update_user_meta($user_id, 'secret_key', $secret_key);
            update_user_meta($user_id, 'secret_key_email', $user_email);
            update_user_meta($user_id, 'secret_expire', $secret_key_expire);
            update_user_meta($user_id, 'secret_key_all_json', $data);
            return array('message' => 'User secret key updated successfully.');
        } else {
            return new WP_Error('user_not_found', 'User does not exist.', array('status' => 404));
        }

    }
}