<?php
if(!defined('ABSPATH')){
    return;
}

class SYNK_Header_Strip{

    public static $instance=null;

    public static function get_instance(){
        if(self::$instance===null){
            self::$instance=new self();
        }
        return self::$instance;
    }

    public function __construct(){
        if (!function_exists('synkraft_header_strip')) {
            function synkraft_header_strip()
            {
                $message_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/messages.svg';
                $notification_bing_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/notification-bing.svg';
                $notification_png = SYNKRAFT_Plugin_Url . 'assets/css/icons/notification.png';
                $profile_png = SYNKRAFT_Plugin_Url . 'assets/css/icons/menu-item/profile.png';
                $group_png = SYNKRAFT_Plugin_Url . 'assets/css/images/group.png';

                return '<div class="header">
          <div class="row">
            <div class="col-xl-9 col-lg-7">
              <div class="d-flex justify-content-between">
                <button class="mobile-closebtn d-lg-none d-block" id="toggleButton" onclick="openNav()"><i class="bi bi-view-list"></i></button>
                <div class="autocomplete w-100">
                  <div class="search-input">
                    <div class="align-self-center">
                      <i class="bi bi-search"></i>
                    </div>
                    <input id="search-sugg" class="form-control" type="text" name="search" placeholder="'.esc_attr__("Search",'synkraft').'" />
                    <button class="cancel-btn" onclick="document.getElementById("search-sugg").value ="""><i class="fa-regular fa-circle-xmark"></i>'.esc_html__("Cancel",'synkraft').'</button>
                  </div>
                  <div class="search-suggestion">
                    <div class="search-data">
                      <h6 class="mt-1 mb-4"><span>"2" </span>'.esc_html__("Search Results",'synkraft').' </h6>
                      <div class="row mx-0 px-0">
                        <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                          <div class="search-card">
                            <img src="'.esc_url($group_png).'" />
                            <p>'.esc_html__("Login/Sign Up Popup",'synkraft').'</p>
                          </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-md-6 col-12">
                          <div class="search-card">
                            <img src="'.esc_url($group_png).'" />
                            <p>'.esc_html__("Login/Sign Up Popup",'synkraft').'</p>
                          </div>
                        </div>
                      </div>
                      <button class="btn-search-sugg">'.esc_html__("See All ",'synkraft').'<i class="fa-solid fa-arrow-right"></i></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-5 align-self-center">
              <div class="header-options">
                <div class="split-button">
                  <button class="option-btn msg" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                    <img src="'.esc_url($message_svg).'" />&nbsp;<span>'.esc_html__("Feedback?",'synkraft').'</span>
                  </button>
                  <!-- Side Doc -->
                  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                    <div class="offcanvas-header">
                      <h5 class="offcanvas-title" id="offcanvasRightLabel">'.esc_html__("Feedback",'synkraft').'</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">...</div>
                  </div>
                </div>
                <div class="notification-btn">
                  <button onclick="notificationBtn()" class="option-btn notifi mx-1"><img src="'.esc_url($notification_bing_svg).'" /></button>
                  <div id="notification" class="notification-menu">
                    <h4 class="mb-0">'.esc_html__("Notification",'synkraft').'</h4>
                    <div>
                      <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="all" data-bs-toggle="tab" data-bs-target="#all-pane" type="button" role="tab" aria-controls="all-pane" aria-selected="true">
                            '.esc_html__("All Notification",'synkraft').'
                          </button>
                        </li>
                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="unread" data-bs-toggle="tab" data-bs-target="#unread-pane" type="button" role="tab" aria-controls="unread-pane" aria-selected="false">
                             '.esc_html__("Unread Notification",'synkraft').'
                          </button>
                        </li>
                      </ul>
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="all-pane" role="tabpanel" aria-labelledby="all" tabindex="0">
                          <div class="p-4 notifications">
                            <div class="d-flex justify-content-center mb-3">
                              <img src="'.esc_url($notification_png).'" />
                            </div>
                            <div>
                              <h5 class="">'.esc_html__("No New Notfification yet",'synkraft').'</h5>
                              <p>'.esc_html__("Check this section for updates, exclusive and general notifications.",'synkraft').'</p>
                            </div>
                          </div>
                          <a class="btn-notification mt-3">'.esc_html__("See all Notifications",'synkraft').'</a>
                        </div>
                        <div class="tab-pane fade" id="unread-pane" role="tabpanel" aria-labelledby="unread" tabindex="0">
                          <div class="p-4 notifications">
                            <div class="d-flex justify-content-center mb-3">
                              <img src="'.esc_url($notification_png).'" />
                            </div>
                            <div>
                              <h5 class="">'.esc_html__("No New Notfification yet",'synkraft').'</h5>
                              <p>'.esc_html__("Check this section for updates, exclusive and general notifications.",'synkraft').'</p>
                            </div>
                          </div>
                          <a class="btn-notification mt-3">'.esc_html__("See all Notifications",'synkraft').'</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="dropdown position-relative">
                  <button class="option-btn user" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="'.esc_url($profile_png).'" />
                  </button>
                  <ul class="dropdown-menu">
                    <div>
                      <div class="user-detail">
                        <img src="'.esc_url($profile_png).'" />
                        <div class="ps-2 align-self-center">
                          <h6 class="mb-0">Itachi Uchiha</h6>
                          <p class="mb-0 text-mute">'.esc_html__("email@example.com",'synkraft').'</p>
                        </div>
                      </div>
                      <div class="price-plan">
                        <div>
                          <p class="mb-0">
                            '.esc_html__("Current plan:",'synkraft').'
                            <span class="ctm-badge">'.esc_html__("Free",'synkraft').'</span>
                          </p>
                        </div>
                      </div>
                    </div>
                    <li>
                      <a class="dropdown-item one" href="#">'.esc_html__("UNLOCK ALL FEATURES WITH PRO",'synkraft').' &nbsp; <i class="fa-solid fa-arrow-right"></i> </a>
                    </li>
                    <li>
                      <a class="dropdown-item border-bottom" href="account.html"
                        ><div class="d-flex justify-content-between">
                          <div>'.esc_html__("Manage my account",'synkraft').'</div>
                          <div><i class="fa-solid fa-arrow-up-right-from-square"></i></div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item ctm" href="#"
                        ><div class="d-flex justify-content-between">
                          <div>'.esc_html__("Theme",'synkraft').'</div>
                          <div><i class="fa-solid fa-arrow-right"></i></div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item ctm" href="#"
                        ><div class="d-flex justify-content-between">
                          <div>'.esc_html__("Help Center",'synkraft').'</div>
                          <div><i class="fa-solid fa-arrow-right"></i></div>
                        </div>
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item logout" href="#"
                        ><div class="d-flex justify-content-between">
                          <div>'.esc_html__("Logout",'synkraft').'</div>
                          <div><i class="fa-solid fa-arrow-right-from-bracket fa-rotate-180"></i></div>
                        </div>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>';
            }
        }


    }




}









