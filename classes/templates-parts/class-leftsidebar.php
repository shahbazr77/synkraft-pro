<?php
if(!defined('ABSPATH')){
  return;
}

class SYNK_Left_Sidebar{

    public static $instance=null;

    public static function get_instance(){
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct(){

        if (!function_exists('synkraft_sidebar_menu')) {
            function synkraft_sidebar_menu()
            {
                $active_class="";

                $dashboard_logo = SYNKRAFT_Plugin_Url . 'assets/css/icons/logo.png';
                $home_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/Home.svg';
                $update_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/updates.svg';
                $order_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/order.svg';
                $preference_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/preference.svg';
                $cube_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/cube.svg';
                $coupons_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/coupons.svg';
                $cash_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/cash.svg';
                $license_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/license.svg';
                $setting_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/setting.svg';
                $bot_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/bot.svg';
                $help_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/help.svg';
                $admin_url=get_admin_url();
                $dashbard_page_url = menu_page_url('synkraft.php', false);
                $update_page_url = menu_page_url('synkupdate.php', false);
                $order_page_url = menu_page_url('synkorder.php', false);
                $preference_page_url = menu_page_url('synkprefer.php', false);
                $license_page_url = menu_page_url('synklicense.php', false);
                $coupon_page_url = menu_page_url('synkcoupons.php', false);
                $payment_page_url = menu_page_url('synkpayments.php', false);
                $setting_page_url = menu_page_url('synksettings.php', false);
                $systeminfo_page_url = menu_page_url('synksysteminfo.php', false);
                $explore_page_url = menu_page_url('synkexplore.php', false);
                global $pagenow;
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkraft.php') {
                    $dashboard_active="active";
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkupdate.php') {
                    $synupdate_active="active";
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkorder.php') {
                    $synorder_active="active";
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkprefer.php') {
                    $synkprefer_active="active";
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synklicense.php') {
                    $synklicense_active="active";
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkcoupons.php') {
                    $synkcoupons_active="active";
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkpayments.php') {
                    $synkpayments_active="active";
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synksettings.php') {
                    $synksetting_active="active";
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synksysteminfo.php') {
                    $synksysteminfo_active="active";
                }
                if ($pagenow === 'admin.php' && isset($_GET['page']) && $_GET['page'] === 'synkexplore.php') {
                    $synkexplore_active="active";
                }



                return '<div class="position-relative sidebar-scroll">
        <div id="menuSidebar" class="sidebar">
            <a href="javascript:void(0)" class="closebtn" id="toggleButton1" onclick="closeNav();"> <i class="bi bi-arrow-left-circle-fill"></i></a>
            <div class="menu-list">
                <a href="'.esc_url($dashbard_page_url).'" class="logo"><img src="'.esc_url($dashboard_logo).'" /></a>
                <div class="mt-5 mb-4">
                    <a href="'.$admin_url.'" class="wordpress-btn"> <i class="vs-icon vs-icon-home"></i> Back to the Wordpress</a>
                </div>
                <a href="'. esc_url( $dashbard_page_url) .'" class="menu-item '.$dashboard_active.'"> <img src="'.esc_url($home_svg).'" /> <span> '. esc_html__('Dashboard','synkraft').'</span> </a>
                <a href="'. esc_url( $explore_page_url) .'" class="menu-item '.$synkexplore_active.' "> <img src="'.esc_url($home_svg).'"> <span> '. esc_html__('Explore','synkraft').'</span> </a>
                <a href="'. esc_url( $update_page_url) .'" class="menu-item '.$synupdate_active.'"> <img src="'.esc_url($update_svg).'" /> <span> '. esc_html__('Updates','synkraft').'</span> </a>
                <hr />
                <a href="'. esc_url( $order_page_url) .'" class="menu-item '.$synorder_active.'"> <img src="'.esc_url($order_svg).'" /> <span> '. esc_html__('Orders','synkraft').'</span> </a>
                <a href="'. esc_url( $preference_page_url) .'" class="menu-item '.$synkprefer_active.'"> <img src="'.esc_url($preference_svg).'" /> <span> '. esc_html__('Preference','synkraft').'</span> </a>
                <a href="'. esc_url( $license_page_url) .'" class="menu-item '.$synklicense_active.'"> <img src="'.esc_url($cube_svg).'" /> <span> '. esc_html__('License','synkraft').'</span> </a>
                <a href="'. esc_url( $coupon_page_url) .'" class="menu-item '.$synkcoupons_active.'"> <img src="'.esc_url($coupons_svg).'" /> <span> '. esc_html__('Coupons','synkraft').'</span> </a>
                <a href="'. esc_url( $payment_page_url) .'" class="menu-item '.$synkpayments_active.'"> <img src="'.esc_url($cash_svg).'" /> <span> '. esc_html__('Payments','synkraft').'</span> </a>
                <a href="'. esc_url( $setting_page_url) .'" class="menu-item '.$synksetting_active.'"> <img src="'.esc_url($setting_svg).'" /> <span> '. esc_html__('Settings','synkraft').'</span> </a>
                  <div class="upgrade-pro">
                    <div class="text-area">
                      <h2>Upgrade to Pro</h2>
                      <button class="price-btn">'.esc_html__('See Pricing','synkraft').'</button>
                    </div>
                    <img class="bot-img" src="'.esc_url($bot_svg).'" />
                  </div>
                <a href="'. esc_url( $systeminfo_page_url) .'" class="menu-item '.$synksysteminfo_active.'"> <img src="'.esc_url($help_svg).'" /> <span>'.esc_html__('System info','synkraft').'</span> </a>
                <a href="#" class="menu-item last-item"> <img src="'.esc_url($help_svg).'" /> <span>'.esc_html__('Want some help?','synkraft').'</span> </a>
            </div>
        </div>
    </div>
    <button class="openbtn d-none d-lg-block" id="toggleButton" onclick="openNav()"><i class="bi bi-view-list"></i></button>';
            }
        }



    }

}





