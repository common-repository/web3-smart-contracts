<?php
/**
 * File Name: class-moscbaseformhandler.php
 * Description: This file handles all the form submissions in the plugin.
 *
 * @package web3-smart-contracts/handler
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MoScBaseFormHandler' ) ) {
	/**
	 * Main Form Handler class used to handle all the form submissions in the plugin.
	 */
	class MoScBaseFormHandler {
		/**
		 * This function is responsible for verifying the nonce and calling the corresponding handlers when a form is submitted.
		 *
		 * @return void
		 */
		public static function mo_sc_handle_form_data() {
			if ( isset( $_SERVER['QUERY_STRING'] ) && ! MoScUtils::mo_sc_is_plugin_page( sanitize_text_field( wp_unslash( $_SERVER['QUERY_STRING'] ) ) ) ) {
				$path = isset( $_SERVER['PHP_SELF'] ) ? sanitize_text_field( wp_unslash( $_SERVER['PHP_SELF'] ) ) : '';
				if ( 'plugins.php' !== basename( $path ) ) {
					return;
				}
			}

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( 'You do not have permission to view this page' );
			}

			$option = '';
			if ( isset( $_POST['option'] ) ) {
				$option = sanitize_text_field( wp_unslash( $_POST['option'] ) );
				check_admin_referer( $option );
			}

			switch ( $option ) {
				case 'mo_sc_contact_us_query_option':
					MoScSupportHandler::mo_sc_send_support_query( $_POST );
					break;

				case 'mo_sc_skip_feedback':
					MoScFeedbackHandler::mo_sc_skip_feedback_query();
					break;

				case 'mo_sc_feedback_submit':
					MoScFeedbackHandler::mo_sc_send_feedback_query( $_POST );
					break;
			}
		}
	}
}
