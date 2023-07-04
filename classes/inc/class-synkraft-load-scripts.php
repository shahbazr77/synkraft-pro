<?php

if(!defined('ABSPATH')) {
    return;
}

class SYNK_Admin_Scripts {

  protected static $instance = null;

  protected function __construct(){
      add_action('admin_enqueue_scripts', array($this,'synkraft_framework_scripts'));
  }

  public static function get_instance(){
    if(self::$instance===null){
       self::$instance=new self();
    }
    return self::$instance;
  }


    function synkraft_framework_scripts()
    {
        /*Enqueue scripts in wp admin*/
//          <link rel="preconnect" href="https://fonts.googleapis.com" />
//          <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        wp_enqueue_style('synkraft_google_fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@200;300;400;500;600;700&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Roboto+Mono:wght@100&display=swap');
        wp_enqueue_style('synkraft_bootstrap', SYNKRAFT_Plugin_Url . 'assets/css/bootstrap.min.css');
        wp_enqueue_style('bootstrap-icons', SYNKRAFT_Plugin_Url . 'assets/css/bootstrap-icons.css');
        wp_enqueue_style('synkraft_notification', SYNKRAFT_Plugin_Url . 'assets/css/notification.css');
        wp_enqueue_style('synkraft_sidebar', SYNKRAFT_Plugin_Url . 'assets/css/sidebar.css');
        wp_enqueue_style('synkraft_custom', SYNKRAFT_Plugin_Url . 'assets/css/main.css');
        wp_enqueue_script('jquery', SYNKRAFT_Plugin_Url . 'assets/js/jquery.min.js', false, false, true);
        wp_enqueue_script( 'synkraft_bootstrap',  SYNKRAFT_Plugin_Url . 'assets/js/bootstrap.bundle.min.js', false, false, true );
        // wp_enqueue_script('smooth-scrollbar', SYNKRAFT_Plugin_Url . 'assets/js/smooth-scrollbar.js', false, false, true);
        wp_enqueue_script( 'synkraft_custom',  SYNKRAFT_Plugin_Url . 'assets/js/main.js', false, false, true );
    }


}
