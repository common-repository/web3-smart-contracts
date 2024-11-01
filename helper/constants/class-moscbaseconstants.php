<?php
/**
 * File Name: class-moscbaseconstants.php
 * Description: This file has the class to set the constants.
 *
 * @package web3-smart-contracts/helper/constants
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MoScBaseConstants' ) ) {
	/**
	 * This class defines constants used throughout the plugin.
	 */
	class MoScBaseConstants {

		const HOSTNAME             = 'https://login.xecurify.com';
		const VERSION              = '1.1.0';
		const DEFAULT_CUSTOMER_KEY = '16555';
		const DEFAULT_API_KEY      = 'fFd2XcvTGDemZvbw1bcUesNJWEqKbbUq';
	}
}
