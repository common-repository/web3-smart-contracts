<?php
/**
 * File Name: class-moscplugininitializer.php
 * Description: This file has the class to set the constants.
 *
 * @package web3-smart-contracts/helper
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MoScPluginInitializer' ) ) {
	/**
	 * This class has the functions responsible for initializing plugin functionalities by including files and adding hooks.
	 */
	class MoScPluginInitializer {

		/**
		 * Include all the files from all the folders inside the plugin.
		 *
		 * @return void
		 */
		public function mo_sc_include_plugin_files() {

			foreach ( glob( MoScUtils::mo_sc_get_plugin_dir_path() . 'views' . DIRECTORY_SEPARATOR . '*.php' ) as $filename ) {
				include_once $filename;
			}
			foreach ( glob( MoScUtils::mo_sc_get_plugin_dir_path() . 'handler' . DIRECTORY_SEPARATOR . '*.php' ) as $filename ) {
				include_once $filename;
			}
			foreach ( glob( MoScUtils::mo_sc_get_plugin_dir_path() . 'helper' . DIRECTORY_SEPARATOR . '*.php' ) as $filename ) {
				include_once $filename;
			}
			foreach ( glob( MoScUtils::mo_sc_get_plugin_dir_path() . 'helper' . DIRECTORY_SEPARATOR . 'constants' . DIRECTORY_SEPARATOR . '*.php' ) as $filename ) {
				include_once $filename;
			}
		}

		/**
		 * Initialize all the hooks needed in the plugin.
		 *
		 * @return void
		 */
		public function mo_sc_initialize_hooks() {
			add_action( 'admin_menu', array( $this, 'mo_sc_menu' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'mo_sc_enqueue_styles' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'mo_sc_enqueue_scripts' ) );
			add_action( 'script_loader_tag', array( $this, 'add_type_to_script' ), 10, 3 );
			add_action( 'plugin_action_links_' . MoScUtils::mo_sc_get_plugin_basename(), array( $this, 'mo_sc_plugin_action_links' ) );
			add_action( 'admin_init', array( MoScBaseFormHandler::class, 'mo_sc_handle_form_data' ) );
			add_action( 'admin_footer', array( $this, 'mo_sc_feedback_request' ) );
		}

		/**
		 * Add type module to script.
		 *
		 * @param Tag    $tag The tag you want to add.
		 * @param Handle $handle The name of the file as enqueued by WordPress.
		 * @param Source $source The source url of the file.
		 */
		public function add_type_to_script( $tag, $handle, $source ) {
			if ( 'mo_sc_smart_contracts_script_ethers_51' === $handle ) {
				$tag = '<script type="module" src="' . esc_url( $source ) . '" ></script>'; // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript -- Cannot Enqueue this script. 
			}
			return $tag;
		}

		/**
		 * Displays the feedback form upon plugin deactivation.
		 *
		 * @return void
		 */
		public function mo_sc_feedback_request() {
			if ( isset( $_SERVER['PHP_SELF'] ) && 'plugins.php' !== basename( sanitize_text_field( wp_unslash( $_SERVER['PHP_SELF'] ) ) ) ) {
				return;
			}
			mo_sc_display_feedback_form();
		}

		/**
		 * Adds the menu and submenu for the miniOrange WordPress Web3 Smart Contract SSO plugin.
		 *
		 * @return void
		 */
		public function mo_sc_menu() {
			$page = add_menu_page( 'Web3 Smart Contracts', 'Web3 Smart Contracts', 'administrator', 'mo_smart_contracts', 'mo_sc_settings', MoScUtils::mo_sc_get_plugin_dir_url() . 'images/miniorange.png' );
		}

		/**
		 * Enqueues all the css files required by the plugin
		 *
		 * @param string $page Contains the value of the page parameter from the URL along with its level and is used to make sure the css is loaded only where it is required.
		 * @return void
		 */
		public function mo_sc_enqueue_styles( $page ) {
			if ( 'toplevel_page_mo_smart_contracts' !== $page ) {
				return;
			}

			wp_enqueue_style( 'mo_sc_plugin_admin_style', plugins_url( 'assets/css/styles.min.css', dirname( __FILE__ ) ), array(), MoScBaseConstants::VERSION, 'all' );
		}

		/**
		 * Enqueues all the js files required by the plugin
		 *
		 * @param string $page Contains the value of the page parameter from the URL along with its level and is used to make sure the js is loaded only where it is required.
		 * @return void
		 */
		public function mo_sc_enqueue_scripts( $page ) {
			if ( 'toplevel_page_mo_smart_contracts' !== $page ) {
				return;
			}

			wp_enqueue_script( 'jQuery' );
			wp_enqueue_script( 'mo_sc_web3_script', plugins_url( 'assets/js/web3.min.js', dirname( __FILE__ ) ), array(), MoScBaseConstants::VERSION, false );
			wp_enqueue_script( 'mo_sc_smart_contracts_script', plugins_url( 'assets/js/smart-contract.min.js', dirname( __FILE__ ) ), array(), MoScBaseConstants::VERSION, false );
			wp_enqueue_script( 'mo_sc_smart_contracts_script_ethers_51', plugins_url( 'assets/js/ethers-5.1.esm.min.js', dirname( __FILE__ ) ), array(), MoScBaseConstants::VERSION, false );
		}

		/**
		 * Provides additional links for Settings and Premium Plans for the plugin listed under the Installed Plugins section.
		 *
		 * @param array $links The default links provided by WordPress for Settings and Deactivate.
		 * @return array
		 */
		public function mo_sc_plugin_action_links( $links ) {
			$links = array_merge(
				array(
					'<a href="' . esc_url( admin_url( 'admin.php?page=mo_smart_contracts' ) ) . '">' . __( 'Settings', 'miniorange-smart-contracts' ) . '</a>',
				),
				$links
			);
			return $links;
		}
	}
}
