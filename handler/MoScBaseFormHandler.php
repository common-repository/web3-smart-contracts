<?php

class MoScBaseFormHandler {
    static function moScHandleFormData() {

        if(!MoScUtils::mo_sc_is_plugin_page(sanitize_text_field($_SERVER['QUERY_STRING'])))
            return;
        if(!current_user_can('manage_options'))
            wp_die("You do not have permission to view this page");

        $option = '';
        if(isset($_POST['option'])) {
            $option = sanitize_text_field($_POST['option']);
            check_admin_referer($option);
        }

        switch ($option) {
            case 'mo_sc_contact_us_query_option' :
                MoScSupportHandler::moScSendSupportQuery($_POST);
                break;
        }
    }
}