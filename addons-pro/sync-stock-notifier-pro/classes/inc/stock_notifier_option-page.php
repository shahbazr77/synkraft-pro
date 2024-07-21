<?php
/*
* Stock Notifier Pro Option Page
*/ 
class Woo_stock_notifier_pro {
    public static $instance=null;
    //Get instance
    public static function get_instance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct() {
    add_action('admin_menu', array($this, 'add_settings_page_pro'));
    add_action('admin_init', array($this, 'register_settings_pro'));
    add_action('wp_ajax_wc_send_stock_back_notification_email', array($this, 'send_emails_callback_pro'));
    add_action('admin_init', array($this, 'handle_stock_notifier_export_csv_pro'));

        }

    public function add_settings_page_pro() {
        add_menu_page(
            'Stock Notifier Reminder',  
            'Stock Notifier', 
            'manage_options', 
            'stock-notifier', 
            array($this, 'stock_notifer_page_callback'), 
            'dashicons-list-view',  
            50 
        );

        add_submenu_page(
            'stock-notifier',
            'General Settings',
            'General Settings',
            'manage_options',
            'stock-notifier-general',
            array($this, 'stock_notifier_general_page')
        );
        
        add_submenu_page(
            'stock-notifier',
            'Users Data',
            'Users Data',
            'manage_options',
            'stock-notifier-users',
            array($this, 'stock_notifier_users_page')
        );
    }



   
    public function stock_notifer_page_callback() {

    if (!class_exists('WooCommerce')) {
        $plugin_name = 'Synkraft Stock Notifier';
        echo '<h4 style="font-size:23px;">'.$plugin_name.'</h4>';
        $woocommerce_url = 'https://wordpress.org/plugins/woocommerce/';

        $notice = sprintf(
            '%s plugin requires <a href="%s" target="_blank">WooCommerce</a> plugin to be installed and activated.',
            esc_html($plugin_name),
            esc_url($woocommerce_url)
        );

        echo wp_kses_post('<div class="notice notice-error"><p>' . $notice . '</p></div>');
    } else {
        // $active_tab = isset($_GET['tab']) ? $_GET['tab'] : '';

        // $isPluginPage = isset($_GET['plugin_name']) && $_GET['plugin_name'] === 'Synkraft+Stock+Notifications';
        // $plugin_class_name = isset($_GET['plugin_class_name']) && $_GET['plugin_class_name'] === 'Woo_stock_notifier';

        // $plugin_class_function = isset($_GET['plugin_class_function']) && $_GET['plugin_class_function'] === 'stock_notifer_page_callback_pro';
        

    
        
        $isPluginPage = isset($_GET['page']) && $_GET['page'] === 'featuresetting.php' && isset($_GET['plugin_name']) && $_GET['plugin_name'] === 'Synkraft+Stock+Notifications+Pro' && isset($_GET['plugin_class_name']) && $_GET['plugin_class_name'] === 'Woo_stock_notifier';
        
        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'stock-notifier-general';
?>
<div class="wrap">
    <p class="bread-crumb-opt"><?php echo esc_html__('Synkraft Low Stock Notifications', 'Synkraft Stock Notifier');?></p>
    <ul class="sub-menu">
        <?php echo  $isPluginPage;?>
        <li><a href="?page=featuresetting.php&plugin_name=Synkraft+Stock+Notifications&plugin_class_name=Woo_stock_notifier_pro&plugin_class_function=stock_notifer_page_callback_pro&tab=stock-notifier-general" class="<?php echo ($active_tab && $active_tab === 'stock-notifier-general') ? 'current btn-custom' : 'btn-custom-grey-1'; ?>"><?php echo esc_html__('General Settings', 'woocommerce-stock-notifications');?></a></li>
     
        <li><a href="?page=featuresetting.php&plugin_name=Synkraft+Stock+Notifications&plugin_class_name=Woo_stock_notifier_pro&plugin_class_function=stock_notifer_page_callback_pro&tab=users-data" class="<?php echo ($active_tab && $active_tab === 'users-data') ? 'current btn-custom' : 'btn-custom-grey-1'; ?>"><?php echo esc_html__('Users Data', 'woocommerce-stock-notifications');?></a></li>
    </ul>

        <!-- <p class="bread-crumb-opt"><?php //echo esc_html__('Synkraft Low Stock Notifications', 'Synkraft Stock Notifier');?></p>
            <ul class="sub-menu">
                
                <li><a href="?page=featuresetting.php&plugin_name=Synkraft+Stock+Notifications&plugin_class_name=Woo_stock_notifier_pro&plugin_class_function=stock_notifer_page_callback_pro&tab=stock-notifier-general" class="<?php //echo ($isPluginPage && ($active_tab === 'stock-notifier-general' || empty($active_tab))) ? 'current btn-custom' : 'btn-custom-grey-1'; ?>"><?php //echo esc_html__('General Settings', 'woocommerce-stock-notifications');?></a></li>
                
                <li><a href="?page=featuresetting.php&plugin_name=Synkraft+Stock+Notifications&plugin_class_name=Woo_stock_notifier_pro&plugin_class_function=stock_notifer_page_callback_pro&tab=users-data" class="<?php //echo ($isPluginPage && $active_tab === 'users-data') ? 'current btn-custom' : 'btn-custom-grey-1'; ?>"><?php //echo esc_html__('Users Data', 'woocommerce-stock-notifications');?></a></li>
            </ul> -->
            <?php
            // Display content based on the active tab
            switch ($active_tab) {
                case 'users-data':
                    $this->stock_notifier_users_page();
                    break;
                default:
                    $this->stock_notifier_general_page();
                    break;
            }

        ?>
        </div>
        <?php
    }
}
    

