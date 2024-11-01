<?php 

class Pisol_Smdsw_Plugin{

    static $instance = null;

    public $data;

    public static function get_instance(){
        if( self::$instance == null ){
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function __construct(){
        require_once ABSPATH . 'wp-admin/includes/class-wp-plugin-install-list-table.php';
        
        add_filter('install_plugins_nonmenu_tabs', function ($tabs) {
            $tabs[] = 'rajeshsingh520';
            return $tabs;
        });
        add_filter('install_plugins_table_api_args_rajeshsingh520', function ($args) {
            global $paged;
            return [
                'per_page' => 1,
                'tag' => 'flexible-shipping'
            ];
        });

        $_POST['tab'] = 'rajeshsingh520';
        $table = new WP_Plugin_Install_List_Table();
        $table->prepare_items();

        wp_enqueue_script('plugin-install');
        add_thickbox();
        wp_enqueue_script('updates');
        echo '<div id="plugin-filter">';
        echo $table->display();
        echo '</div>';
        
    }

    
}