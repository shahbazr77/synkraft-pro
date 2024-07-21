<?php
//Exit if accessed directly
if(!defined('ABSPATH')){
    return;
}

class Synk_Email_Verify_Scripts_Pro{

    protected static $instance = null;
    public function __construct(){
          add_action('plugins_loaded',array($this,'synkemail_load_txt_domain'),99);
          add_action('wp_enqueue_scripts',array($this,'synkemail_verify_enqueue_scripts_pro_frontend'));
          add_action('login_enqueue_scripts', array($this,'synkemail_verify_enqueue_scripts_pro'));
    }
    //Get class instance
    public static function get_instance(){
        if(self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    //Inline styles from cart popup settings
    public static function get_inline_styles(){
        $synk_pop_gl_ibtne_value = sanitize_text_field(get_option('synk-pop-gl-ibtne','true'));
        $synk_pop_gl_qtyen_value = sanitize_text_field(get_option('synk-pop-gl-qtyen','true'));
        $synk_pop_gl_vcbtne_value = sanitize_text_field(get_option('synk-pop-gl-vcbtne'));
        $synk_pop_gl_chbtne_value = sanitize_text_field(get_option('synk-pop-gl-chbtne'));
        $synk_pop_sy_pw_value = sanitize_text_field(get_option('synk-pop-sy-pw'));
        $synk_pop_sy_imgw_value = sanitize_text_field(get_option('synk-pop-sy-imgw'));
        $synk_pop_sy_btnbg_value = sanitize_text_field(get_option('synk-pop-sy-btnbg'));
        $synk_pop_sy_btnhover_value = sanitize_text_field(get_option('synk-pop-sy-btnhover'));
        $synk_pop_sy_btnhoverborder_value = sanitize_text_field(get_option('synk-pop-sy-btnhoverborder'));
        $synk_pop_sy_btnc_value = sanitize_text_field(get_option('synk-pop-sy-btnc'));
        $synk_pop_sy_btns_value = sanitize_text_field(get_option('synk-pop-sy-btns'));
        $synk_pop_sy_btnbr_value = sanitize_text_field(get_option('synk-pop-sy-btnbr'));
        $synk_pop_sy_tbs_value = sanitize_text_field(get_option('synk-pop-sy-tbs'));
        $synk_pop_sy_tbc_value = sanitize_text_field(get_option('synk-pop-sy-tbc'));
        $synk_pop_sy_popbj_value = sanitize_text_field(get_option('synk-pop-sy-popbg'));
        $synk_pop_sy_popupborder_value = sanitize_text_field(get_option('synk-pop-sy-popborder'));

        $style = '';

        if(!$synk_pop_gl_vcbtne_value){
            $style .= 'a.synk-pop-btn-vc{
				display: none;
			}';
        }

        if(!$synk_pop_gl_ibtne_value){
            $style .= 'span.synk-chng{
				display: none;
			}';
        }

        if(!$synk_pop_gl_chbtne_value){
            $style .= 'a.synk-pop-btn-ch{
				display: none;
			}';
        }

        if($synk_pop_gl_qtyen_value && $synk_pop_gl_ibtne_value){
            $style .= 'td.synk-pop-pqty{
			    min-width: 120px;
			}';
        }
        else{

        }

        $style.= "
			.synk-pop-container{
				max-width: {$synk_pop_sy_pw_value}px;
				background-color: {$synk_pop_sy_popbj_value};
				border-color:{$synk_pop_sy_popupborder_value};
			}
			.synk-btn{
				background-color: {$synk_pop_sy_btnbg_value};
				color: {$synk_pop_sy_btnc_value};
				font-size: {$synk_pop_sy_btns_value}px;
				border-radius: {$synk_pop_sy_btnbr_value}px;
				border: 1px solid {$synk_pop_sy_btnbg_value};
			}
			.synk-btn:hover{
				color: {$synk_pop_sy_btnc_value};
				background-color:{$synk_pop_sy_btnhover_value};
				border-color:{$synk_pop_sy_btnhoverborder_value};
			}
			td.synk-pop-pimg{
				width: {$synk_pop_sy_imgw_value}%;
			}
			table.synk-pop-pdetails , table.synk-pop-pdetails tr{
				border: 0!important;
			}
			table.synk-pop-pdetails td{
				border-style: solid;
				border-width: {$synk_pop_sy_tbs_value}px;
				border-color: {$synk_pop_sy_tbc_value};
			}";

        return $style;
    }
    //enqueue stylesheets & scripts
    public static function synkemail_verify_enqueue_scripts_pro(){
        wp_enqueue_style('synk-email-verify-pro-style',SYNKEmail_Verify_Pro_URL.'/assets/css/synkemail-verify-pro-style.css',null,SYNKEmail_Verify_Pro_VERSION);
        wp_enqueue_script('synk-email-verify-pro-js',SYNKEmail_Verify_Pro_URL.'/assets/js/synkeamil-verify-pro-js.js',array('jquery'),SYNKEmail_Verify_Pro_VERSION,true);
        wp_localize_script('synk-email-verify-pro-js','synk_email_string_pro',array(
            'ajax_url'     		=> admin_url().'admin-ajax.php',
            'homeurl' 			=> get_bloginfo('url'),
            'nonce' => wp_create_nonce('ajax-nonce'),
//            'wc_ajax_url' 		=> WC_AJAX::get_endpoint( "%%endpoint%%" ),
        ));
        wp_add_inline_style('synk-email-verify-style',self::get_inline_styles());
    }

    public static function synkemail_verify_enqueue_scripts_pro_frontend(){
        wp_enqueue_style('synk-email-verify-pro-style',SYNKEmail_Verify_Pro_URL.'/assets/css/synkemail-verify-pro-style.css',null,SYNKEmail_Verify_Pro_VERSION);
        wp_enqueue_script('synk-email-verify-pro-js',SYNKEmail_Verify_Pro_URL.'/assets/js/synkeamil-verify-pro-js.js',array('jquery'),SYNKEmail_Verify_Pro_VERSION,true);
        wp_localize_script('synk-email-verify-pro-js','synk_email_string_pro',array(
            'ajax_url'     		=> admin_url().'admin-ajax.php',
            'homeurl' 			=> get_bloginfo('url'),
            'nonce' => wp_create_nonce('ajax-nonce'),
            'wc_ajax_url' 		=> WC_AJAX::get_endpoint( "%%endpoint%%" ),
        ));
        wp_add_inline_style('synk-email-verify-style',self::get_inline_styles());
    }





    //Load text domain
    public function synkemail_load_txt_domain(){
        $domain = 'synkeverify';
        load_plugin_textdomain( $domain, FALSE, basename(SYNKEmail_Verify_Pro_PATH ) . '/languages/' );
    }

}
?>