    public function register_settings_pro() {
        register_setting('stock-notifier-settings', 'show_button', array(
            'sanitize_callback' => array($this, 'sanitize_checkbox'),
        ));
        
        add_settings_section(
            'general_settings',
            '',
            array($this, 'section_callback'),
            'stock-notifier-settings'
        );
        
        add_settings_field(
            'show_button',
            'Show / Hide Watchlist button',
            array($this, 'show_button_callback'),
            'stock-notifier-settings',
            'general_settings'
        );
        
    }

    public function section_callback() {
        // Optional section description
    }
       
    public function stock_notifier_general_page() {
        ?>
        <div class="wrap">
            <?php               
                $show_button = get_option('show_button');
            ?>
            <form method="post" action="options.php" id="show_button">
                <?php
                settings_fields('stock-notifier-settings');
                do_settings_sections('stock-notifier-settings');
                submit_button();?>
                <p class="settings_saved"><b><?php echo  esc_html__( 'Settings Saved Successfully!', 'woocommerce-stock-notifications' );?></b></p>

            </form>
        </div>
        <?php
    }



    public function stock_notifier_users_page(){
        global $wpdb;
        $table_name = $wpdb->prefix . 'stock_custom_table';
        $search = isset($_GET['s']) ? sanitize_text_field($_GET['s']) : '';
        $per_page = 10;
        $current_page = isset($_GET['paged']) ? absint($_GET['paged']) : 1;
        $offset = ($current_page - 1) * $per_page;
        $query = "SELECT * FROM $table_name";
        if (!empty($search)) {
            $query .= " WHERE customer_name LIKE '%{$search}%'";
        }
        $query .= " LIMIT $per_page OFFSET $offset";
        $data = $wpdb->get_results($query);
        $total_items = $wpdb->get_var("SELECT COUNT(id) FROM $table_name");
        ?>
        <div class="wrap">
            <div class="users_data_head">
                <h5><?php echo  esc_html__( 'Users who requested for products that are out of stock.', 'woocommerce-stock-notifications');?></h5>
                <form method="post" action="">
                <input type="hidden" name="export_csv" value="1">
                <button type="submit" class="button"><?php echo  esc_html__( 'Export CSV', 'woocommerce-stock-notifications');?></button>
                <input type="hidden" id="stock_notifier_ajax_url" value="<?php echo esc_url(admin_url('admin-ajax.php')); ?>"  style="display:none;"/>
                </form>
            </div>
        <?php
        if ($data) {
            echo '
            <form id="stock_notifier_table_data" method="post" action="">
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th scope="col" class="manage-column check-column"><input type="checkbox"></th>
                            <th scope="col">'. esc_html__( 'Customer Name', 'woocommerce-stock-notifications') .' </th>
                            <th scope="col">'. esc_html__( 'Customer Email', 'woocommerce-stock-notifications') .' </th>
                            <th scope="col">'. esc_html__( 'Phone Number', 'woocommerce-stock-notifications') .' </th>
                            <th scope="col">'. esc_html__( 'Product ID', 'woocommerce-stock-notifications') .' </th>
                            <th scope="col">'. esc_html__( 'Product Name', 'woocommerce-stock-notifications') .' </th>
                            <th scope="col">'. esc_html__( 'Mail Status', 'woocommerce-stock-notifications') .' </th>
                        </tr>
                    </thead>
                    <tbody>';
                        foreach ($data as $item) {
                            echo '<tr>
                            <th scope="row" class="check-column"><input type="checkbox" name="item[]" value="' . $item->id . '" class="form-check-input"></th>
                            <td>' . $item->customer_name . '</td>
                            <td>' . $item->customer_email . '</td>
                            <td>' . $item->customer_phone_number . '</td>
                            <td>' . $item->customer_product_id . '</td>
                            <td>' . $item->customer_product_name . '</td>
                            <td>' . (empty($item->mail_status) ? 'Pending' : $item->mail_status) . '</td>
                            </tr>';
                        }

                            echo '
                    </tbody>
                </table>';

            echo '
                <div class="tablenav">
                    <div class="tablenav-pages">
                        <span class="displaying-num">' . sprintf(_n('%s item', '%s items', $total_items), number_format_i18n($total_items)) . '</span>';
                        if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['item'])) {
                            $selected_items = $_POST['item'];
                            foreach ($selected_items as $item_id) {
                                $wpdb->delete($table_name, array('id' => $item_id));

                                $remaining_items = $wpdb->get_results("SELECT id FROM $table_name ORDER BY id ASC");
                                $new_id = 1;
                                foreach ($remaining_items as $item) {
                                    $wpdb->update($table_name, array('id' => $new_id), array('id' => $item->id));
                                    $new_id++;
                                }
                            }
                            echo '<div class="updated"><p>'.esc_html__( 'Selected items have been deleted.', 'woocommerce-stock-notifications').'</p></div>';
                        }
                        $total_pages = ceil($total_items / $per_page);
                        $page_links = paginate_links(array(
                            'base' => add_query_arg('paged', '%#%'),
                            'format' => '',
                            'prev_text' => __('&laquo; Previous'),
                            'next_text' => __('Next &raquo;'),
                            'total' => $total_pages,
                            'current' => $current_page,
                        ));
                        if ($page_links) {
                            echo '<span class="pagination-links">' . $page_links . '</span>';
                        }
                        echo '
                        <div class="alignleft actions">
                            <select name="action">
                                <option value="-1"> '. esc_html__( 'Bulk Actions', 'woocommerce-stock-notifications').'</option>
                                <option value="delete"> '. esc_html__( 'Delete', 'woocommerce-stock-notifications').'</option>
                                <option value="send_email"> '. esc_html__( 'Send Email', 'woocommerce-stock-notifications').'</option>
                            </select>
                                <input type="submit" name="doaction" value="Apply" class="button action">
                            </div>

