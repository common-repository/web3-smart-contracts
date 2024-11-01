<?php
/**
 * File Name: class-moscsupportoptionscontants.php
 * Description: This file has the class to set the constants for Email and Query.
 *
 * @package web3-smart-contracts/helper/constants
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'MoScSupportOptionsConstants' ) ) {
	/**
	 * This class defines constants used on the Support form.
	 */
	class MoScSupportOptionsConstants {
		const EMAIL = 'mo_sc_contact_us_email';
		const QUERY = 'mo_sc_contact_us_query';
	}
}
