<?php
/**
 ** Synk Pro Support function 
 **/
if(!defined('ABSPATH')) {
    return;
}
class SYNK_Support_Function_pro{
    protected static $instance = null;
    public static function get_instance(){
        if(self::$instance===null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct(){
        function get_plugins_logo_img_pro(){
            $plugin_url = plugins_url();
            $plugin_logo =array();
            // Define the relative path to the 'assets/images/' directory inside 'addons' folder
            $relative_image_path = '/synkraft-pro/addons-pro/*/assets/images/screen.png';
            // Use glob() to find all matching image files in different plugin folders
            $image_files = glob(WP_PLUGIN_DIR . $relative_image_path);
            $valu_index=0;
            // Display the images
            foreach ($image_files as $image_file) {
                // $total_index="name".$valu_index;
                $image_url = str_replace(WP_PLUGIN_DIR, $plugin_url, $image_file);
                $plugin_logo["plugin_png".$valu_index] = $image_url; // Push data into the $plugin_logo array
                $valu_index ++;
            }
            return $plugin_logo;
        }
    }
}