<?php
if(!defined('ABSPATH')){
    return;
}

class SYNK_Update
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
        if (!function_exists('synkraft_update_content')) {
            function synkraft_update_content()
            {
                return '<div class="data">
    <main class="dashboard">
        <p class="title">'.esc_html__('Update Overview','synkraft').'</p>
        <hr />
        <div class="d-flex flex-wrap mt-5">
          <table class="table">
             <thead class="table-light">
                <tr>
                  <th scope="col">'.esc_html__('Product Name','synkraft').'</th>
                  <th scope="col">'.esc_html__('Version','synkraft').'</th>
                  <th scope="col">'.esc_html__('Action','synkraft').'</th>
                </tr>
             </thead>
              <tbody>
             <tr>
              <td>'.esc_html__('Yodo Product-1','synkraft').' </td>
              <td>3.05</td>
              <td><button type="button" class="btn btn-primary">'.esc_html__('Update','synkraft').'</button></td>
             </tr>
            <tr>
              <td>Yodo Product-2</td>
              <td>3.06</td>
              <td><button type="button" class="btn btn-primary">'.esc_html__('Update','synkraft').'</button></td>
            </tr>
          </tbody>
          </table>
        </div>
    </main>
</div>';

            }
        }

    }
}
