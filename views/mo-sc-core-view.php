<?php
/**
 * File Name: mo-sc-core-view.php
 * Description: This file has all the functions which renders the frontend of the Web3 Smart Contract Plugin.
 *
 * @package web3-smart-contracts/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main file of the plugin view to display all the forms related to the plugin.
 *
 * @return void
 */
function mo_sc_settings() {
	?>
		<div class="mo-sc-row">
			<div class="mo-sc-col-md-8 mo-sc-shadow-cstm mo-sc-bg-main-cstm mo-sc-m-3 mo-sc-p-3">
				<?php
					mo_sc_display_plugin_header();
					mo_sc_display_settings_page();

				?>
			</div>
			<div class="mo-sc-col-md-3 mo-sc-shadow-cstm mo-sc-bg-main-cstm mo-sc-my-3 mo-sc-p-3">
				<?php
				mo_sc_display_support_form();
				?>
			</div>
		</div>
	<?php
}

/**
 * This function displays the main heading/title of the Plugin.
 *
 * @return void
 */
function mo_sc_display_plugin_header() {
	?>
		<h1>Smart Contracts</h1>  
	<?php
}

/**
 * This function displays the NFT or Smart Contract form.
 *
 * @return void
 */
function mo_sc_display_settings_page() {
	$sc_type = '';
		//phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignore the nonce verification for test config operation.
	if ( isset( $_REQUEST['sc_type'] ) ) {
			//phpcs:ignore WordPress.Security.NonceVerification.Recommended -- Ignore the nonce verification for test config operation.
		$sc_type = sanitize_text_field( wp_unslash( $_REQUEST['sc_type'] ) );
	}

	switch ( $sc_type ) {
		case 'NFT':
			mo_sc_nft_page();
			break;
		default:
			mo_sc_smart_contracts_page();
			break;
	}
}
