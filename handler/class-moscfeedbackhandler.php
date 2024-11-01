<?php
/**
 * File Name: class-moscbasefeedbackhandler.php
 * Description: Handles the submission of the Feedback form.
 *
 * @package web3-smart-contracts/handler
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MoScFeedbackHandler' ) ) {
	/**
	 * The Handler class for the feedback form. This class takes care of validating the feedback form data, making the feedback API request and performing post-feedback redirection.
	 */
	class MoScFeedbackHandler {
		/**
		 * Redirects to the Installed Plugin page with the correct message after the plugin is deactivated.
		 *
		 * @return void
		 */
		public static function mo_sc_skip_feedback_query() {
			MoScUtils::mo_sc_show_success_message( 'Thank you for using our plugin. Plugin deactivated successfully.' );
			deactivate_plugins( dirname( ( __DIR__ ) ) . '\web3-smart-contracts.php' );

			wp_safe_redirect( self_admin_url( 'plugins.php?deactivate=true' ) );
			exit;
		}

		/**
		 * Sends the feedback email based on the user input on the feedback form.
		 *
		 * @param array $post_array Contains the user input from the feedback form.
		 * @return void
		 */
		public static function mo_sc_send_feedback_query( $post_array ) {
			$user                      = wp_get_current_user();
			$deactivate_reason_message = '';
			if ( isset( $post_array['mo_sc_query_feedback'] ) ) {
				$deactivate_reason_message = sanitize_text_field( $post_array['mo_sc_query_feedback'] );
			}

			$message = 'Plugin Deactivated, Feedback : ' . $deactivate_reason_message . '';
			$reason  = '';
			if ( isset( $post_array['mo_sc_reason'] ) ) {
				$reason = htmlspecialchars( $post_array['mo_sc_reason'] );
			}

			$message = $message . ', [Reason :' . $reason . ']';
			$email   = $user->user_email;

			$feedback_reasons = new MoScCustomerHandler();
			if ( ! is_null( $feedback_reasons ) ) {
				if ( ! papr_is_curl_installed() ) {
					MoScUtils::mo_sc_show_success_message( 'Thank you for using our plugin. Plugin deactivated successfully.' );
					deactivate_plugins( dirname( ( __DIR__ ) ) . '\web3-smart-contracts.php' );
					wp_safe_redirect( self_admin_url( 'plugins.php?deactivate=true' ) );
					exit;
				} else {
					$submited = json_decode( $feedback_reasons->mo_sc_send_email_alert( $message, $email ), true );

					if ( JSON_ERROR_NONE === json_last_error() ) {
						if ( is_array( $submited ) && ! empty( $submited['status'] ) && 'ERROR' === $submited['status'] ) {
							MoScUtils::mo_sc_show_success_message( $submited['message'] );
						} else {
							if ( false === $submited ) {
								MoScUtils::mo_sc_show_error_message( 'Error while submitting the query.' );
							}
						}
					}

					deactivate_plugins( dirname( ( __DIR__ ) ) . '\web3-smart-contracts.php' );
					wp_safe_redirect( self_admin_url( 'plugins.php?deactivate=true' ) );
					exit;
				}
			}
		}
	}
}
