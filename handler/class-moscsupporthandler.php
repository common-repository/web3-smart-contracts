<?php
/**
 * File Name: class-moscsupporthandler.php
 * Description: This file handles all the form submissions in the plugin.
 *
 * @package web3-smart-contracts/handler
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MoScSupportHandler' ) ) {
	/**
	 * Main Form Handler class used to handle all the form submissions in the plugin.
	 */
	class MoScSupportHandler {
		/**
		 * Send the Support Request Query and Email of the customers to form an API Request.
		 *
		 * @param array $post_array Contains the user input from the support form.
		 * @return void
		 */
		public static function mo_sc_send_support_query( $post_array ) {

			if ( ! self::mo_sc_validate_contact_us_fields( $post_array ) ) {
				return;
			}

			$email    = sanitize_email( $post_array[ MoScSupportOptionsConstants::EMAIL ] );
			$query    = sanitize_text_field( $post_array[ MoScSupportOptionsConstants::QUERY ] );
			$customer = new MoScCustomerHandler();
			$response = $customer->mo_sc_submit_contact_us( $email, $query );
			if ( ! is_null( $response ) && false !== $response ) {
				MoScUtils::mo_sc_show_success_message( 'Thank you for reaching out to us! We will get back to you shortly.' );
			} else {
				MoScUtils::mo_sc_show_error_message( 'There was an error while submitting your response. If the issue persists, please send us your query at web3@xecurify.com' );
			}
		}

		/**
		 * Validate the Support query fields values.
		 *
		 * @param array $post_array Contains the user input from the support form.
		 * @return boolean
		 */
		public static function mo_sc_validate_contact_us_fields( $post_array ) {
			$validate_fields_array = array( $post_array[ MoScSupportOptionsConstants::EMAIL ], $post_array[ MoScSupportOptionsConstants::QUERY ] );
			if ( MoScUtils::mo_sc_check_empty_or_null( $validate_fields_array ) ) {
				MoScUtils::mo_sc_show_error_message( 'Please fill up required fields to submit your query.' );
				return false;
			} elseif ( ! filter_var( $post_array[ MoScSupportOptionsConstants::EMAIL ], FILTER_VALIDATE_EMAIL ) ) {
				MoScUtils::mo_sc_show_error_message( 'Please enter a valid email address.' );
				return false;
			}
			return true;
		}
	}
}
