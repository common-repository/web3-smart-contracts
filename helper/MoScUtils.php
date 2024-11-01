<?php

class MoScUtils{

    static function mo_sc_get_plugin_dir_path() {
        return plugin_dir_path(dirname(__FILE__));
    }

    static function mo_sc_get_plugin_dir_url() {
        return plugin_dir_url(dirname(__FILE__));
    }

    static function mo_sc_get_plugin_basename() {
        $plugin_dir = plugin_dir_path(dirname(__FILE__)) .'smart-contracts.php';
        return plugin_basename($plugin_dir);
    }

    static function mo_sc_is_plugin_page($query) {
        $query_str = parse_url(sanitize_text_field($_SERVER['REQUEST_URI']), PHP_URL_QUERY);
        $query_str = is_null($query_str) ? '' : $query_str;
        parse_str($query_str, $query_params);
        if(array_key_exists('page',$query_params) && strpos($query_params['page'], 'mo_smart_contracts') !== false){
            return true;
        }
        return false;
    }

    static function mo_sc_wp_remote_post($url, $args) {
        $response = wp_remote_post($url, $args);
        if(!is_wp_error($response)){
            return $response['body'];
        } else {
            self::mo_sc_show_error_message('Unable to connect to the Internet. Please try again.');
            return null;
        }
    }

    static function mo_sc_show_error_message($message) {
        update_option('mo_sc_message', $message);
        remove_action( 'admin_notices', array( MoScUtils::class, 'mo_sc_error_message' ) );
        add_action( 'admin_notices', array( MoScUtils::class, 'mo_sc_display_error_notice' ) );
    }

    static function mo_sc_show_success_message($message) {
        update_option('mo_sc_message', $message);
        remove_action( 'admin_notices', array( MoScUtils::class, 'mo_sc_success_message' ) );
        add_action( 'admin_notices', array( MoScUtils::class, 'mo_sc_display_success_notice' ) );
    }

    static function mo_sc_display_error_notice() {
        error_log('error');
        $class   = "error";
        $message = get_option( 'mo_sc_message' );
        $allowed_html = array('a' => array('href'=>array(),'target'=>array()), 'code' => array());
        echo '<div class="'.esc_html($class).' mo-sc-error_msg"> <p>'.wp_kses($message, $allowed_html).'</p></div>';
    }

    static function mo_sc_display_success_notice() {
        error_log('success');
        $class   = "updated";
        $message = get_option( 'mo_sc_message' );
        $allowed_html = array('a' => array('href'=>array(),'target'=>array()), 'code' => array());
        echo '<div class="'.esc_html($class).' mo-sc-success_msg"> <p>'.wp_kses($message, $allowed_html).'</p></div>';
    }

    public static function mo_sc_check_empty_or_null( $validate_fields_array ) {
        foreach ( $validate_fields_array as $fields ) {
            if ( !isset( $fields ) || empty( $fields ) )
                return true;
        }
        return false;
    }

}