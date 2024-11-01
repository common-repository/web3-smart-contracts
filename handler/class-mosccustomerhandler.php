<?php
/**
 * File Name: class-mosccustomerhandler.php
 * Description: This file takes care of making API requests for interacting with the customer’s miniOrange account.
 *
 * @package web3-smart-contracts/handler
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MoScCustomerHandler' ) ) {
	/**
	 * This class MoScCustomerHandler contains functions to handle the customer related functionalities like sending support query, feedback, etc.
	 */
	class MoScCustomerHandler {
		/**
		 * This function is used for sending support query from plugin by making a call to the rest/customer/contact-us endpoint.
		 *
		 * @param string $email       Customer's Email.
		 * @param string $query       Customer's Query.
		 *
		 * @return array $response    Response of the API call for call request.
		 */
		public function mo_sc_submit_contact_us( $email, $query ) {
			$url          = MoScBaseConstants::HOSTNAME . '/moas/rest/customer/contact-us';
			$current_user = wp_get_current_user();

			$query = '[WordPress Smart Contracts] ' . $query;

			if ( isset( $_SERVER['SERVER_NAME'] ) ) {
				$server_name = sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) );
			} else {
				$server_name = '';
			}

			$fields = array(
				'firstName' => $current_user->user_firstname,
				'lastName'  => $current_user->user_lastname,
				'company'   => $server_name,
				'email'     => $email,
				'ccEmail'   => 'web3@xecurify.com',
				'query'     => $query,
			);

			$field_string = wp_json_encode( $fields );

			$headers = array(
				'Content-Type'  => 'application/json',
				'charset'       => 'UTF-8',
				'Authorization' => 'Basic',
			);

			$headers = self::mo_sc_basic_header();
			$args    = self::mo_sc_args( $field_string, $headers );

			$response = MoScUtils::mo_sc_wp_remote_post( $url, $args );
			return $response;
		}

		/**
		 * This function is used for sending the query for demo requests and feedback for the plugin by making a call to the /api/notify/send endpoint.
		 *
		 * @param string $message      Customer's Message.
		 * @param string $email        Customer's Email.
		 * @param string $phone        Customer's Phone.
		 * @param bool   $demo_request Customer's Request for demo.
		 *
		 * @return array $response     Response of the API call for demo request and feedback.
		 */
		public function mo_sc_send_email_alert( $message, $email, $phone = '', $demo_request = false ) {

			$url          = MoScBaseConstants::HOSTNAME . '/moas/api/notify/send';
			$api_key      = MoScBaseConstants::DEFAULT_API_KEY;
			$customer_key = MoScBaseConstants::DEFAULT_CUSTOMER_KEY;

			$current_time_in_millis = self::mo_sc_get_timestamp();
			$current_time_in_millis = number_format( $current_time_in_millis, 0, '', '' );
			$string_to_hash         = $customer_key . $current_time_in_millis . $api_key;
			$hash_value             = hash( 'sha512', $string_to_hash );
			$from_email             = 'no-reply@xecurify.com';
			$subject                = 'Feedback: WordPress Web3 Smart Contracts Plugin';
			if ( $demo_request ) {
				$subject = 'DEMO REQUEST: WordPress Web3 Smart Contracts Plugin';
			}
			$site_url = site_url();

			global $user;
			$user = wp_get_current_user();

			$query = '[WordPress Web3 Smart Contracts Plugin: ]: ' . $message;

			if ( isset( $_SERVER['SERVER_NAME'] ) ) {
				$server_name = sanitize_text_field( wp_unslash( $_SERVER['SERVER_NAME'] ) );
			} else {
				$server_name = '';
			}

			$content = '<div>Hello, <br><br>First Name :' . esc_html( $user->user_firstname ) . '<br><br>Last  Name :' . esc_html( $user->user_lastname ) . '   <br><br>Company :<a href="' . esc_html( $server_name ) . '" target="_blank" >' . esc_html( $server_name ) . '</a><br><br>Phone Number :' . esc_html( $phone ) . '<br><br>Email :<a href="mailto:' . esc_attr( $email ) . '" target="_blank">' . esc_html( $email ) . '</a><br><br>Query :' . wp_kses( $query, array( 'br' => array() ) ) . '</div>';

			$fields       = array(
				'customerKey' => $customer_key,
				'sendEmail'   => true,
				'email'       => array(
					'customerKey' => $customer_key,
					'fromEmail'   => $from_email,
					'fromName'    => 'Xecurify',
					'toEmail'     => 'info@xecurify.com',
					'toName'      => 'web3@xecurify.com',
					'bccEmail'    => 'web3@xecurify.com',
					'subject'     => $subject,
					'content'     => $content,
				),
			);
			$field_string = wp_json_encode( $fields );

			$headers = self::mo_sc_hash_header( $customer_key, $current_time_in_millis, $hash_value );
			$args    = self::mo_sc_args( $field_string, $headers );

			$response = MoScUtils::mo_sc_wp_remote_post( $url, $args );
			return $response;
		}

		/**
		 * This function is used to get time when the Support query or the demo request has been raised by making a call to the /rest/mobile/get-timestamp endpoint.
		 *
		 * @return string $response This is time when query was raised.
		 */
		public static function mo_sc_get_timestamp() {
			$url      = MoScBaseConstants::HOSTNAME . '/moas/rest/mobile/get-timestamp';
			$headers  = self::mo_sc_basic_header();
			$args     = self::mo_sc_args( '', $headers );
			$response = MoScUtils::mo_sc_wp_remote_post( $url, $args );
			return $response;
		}

		/**
		 * This function is used for forming the Basic Header Array for API request sent to the miniOrange.
		 *
		 * @return array $headers        Basic Authorization Header.
		 */
		public static function mo_sc_basic_header() {
			$headers = array(
				'Content-Type'  => 'application/json',
				'charset'       => 'UTF-8',
				'Authorization' => 'Basic',
			);

			return $headers;
		}

		/**
		 * This function is used for forming the Header Array with Hash Authorization value for API request sent to the miniOrange.
		 *
		 * @param string $customer_key           miniOrange Customer Key.
		 * @param string $current_time_in_millis Current Time.
		 * @param string $hash_value             Hash value generated by customer key, API Key & time.
		 *
		 * @return array $headers        Authorization Header with hash value.
		 */
		public static function mo_sc_hash_header( $customer_key, $current_time_in_millis, $hash_value ) {
			$headers = array(
				'Content-Type'  => 'application/json',
				'Customer-Key'  => $customer_key,
				'Timestamp'     => $current_time_in_millis,
				'Authorization' => $hash_value,
			);

			return $headers;
		}

		/**
		 * This function is used for forming the Argunment of the API request sent to the miniOrange.
		 *
		 * @param array $field_string API Request Body.
		 * @param array $headers      API Request Authentication Header.
		 *
		 * @return array $args        Request argument.
		 */
		public static function mo_sc_args( $field_string, $headers ) {
			$args = array(
				'method'      => 'POST',
				'body'        => $field_string,
				'timeout'     => '10',
				'redirection' => '5',
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => $headers,
			);

			return $args;
		}
	}
}
