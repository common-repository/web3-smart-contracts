<?php
/**
 * File Name: mo-sc-support-view.php
 * Description: This file takes care of rendering the support form.
 *
 * @package web3-smart-contracts/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The function displays the support form in the plugin.
 *
 * @return void
 */
function mo_sc_display_support_form() {
	?>
	<div class="mo_sc_support_layout">
		<div style="padding-right:10px">
			<h3>Support</h3>
			<p>Need any help or looking for a feature you couldn't find? Just send us a query, and we will get back to you soon.</p>
			<form method="post" action="">
				<?php wp_nonce_field( 'mo_sc_contact_us_query_option' ); ?>
				<input type="hidden" name="option" value="mo_sc_contact_us_query_option" />
				<div class="mo-sc-field-div">
					<input style="width:95%" type="email" class="mo_sc_support_textbox" required name="mo_sc_contact_us_email" value="<?php echo esc_html( get_option( 'admin_email' ) ); ?>" placeholder="Enter your email">
				</div>
				<div class="mo-sc-field-div">
					<textarea class="mo_sc_table_textbox" style="width:95%" required name="mo_sc_contact_us_query" rows="4" style="resize: vertical;" placeholder="Write your query here"></textarea>
				</div>
				<div>
					<input type="submit" name="submit" style="width:120px;" class="button button-primary button-large" value="Submit"/>
				</div>
				<br><br>
			</form>
		</div>
	</div>

	<?php
}
