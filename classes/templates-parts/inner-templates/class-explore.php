<?php
if(!defined('ABSPATH')){
    return;
}

class SYNK_Explore
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
        if (!function_exists('synkraft_explore_content')) {
            function synkraft_explore_content()
            {
                $group_png = SYNKRAFT_Plugin_Url . 'assets/css/images/group.png';
                $setting_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/setting.svg';
                $info_circle_svg = SYNKRAFT_Plugin_Url . 'assets/css/icons/info-circle.svg';
                return '<div class="filters">
          <div class="dropdown">
            <button class="dropdown-toggl" type="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="bi bi-funnel-fill"></i> '.esc_html__('Filters','synkraft').' <i class="bi bi-chevron-down"></i></button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">'.esc_html__('Action','synkraft').'</a></li>
              <li><a class="dropdown-item" href="#">'.esc_html__('Another action','synkraft').'</a></li>
              <li><a class="dropdown-item" href="#">'.esc_html__('Something else here','synkraft').'</a></li>
            </ul>
          </div>
          <div class="view">
            <p>View</p>
            <button class="view-btn"><i class="bi bi-grid"></i></button>
            <button class="view-btn"><i class="bi bi-list-ul"></i></button>
          </div>
        </div>
        <div class="data mt-4">
          <div class="accord-item">
            <div class="accord-main" onclick="handleClick("tools")">
              <div class="img-data">
                <div class="bg-color">
                  <img class="main-img-accord" src="'.esc_url($group_png).'">
                </div>
                <div class="img-text">
                  <h6>'.esc_html__('reCaptcha for WooCommerce','synkraft').'</h6>
                  <p>
                    <small class="img-text-clr">'.esc_html__('This will enable users to add reCAPTCHA boxes into the:','synkraft').'<br>'
                    .esc_html__('1. WooCommerce Login Page 2. Account Registration Page 3. Checkout Page 4. WP-ADMIN Login page','synkraft').'</small>
                  </p>
                </div>
              </div>
              <div class="data-btn">
                <div class="d-flex">
                  <button class="btn-custom-grey mb-2">
                    <span class="text-hover"><img src="'.esc_url($setting_svg).'"> </span>
                    <span class="detail">&nbsp;'.esc_html__('Configuration','synkraft').'</span>
                  </button>

                  <div class="btn-custom-grey w-auto px-3 mb-2 ms-2 tooltip-1">
                    <img src="'.esc_url($info_circle_svg).'">
                    <span class="tooltiptext-1">'.esc_html__('See Info','synkraft').'</span>
                  </div>
                </div>
                <button class="btn-custom">'.esc_html__('Activate','synkraft').'</button>
              </div>
            </div>
            <div id="tools" class="accordion-content">
              <div class="accord-inner">
                <p>'.esc_html__('This will enable users to add reCAPTCHA boxes into the:','synkraft').'</p>
                <ul>
                  <li>'.esc_html__('WooCommerce Login Page','synkraft').'</li>
                  <li>'.esc_html__('Account Registration Page','synkraft').'</li>
                  <li>'.esc_html__('Checkout Page','synkraft').'</li>
                  <li>'.esc_html__('WP-ADMIN Login page','synkraft').'</li>
                </ul>
                <p>'.esc_html__('Select Type','synkraft').'</p>
                <div class="d-flex">
                  <div class="form-check me-4">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                    <label class="form-check-label" for="flexRadioDefault1"> '.esc_html__('reCAPTCHA V2','synkraft').' </label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" checked="">
                    <label class="form-check-label" for="flexRadioDefault2"> '.esc_html__('reCAPTCHA V2','synkraft').' </label>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="accord-item">
            <div class="accord-main">
              <div class="img-data">
                <div class="bg-color">
                  <img class="main-img-accord" src="'.esc_url($group_png).'">
                </div>
                <div class="img-text">
                  <h6>'.esc_html__('reCaptcha for WooCommerce','synkraft').'</h6>
                  <p>
                    <small class="img-text-clr">'.esc_html__('This will enable users to add reCAPTCHA boxes into the:','synkraft').'<br>
                    '.esc_html__('1.WooCommerce Login Page 2.Account Registration Page 3.Checkout Page 4. WP-ADMIN Login page','synkraft').'</small>
                  </p>
                </div>
              </div>
              <div class="data-btn">
                <div class="d-flex">
                  <button class="btn-custom-grey mb-2">
                    <span class="text-hover"><img src="'.esc_url($setting_svg).'"> </span>
                    <span class="detail">'.esc_html__('&nbsp;Configuration','synkraft').'</span>
                  </button>
                  <div class="btn-custom-grey w-auto px-3 mb-2 ms-2 tooltip-1">
                    <img src="'.esc_url($info_circle_svg).'">
                    <span class="tooltiptext-1">'.esc_html__('See Info','synkraft').'</span>
                  </div>
                </div>
                <button class="btn-custom">'.esc_html__('Activate','synkraft').'</button>
              </div>
            </div>
            <div id="tools" class="accordion-content">
              <div class="accord-inner">
                <p class="mb-4">'.esc_html__('Why use this extension?','synkraft').'</p>
                <div class="inner-text">
                  <span><strong>'.esc_html__('Avoid Account Registration Spam','synkraft').'</strong> – '.esc_html__('require email verification from customers that register an account on your store or membership site and prevent access to the
                    account area from customers that sign up with fake email addresses just to check around or to get the free trial access.','synkraft').'</span>
                </div>
                <div class="inner-text">
                  <span><strong>'.esc_html__('Avoid Fake Orders','synkraft').'</strong> – '.esc_html__('Validating the email before the order can be placed is extremely useful when you sell digital products, memberships and offer free trials,
                    free products and samples.','synkraft').'</span>
                </div>
                <div class="inner-text">
                  <span><strong>'.esc_html__('Avoid Bouncing Emails','synkraft').'</strong> – '.esc_html__('avoid bouncing of undelivered “new account” and order emails due to typos in the email address. The new account emails are delayed until
                    successful verification.','synkraft').'</span>
                </div>
                <div class="inner-text">
                  <span><strong>'.esc_html__('Fully Customize the Email Verification workflow','synkraft').'</strong> – '.esc_html__('Personalize and edit the content of the verification workflows and customize the design of the verification
                    popup overlay using a customizer with a live preview.','synkraft').'</span>
                </div>
                <div class="inner-text">
                  <span>'.esc_html__('<strong>Easily manage and delete Unverified customers','synkraft').'</strong> – '.esc_html__('you can easily verify or resend the verification email to customers from the users admin, you can also delete all
                    unverified customers at once or schedule auto-delete unverified customers after a certain time from when the account was created.','synkraft').'</span>
                </div>
              </div>
            </div>
          </div>
          <div class="accord-item">
            <div class="accord-main">
              <div class="img-data">
                <div class="bg-color">
                  <img class="main-img-accord" src="'.esc_url($group_png).'">
                </div>
                <div class="img-text">
                  <h6>'.esc_html__('reCaptcha for WooCommerce','synkraft').'</h6>
                  <p>
                    <small class="img-text-clr">'.esc_html__('This will enable users to add reCAPTCHA boxes into the:','synkraft').'<br>
                    '.esc_html__('1.WooCommerce Login Page 2.Account Registration Page 3.Checkout Page 4. WP-ADMIN Login page','synkraft').'</small>
                  </p>
                </div>
              </div>
              <div class="data-btn">
                <div class="d-flex">
                  <button class="btn-custom-grey mb-2">
                    <span class="text-hover"><img src="'.esc_url($setting_svg).'"> </span>
                    <span class="detail">&nbsp;'.esc_html__('Configuration','synkraft').'</span>
                  </button>

                  <div class="btn-custom-grey w-auto px-3 mb-2 ms-2 tooltip-1">
                    <img src="'.esc_url($info_circle_svg).'">
                    <span class="tooltiptext-1">'.esc_html__('See Info','synkraft').'</span>
                  </div>
                </div>
                <button class="btn-custom">'.esc_html__('Activate','synkraft').'</button>
              </div>
            </div>
            <div id="tools" class="accordion-content">
              <div class="accord-inner">
                <p class="mb-2">'.esc_html__('What the plugin does?','synkraft').'</p>
                <div class="inner-text">
                  <span>'.esc_html__('Makes the login, registration and password reset processes easier during the checkout and reduces the cart abandonment rate.','synkraft').'</span>
                </div>
                <p>'.esc_html__('How you can benefit from it:','synkraft').'</p>
                <ul>
                  <li>'.esc_html__('Give your customers a usable, modern and quick solution to log in or register a new account in your e-commerce shop during the checkout.','synkraft').'</li>
                  <li>'.esc_html__('Make the password reset process much easier with a usable solution inspired to the one available on Amazon.','synkraft').'</li>
                  <li>'.esc_html__('Reduce the number of abandoned carts by letting users recover their password and complete the purchase without leaving the checkout process.','synkraft').'</li>
                </ul>
              </div>
            </div>
          </div>
          <div class="accord-item">
            <div class="accord-main">
              <div class="img-data">
                <div class="bg-color">
                  <img class="main-img-accord" src="'.esc_url($group_png).'">
                </div>
                <div class="img-text">
                  <h6>'.esc_html__('reCaptcha for WooCommerce','synkraft').'</h6>
                  <p>
                    <small class="img-text-clr">'.esc_html__('This will enable users to add reCAPTCHA boxes into the:','synkraft').'<br>
                    '.esc_html__('1.WooCommerce Login Page 2.Account Registration Page 3.Checkout Page 4. WP-ADMIN Login page','synkraft').'</small>
                  </p>
                </div>
              </div>
              <div class="data-btn">
                <div class="d-flex">
                  <button class="btn-custom-grey mb-2">
                    <span class="text-hover"><img src="'.esc_url($setting_svg).'"> </span>
                    <span class="detail">&nbsp;'.esc_html__('Configuration','synkraft').'</span>
                  </button>

                  <div class="btn-custom-grey w-auto px-3 mb-2 ms-2 tooltip-1">
                    <img src="'.esc_url($info_circle_svg).'">
                    <span class="tooltiptext-1">'.esc_html__('See Info','synkraft').'</span>
                  </div>
                </div>
                <button class="btn-custom">'.esc_html__('Activate','synkraft').'</button>
              </div>
            </div>
            <div id="tools" class="accordion-content">
              <div class="accord-inner">
                <p class="mb-2">'.esc_html__('Customize your Checkout Fields via your admin panel','synkraft').'</p>
                <div class="inner-text">
                  <span>'.esc_html__('The checkout field editor provides you with an interface ','synkraft').'<strong>'.esc_html__('to add, edit, and remove fields shown on your WooCommerce checkout','synkraft').'</strong>'.esc_html__(' page. Fields can be added and removed
                    from the billing and shipping sections, as well as inserted after these sections next to the standard ‘order notes’.','synkraft').'</span>
                </div>
                <div><span>'.esc_html__('The editor supports several types for custom fields including text, select, checkboxes, and datepickers.','synkraft').'</span></div>
                <div class="accord-card">
                  <div class="date-text"><span>'.esc_html__('Delivery Date','synkraft').'</span> <span class="text-danger">*</span></div>
                  <div class="date-box">14 August, 2022</div>
                </div>
                <div><span>'.esc_html__('Core fields can also be moved around giving you more control over your checkout without touching the code.','synkraft').'</span></div>
              </div>
            </div>
          </div>
          <div class="accord-item">
            <div class="accord-main">
              <div class="img-data">
                <div class="bg-color">
                  <img class="main-img-accord" src="'.esc_url($group_png).'">
                </div>
                <div class="img-text">
                  <h6>'.esc_html__('reCaptcha for WooCommerce','synkraft').'</h6>
                  <p>
                    <small class="img-text-clr">'.esc_html__('This will enable users to add reCAPTCHA boxes into the:','synkraft').'<br>
                    '.esc_html__('1.WooCommerce Login Page 2.Account Registration Page 3.Checkout Page 4. WP-ADMIN Login page','synkraft').'</small>
                  </p>
                </div>
              </div>
              <div class="data-btn">
                <div class="d-flex">
                  <button class="btn-custom-grey mb-2">
                    <span class="text-hover"><img src="'.esc_url($setting_svg).'"> </span>
                    <span class="detail">&nbsp;'.esc_html__('Configuration','synkraft').'</span>
                  </button>

                  <div class="btn-custom-grey w-auto px-3 mb-2 ms-2 tooltip-1">
                    <img src="'.esc_url($info_circle_svg).'">
                    <span class="tooltiptext-1">'.esc_html__('See Info','synkraft').'</span>
                  </div>
                </div>
                <button class="btn-custom">'.esc_html__('Activate','synkraft').'</button>
              </div>
            </div>
            <div id="tools" class="accordion-content">
              <div class="accord-inner">
                <p class="mb-2">'.esc_html__('Customize your Checkout Fields via your admin panel','synkraft').'</p>
                <div class="inner-text">
                  <span>'.esc_html__('The checkout field editor provides you with an interface ','synkraft').'<strong>'.esc_html__('to add, edit, and remove fields shown on your WooCommerce checkout','synkraft').'</strong> '.esc_html__('page. Fields can be added and removed
                    from the billing and shipping sections, as well as inserted after these sections next to the standard ‘order notes’.','synkraft').'</span>
                </div>
                <div><span>'.esc_html__('The editor supports several types for custom fields including text, select, checkboxes, and datepickers.','synkraft').'</span></div>
                <div class="accord-card">
                  <div class="date-text"><span>'.esc_html__('Delivery Date','synkraft').'</span> <span class="text-danger">*</span></div>
                  <div class="date-box">14 August, 2022</div>
                </div>
                <div><span>'.esc_html__('Core fields can also be moved around giving you more control over your checkout without touching the code.','synkraft').'</span></div>
              </div>
            </div>
          </div>
          <div class="accord-item">
            <div class="accord-main">
              <div class="img-data">
                <div class="bg-color">
                  <img class="main-img-accord" src="'.esc_url($group_png).'">
                </div>
                <div class="img-text">
                  <h6>'.esc_html__('reCaptcha for WooCommerce','synkraft').'</h6>
                  <p>
                    <small class="img-text-clr">'.esc_html__('This will enable users to add reCAPTCHA boxes into the:','synkraft').'<br>
                    '.esc_html__('1.WooCommerce Login Page 2.Account Registration Page 3.Checkout Page 4. WP-ADMIN Login page','synkraft').'</small>
                  </p>
                </div>
              </div>
              <div class="data-btn">
                <div class="d-flex">
                  <button class="btn-custom-grey mb-2">
                    <span class="text-hover"><img src="'.esc_url($setting_svg).'"> </span>
                    <span class="detail">&nbsp;'.esc_html__('Configuration','synkraft').'</span>
                  </button>

                  <div class="btn-custom-grey w-auto px-3 mb-2 ms-2 tooltip-1">
                    <img src="'.esc_url($info_circle_svg).'">
                    <span class="tooltiptext-1">'.esc_html__('See Info','synkraft').'</span>
                  </div>
                </div>
                <button class="btn-custom">'.esc_html__('Activate','synkraft').'</button>
              </div>
            </div>
            <div id="tools" class="accordion-content">
              <div class="accord-inner">
                <p class="mb-2">'.esc_html__('Customize your Checkout Fields via your admin panel','synkraft').'</p>
                <div class="inner-text">
                  <span>'.esc_html__('The checkout field editor provides you with an interface ','synkraft').'<strong>'.esc_html__('to add, edit, and remove fields shown on your WooCommerce checkout</strong> page. Fields can be added and removed
                    from the billing and shipping sections, as well as inserted after these sections next to the standard ‘order notes’.','synkraft').'</span>
                </div>
                <div><span>'.esc_html__('The editor supports several types for custom fields including text, select, checkboxes, and datepickers.','synkraft').'</span></div>
                <div class="accord-card">
                  <div class="date-text"><span>'.esc_html__('Delivery Date','synkraft').'</span> <span class="text-danger">*</span></div>
                  <div class="date-box">14 August, 2022</div>
                </div>
                <div><span>'.esc_html__('Core fields can also be moved around giving you more control over your checkout without touching the code.','synkraft').'</span></div>
              </div>
            </div>
          </div>
        </div>';
            }
        }
    }
}