                            <br class="clear">
                    </div> 
                </div> 
        </form>';
        } else {
            echo '<p>'. esc_html__( 'No data found.', 'woocommerce-stock-notifications').'</p>';
        }
    }
    public function show_button_callback() {
        $show_button = get_option('show_button', '1');
        
        ?>
       <div class="notifier_options_sn">
        <label class="form-check-label me-4">
                <input type="radio" name="show_button" value="1" <?php checked($show_button, '1'); ?> />
                <?php echo esc_html__( 'Show Button','woocommerce-stock-notifications' );?>
            </label>
            <label class="form-check-label me-4">
                <input type="radio" name="show_button" value="0" <?php checked($show_button, '0'); ?> />
                <?php echo esc_html__( 'Hide Button','woocommerce-stock-notifications' );?>
                
            </label>
       </div>
        <?php
    }

    public function sanitize_checkbox($input) {
        return ($input === '1' || $input === '0') ? $input : '1';
    }

    public function handle_export_csv_data() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'stock_custom_table';
        $filename = 'stock_notifier_data.csv';
        $header_row = array('Customer Name', 'Customer Email', 'Phone Number', 'Product ID', 'Product Name', 'Mail Status');
        $data_rows = array();

        $data = $wpdb->get_results("SELECT * FROM $table_name");
        foreach ($data as $item) {
            $data_rows[] = array(
                $item->customer_name,
                $item->customer_email,
                $item->customer_phone_number,
                $item->customer_product_id,
                $item->customer_product_name,
                $item->mail_status
            );
        }

        ob_clean();
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fputcsv($output, $header_row);
        foreach ($data_rows as $row) {
            fputcsv($output, $row);
        }
        fclose($output);

        wp_die();
    }
    

    function send_emails_callback_pro() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'stock_custom_table';
        $selected_items = $_POST['items'];

        foreach ($selected_items as $item_id) {
            $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $item_id));
    
            if ($item) {
                if ($item->mail_status === 'email sent') {
                    wp_send_json_error(array(
                        'message' => 'Email already sent.'
                    ));
                    exit;
                }
                    if (empty($item->customer_email)) {
                    wp_send_json_error(array(
                        'message' => 'No email address found to send an email.'
                    ));
                    exit;
                }
                $to = $item->customer_email;
                $subject = esc_html__('Product Availability Notification', 'woocommerce-stock-notifications');
                $message = sprintf(
                    "Hi %s,\n\nThe item you were waiting for <strong>'%s'</strong> is back in stock. Please visit our store and enjoy shopping.\n\nThank you.",
                    $item->customer_name,
                    $item->customer_product_name
                );
    
                wp_mail($to, $subject, $message);
    
                $wpdb->update($table_name, array('mail_status' => 'Email Sent'), array('id' => $item_id));
            }
        }
        wp_send_json_success( array( 
            'message' => esc_html__('Email Sent Succesfully.', 'woocommerce-stock-notifications')
        ), 200 );
    }   

    function handle_stock_notifier_export_csv_pro() {
        if (isset($_POST['export_csv']) && $_POST['export_csv'] == '1') {
            global $wpdb;
            $table_name = $wpdb->prefix . 'stock_custom_table';
            $filename = 'stock_notifier_data.csv';
            $header_row = array('Customer Name', 'Customer Email', 'Phone Number', 'Product ID', 'Product Name', 'Mail Status');
            $data_rows = array();
            $data = $wpdb->get_results("SELECT * FROM $table_name");
            foreach ($data as $item) {
                $data_rows[] = array(
                    $item->customer_name,
                    $item->customer_email,
                    $item->customer_phone_number,
                    $item->customer_product_id,
                    $item->customer_product_name,
                    $item->mail_status
                );
            }

            $csv_data = implode(',', $header_row) . "\n";
            foreach ($data_rows as $row) {
                $csv_data .= implode(',', $row) . "\n";
            }
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            echo $csv_data;
            exit();
        }
    }
}