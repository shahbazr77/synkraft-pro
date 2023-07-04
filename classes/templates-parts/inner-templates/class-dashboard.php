<?php
if(!defined('ABSPATH')){
    return;
}

class SYNK_Dashboard
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
        if (!function_exists('synkraft_dashboard_content')) {
            function synkraft_dashboard_content()
            {
                $five_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/5.svg';
                $social_login_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/Social-login.svg';
                $eamil_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/email.svg';
                $cart_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/Cart.svg';
                $maximize_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/maximize-3.svg';
                $arrow_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/arrow.svg';
                $one_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/dashboard/1.svg';
                $arrow_btn_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/dashboard/arrow-btn.svg';
                $arrow_btn_one_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/dashboard/arrow-btn-1.svg';
                $two_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/dashboard/2.svg';
                $three_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/dashboard/3.svg';
                $four_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/dashboard/4.svg';

                return '<div class="data">
          <main class="dashboard">
            <p class="title">'.esc_html__( 'Features Overview', 'synkraft') .'</p>
            <hr />
            <div class="d-flex flex-wrap mt-5">
              <div class="ctm-col mb-4" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRightCon" aria-controls="offcanvasRightCon">
                <div class="feature-card">
                  <div class="d-flex justify-content-center">
                    <img class="card-img" src="'.esc_url($five_svg).'" />
                  </div>
                  <div class="card-title">'.esc_html__( 'reCapatcha', 'synkraft') .'</div>
                  <div class="activated"><i class="fa-solid fa-check"></i> <span class="text">'.esc_html__( 'Activated', 'synkraft') .'</span></div>
                </div>
              </div>
              <div class="ctm-col mb-4">
                <div class="feature-card">
                  <div class="d-flex justify-content-center">
                    <img class="card-img" src="'.esc_url($social_login_svg).'" />
                  </div>
                  <div class="card-title">'.esc_html__( 'Social Login', 'synkraft') .'</div>
                  <div class="activated"><i class="fa-solid fa-check"></i> <span class="text">'.esc_html__( 'Activated', 'synkraft') .'</span></div>
                </div>
              </div>
              <div class="ctm-col mb-4">
                <div class="feature-card">
                  <div class="d-flex justify-content-center">
                    <img class="card-img" src="'.esc_url($eamil_svg).'" />
                  </div>
                  <div class="card-title">'.esc_html__( 'Email Verification', 'synkraft') .'</div>
                  <div class="activated"><i class="fa-solid fa-check"></i> <span class="text">'.esc_html__( 'Activated', 'synkraft') .'</span></div>
                </div>
              </div>
              <div class="ctm-col mb-4">
                <div class="feature-card">
                  <div class="d-flex justify-content-center">
                    <img class="card-img" src="'.esc_url($cart_svg).'" />
                  </div>
                  <div class="card-title">'.esc_html__( 'Add to Cart Popup', 'synkraft') .'</div>
                  <div class="activated"><i class="fa-solid fa-check"></i> <span class="text">'.esc_html__( 'Activated', 'synkraft') .'</span></div>
                </div>
              </div>
              <div class="ctm-col mb-4 text-center">
                <div class="view-all">
                  <h4>'. esc_html__( 'Expand All Features', 'synkraft') .'</h4>
                  <img src="'.esc_url($maximize_svg).'" />
                </div>
              </div>
            </div>
            <!-- Modal -->

            <div id="configuration">
              <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRightCon" aria-labelledby="offcanvasRightLabelCon">
                <div class="offcanvas-header border-bottom">
                  <h5 class="offcanvas-title" id="offcanvasRightLabel">'.esc_html__( 'reCAPATCHA Configuration', 'synkraft') .'</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
                </div>
                <div class="offcanvas-body">
                  <div class="my-2 mx-2">
                    <div class="mt-4">
                      <label class="ctm-label">'.esc_html__( 'Select Type:', 'synkraft') .'</label>
                      <div class="mt-2">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="1" />
                          <label class="form-check-label" for="inlineRadio1">'.esc_html__( 'reCAPATCHA v1', 'synkraft') .'</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="2" />
                          <label class="form-check-label" for="inlineRadio2">'.esc_html__( 'reCAPATCHA v1', 'synkraft') .'</label>
                        </div>
                      </div>
                    </div>
                    <div class="mt-4">
                      <label class="ctm-label">'.esc_html__( 'Language:', 'synkraft') .'</label>
                      <div class="mt-2">
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="language" id="1" value="1" />
                          <label class="form-check-label" for="1">'.esc_html__( 'English', 'synkraft') .'</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="language" id="2" value="2" checked />
                          <label class="form-check-label" for="2">'.esc_html__( 'French', 'synkraft') .'</label>
                        </div>
                        <div class="form-check form-check-inline">
                          <input class="form-check-input" type="radio" name="language" id="3" value="3" checked />
                          <label class="form-check-label" for="3">'.esc_html__( 'Spanish', 'synkraft') .'</label>
                        </div>
                      </div>
                      <div class="mt-4">
                        <label class="ctm-label">'.esc_html__( 'Size:', 'synkraft') .'</label>
                        <div class="mt-2">
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="size" id="1" value="1" />
                            <label class="form-check-label" for="1">'.esc_html__( 'Normal', 'synkraft') .'</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="size" id="2" value="2" checked />
                            <label class="form-check-label" for="2">'.esc_html__( 'Compact', 'synkraft') .'</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="size" id="3" value="3" checked />
                            <label class="form-check-label" for="3">'.esc_html__( 'Invisible', 'synkraft') .'</label>
                          </div>
                        </div>
                      </div>
                      <div class="mt-4">
                        <label class="ctm-label"> '.esc_html__( 'Security Key:', 'synkraft') .'</label>
                        <input class="form-control border mt-2" placeholder="'.esc_attr( 'a1b2C3d4E5f6G7h8I9j0').'" />
                      </div>
                      <div class="mt-4">
                        <label class="ctm-label">'.esc_html__( 'Site Key:', 'synkraft') .'</label>
                        <input class="form-control border mt-2" placeholder="'.esc_attr( 'a1b2C3d4E5f6G7h8I9j0').'" />
                      </div>
                      <div class="mt-4">
                        <label class="ctm-label">'.esc_html__( 'URL:', 'synkraft') .'</label>
                        <input class="form-control border mt-2" placeholder="'.esc_attr( 'https://www.example.com/synkraft' ).'" />
                      </div>
                      <div class="my-4">
                        <button class="ctm-button">'. esc_html__( 'How reCAPATCHA Works?', 'synkraft') .'</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Modal -->
          </main>
          <main class="dashboard">
            <p class="title">'. esc_html__( 'How to get Started?', 'synkraft') .'</p>
            <hr />
            <div class="bg-arrow">
              <div class="d-flex justify-content-center">
                <img src="'.esc_url($arrow_svg).'" class="arrow-img" />
              </div>
              <div class="row mt-5">
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                  <div class="tutorial">
                    <div class="tut-menu">
                      <div class="d-flex justify-content-center">
                        <img class="img-tut" src="'.esc_url($one_svg).'" />
                      </div>
                      <h2>01</h2>
                      <h5>'. esc_html__( 'Install Synkraft', 'synkraft') .'</h5>
                    </div>
                    <div class="hover-style">
                      <div class="thumbnail-component">
                        <div class="text">
                          <div class="text__content">
                            <h3 class="text__description">'. esc_html__( 'Lets See', 'synkraft') .'<br />'. esc_html__( 'How it Works?', 'synkraft') .' </h3>
                            <div class="d-flex justify-content-center position-relative">
                              <a href="feature-overview.html"
        ><img class="arrow-btn" src="'.esc_url($arrow_btn_svg).'" /><img class="arrow-btn-1" src="'.esc_url($arrow_btn_one_svg).'"
        /></a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                  <div class="tutorial">
                    <div class="tut-menu">
                      <div class="d-flex justify-content-center">
                        <img class="img-tut" src="'.esc_url($two_svg).'" />
                      </div>
                      <h2>02</h2>
                      <h5>'. esc_html__( 'Select Feature', 'synkraft') .'</h5>
                    </div>
                    <div class="hover-style">
                      <div class="thumbnail-component">
                        <div class="text">
                          <div class="text__content">
                            <h3 class="text__description">'. esc_html__( 'Lets See', 'synkraft') .'<br />'. esc_html__( 'How it Works?', 'synkraft') .' </h3>
                            <div class="d-flex justify-content-center position-relative">
                              <a href="feature-overview.html"
                                ><img class="arrow-btn" src="'.esc_url($arrow_btn_svg).'" /><img class="arrow-btn-1" src="'.esc_url($arrow_btn_one_svg).'"
                              /></a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                  <div class="tutorial">
                    <div class="tut-menu">
                      <div class="d-flex justify-content-center">
                        <img class="img-tut" src="'.esc_url($three_svg).'" />
                      </div>
                      <h2>03</h2>
                      <h5>Configure Feature</h5>
                    </div>
                    <div class="hover-style">
                      <div class="thumbnail-component">
                        <div class="text">
                          <div class="text__content">
                            <h3 class="text__description">'. esc_html__( 'Lets See', 'synkraft') .'<br />'. esc_html__( 'How it Works?', 'synkraft') .' </h3>
                            <div class="d-flex justify-content-center position-relative">
                              <a href="feature-overview.html"
        ><img class="arrow-btn" src="'.esc_url($arrow_btn_svg).'" /><img class="arrow-btn-1" src="'.esc_url($arrow_btn_one_svg).'"
        /></a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-12">
                  <div class="tutorial">
                    <div class="tut-menu">
                      <div class="d-flex justify-content-center">
                        <img class="img-tut" src="'.esc_url($four_svg).'" />
                      </div>
                      <h2>04</h2>
                      <h5>All Done</h5>
                    </div>
                    <div class="hover-style">
                      <div class="thumbnail-component">
                        <div class="text">
                          <div class="text__content">
                            <h3 class="text__description">'. esc_html__( 'Lets See', 'synkraft') .'<br />'. esc_html__( 'How it Works?', 'synkraft') .' </h3>
                            <div class="d-flex justify-content-center position-relative">
                              <a href="feature-overview.html"
                                ><img class="arrow-btn" src="'.esc_url($arrow_btn_svg).'" /><img class="arrow-btn-1" src="'.esc_url($arrow_btn_one_svg).'"
                              /></a>
                            </div>
                          </div>
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





















