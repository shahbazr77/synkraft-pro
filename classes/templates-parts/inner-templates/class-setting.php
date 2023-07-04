<?php
if(!defined('ABSPATH')){
    return;
}

class SYNK_Setting
{

    public static $instance = null;

    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct()
    {
        if (!function_exists('synkraft_setting_content')) {
            function synkraft_setting_content()
            {
                $group_png = SYNKRAFT_Plugin_Url . 'assets/css/images/group.png';
                return '        <div class="data">
          <main class="screen">
            <p class="screen-title">'.esc_html__('Settings','synkraft').'</p>
            <hr />
            <div class="setting-details">
              <div class="row">
                <div class="col-sm-6">
                  <div class="accord-item">
                    <div class="accord-main">
                      <div class="img-data">
                        <div class="bg-color setting">
                          <img class="main-img-accord-setting" src="'.esc_url($group_png).'" />
                        </div>
                        <div class="img-text pt-3 pe-3">
                          <h6 class="mb-0">'.esc_html__('Auto Updates','synkraft').'</h6>
                          <p class="mb-1">
                            <small class="img-text-clr">'.esc_html__('Turn on automatic plugin updates','synkraft').'</small>
                          </p>
                        </div>
                      </div>
                      <div class="data-btn">
                        <div class="d-flex">
                          <small class="align-self-center me-1 text-mute">'.esc_html__('(Enable/Disable)','synkraft').'</small>
                          <label class="switch">
                            <input type="checkbox" />
                            <span class="slider round"></span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-6">
                  <div class="accord-item">
                    <div class="accord-main">
                      <div class="img-data">
                        <div class="bg-color setting">
                          <img class="main-img-accord-setting" src="'.esc_url($group_png).'" />
                        </div>
                        <div class="img-text pt-3 pe-3">
                          <h6 class="mb-0">Auto Update</h6>
                          <p class="mb-1 img-text-clr">'.esc_html__('Allow usage data sharing for improving','synkraft').'</p>
                        </div>
                      </div>
                      <div class="data-btn">
                        <div class="d-flex">
                          <small class="align-self-center me-1 text-mute">'.esc_html__('(Allow/Deny)','synkraft').'</small>
                          <label class="switch">
                            <input type="checkbox" checked />
                            <span class="slider round"></span>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </main>
        </div>';
            }
        }

    }
}
