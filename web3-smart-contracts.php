<?php // phpcs:ignore WordPress.Files.FileName.InvalidClassFileName -- cannot change main file's name
/**
 * Plugin Name: Web3 Smart Contracts
 * Plugin URI: https://miniorange.com/
 * Description: miniOrange Smart Contracts allow you to create and deploy Smart Contracts on your blockchain network.
 * Version: 1.1.0
 * Author: miniOrange
 * Author URI: https://miniorange.com/
 * License: MIT/Expat
 * License URI: https://docs.miniorange.com/mit-license
 * Text Domain: web3-smart-contracts
 *
 * @package web3-smart-contracts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'helper' . DIRECTORY_SEPARATOR . 'class-moscutils.php';
require_once 'helper' . DIRECTORY_SEPARATOR . 'class-moscplugininitializer.php';

if ( ! class_exists( 'MoSmartContracts' ) ) {
	/**
	 * The Main class of the miniOrange Web3 Smart Contract Plguin.
	 */
	class MoSmartContracts {
		/**
		 * The Constructor for the main class. This takes care of initializing the required class and it's function used by the plugin.
		 */
		public function __construct() {
			$plugin_initializer = new MoScPluginInitializer();
			$plugin_initializer->mo_sc_include_plugin_files();
			$plugin_initializer->mo_sc_initialize_hooks();
		}
	}
}

new MoSmartContracts();
