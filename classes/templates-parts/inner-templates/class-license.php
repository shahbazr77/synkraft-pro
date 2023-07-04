<?php
if(!defined('ABSPATH')){
    return;
}

class SYNK_License{

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
        if (!function_exists('synkraft_license_content')) {
            function synkraft_license_content()
            {
                return '<div class="data">
    <main class="dashboard">
        <p class="title">'.esc_html__('License Overview','synkraft').'</p>
        <hr/>
        <div class="d-flex flex-wrap mt-5">
        <form>
       <div class="form-group col-sm-6">
        <input style="border:1px solid #0c0c0c !important;" type="email" class="my-2 form-control" id="exampleInputEmail1" value="yodo@test.com"  placeholder="'.esc_attr( 'Enter Email' ).'">
        <input style="border:1px solid #0c0c0c !important;" type="password" class="my-2 form-control" id="exampleInputPassword"  placeholder=
        '.esc_attr( 'Enter password').'>

        </div>  
        <button type="submit" class="my-2 btn btn-primary">'.esc_html__('Connect','synkraft').'</button>
        
        <small id="emailHelp" class="d-block form-text text-muted">
        '.esc_html__( 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled','synkraft').'</small>
         </div>
       </form>
        </div>
    </main>
</div>';

            }
        }

    }
}