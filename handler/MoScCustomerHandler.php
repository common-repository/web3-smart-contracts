<?php

class MoScCustomerHandler {
    function mo_sc_submit_contact_us($email, $query) {
        $url = MoScBaseConstants::HOSTNAME. '/moas/rest/customer/contact-us';
        $current_user = wp_get_current_user();

        $query = '[WordPress Smart Contracts] ' . $query;

        $fields = array (
            'firstName' => $current_user->user_firstname,
            'lastName' => $current_user->user_lastname,
            'company' => sanitize_url($_SERVER ['SERVER_NAME']),
            'email' => $email,
            'ccEmail'=>'samlsupport@xecurify.com',
            'query' => $query
        );

        $field_string = json_encode ( $fields );

        $headers = array("Content-Type"=>"application/json","charset"=>"UTF-8","Authorization"=>"Basic");
        $args = array(
            'method' => 'POST',
            'body' => $field_string,
            'timeout' => '10',
            'redirection' => '5',
            'httpversion' => '1.0',
            'blocking' => true,
            'headers' => $headers
        );
        $response = MoScUtils::mo_sc_wp_remote_post($url, $args);
        return $response;

    }


}