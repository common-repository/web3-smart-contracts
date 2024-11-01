<?php
/**
 * File Name: class-moscutils.php
 * Description: This file has the class to set the constants.
 *
 * @package web3-smart-contracts/helper
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MoScUtils' ) ) {
	/**
	 * This class has all the utilities function.
	 */
	class MoScUtils {
		/**
		 * This function is to get the plugin URL.
		 *
		 * @return string
		 */
		public static function mo_sc_get_plugin_dir_path() {
			return plugin_dir_path( dirname( __FILE__ ) );
		}

		/**
		 * This function is to get the plugin files path/URL.
		 *
		 * @return string
		 */
		public static function mo_sc_get_plugin_dir_url() {
			return plugin_dir_url( dirname( __FILE__ ) );
		}

		/**
		 * This function is to get the plugin name.
		 *
		 * @return string
		 */
		public static function mo_sc_get_plugin_basename() {
			$plugin_dir = plugin_dir_path( dirname( __FILE__ ) ) . 'smart-contracts.php';
			return plugin_basename( $plugin_dir );
		}

		/**
		 * Checks whether its plugin page or any other page such as feedback page.
		 *
		 * @return boolean
		 */
		public static function mo_sc_is_plugin_page() {
			if ( isset( $_SERVER['REQUEST_URI'] ) ) {
				$server_url = esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) );
			} else {
				$server_url = '';
			}
			//phpcs:ignore WordPress.WP.AlternativeFunctions.parse_url_parse_url -- Required to parse the Server URL.
			$query_str = parse_url( $server_url, PHP_URL_QUERY );
			$query_str = is_null( $query_str ) ? '' : $query_str;
			parse_str( $query_str, $query_params );
			if ( array_key_exists( 'page', $query_params ) && strpos( $query_params['page'], 'mo_smart_contracts' ) !== false ) {
				return true;
			}
			return false;
		}

		/**
		 * Makes an HTTP request to given url using post method and returns its response.
		 *
		 * @param  string $url endpoint where the HTTP request is made.
		 * @param  array  $args Request arguments.
		 * @return string
		 */
		public static function mo_sc_wp_remote_post( $url, $args ) {
			$response = wp_remote_post( $url, $args );
			if ( ! is_wp_error( $response ) ) {
				return $response['body'];
			} else {
				self::mo_sc_show_error_message( 'Unable to connect to the Internet. Please try again.' );
				return null;
			}
		}

		/**
		 * Responsible for showing error message.
		 *
		 * @param string $message Message to display to the Admin.
		 * @return void
		 */
		public static function mo_sc_show_error_message( $message ) {
			update_option( 'mo_sc_message', $message );
			remove_action( 'admin_notices', array( self::class, 'mo_sc_error_message' ) );
			add_action( 'admin_notices', array( self::class, 'mo_sc_display_error_notice' ) );
		}

		/**
		 * Responsible for showing success message.
		 *
		 * @param string $message Message to display to the Admin.
		 * @return void
		 */
		public static function mo_sc_show_success_message( $message ) {
			update_option( 'mo_sc_message', $message );
			remove_action( 'admin_notices', array( self::class, 'mo_sc_success_message' ) );
			add_action( 'admin_notices', array( self::class, 'mo_sc_display_success_notice' ) );
		}

		/**
		 * Responsible for showing faliure or error message and notices to the admin.
		 *
		 * @return void
		 */
		public static function mo_sc_display_error_notice() {
			self::mo_sc_display_notice( 'error' );
		}

		/**
		 * Responsible for showing success message and notices to the admin.
		 *
		 * @return void
		 */
		public static function mo_sc_display_success_notice() {
			self::mo_sc_display_notice( 'updated' );
		}

		/**
		 * Responsible for showing Success & Error message and notices to the admin.
		 *
		 * @param  string $notice_type contains notice type.
		 * @return void
		 */
		public static function mo_sc_display_notice( $notice_type ) {
			if ( 'updated' === $notice_type ) {
				$class = 'updated mo-sc-success_msg';
			} elseif ( 'error' === $notice_type ) {
				$class = 'error mo-sc-error_msg';
			}

			$message      = get_option( 'mo_sc_message' );
			$allowed_html = array(
				'a'    => array(
					'href'   => array(),
					'target' => array(),
				),
				'code' => array(),
			);
			echo '<div class="' . esc_html( $class ) . '"> <p>' . wp_kses( $message, $allowed_html ) . '</p></div>';
		}

		/**
		 * Validate the given array.
		 *
		 * @param  array $validate_fields_array contains fields to be validated.
		 * @return boolean
		 */
		public static function mo_sc_check_empty_or_null( $validate_fields_array ) {
			foreach ( $validate_fields_array as $fields ) {
				if ( ! isset( $fields ) || empty( $fields ) ) {
					return true;
				}
			}
			return false;
		}
	}
}
