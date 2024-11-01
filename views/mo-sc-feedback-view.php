<?php
/**
 * File Name: mo-sc-feedback-view.php
 * Description: This file takes care of rendering the feedback form.
 *
 * @package web3-smart-contracts/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The function displays the feedback form when admin deactivate the plugin.
 *
 * @return void
 */
function mo_sc_display_feedback_form() {
	wp_enqueue_style( 'mo_sc_admin_plugin_feedback_styles', plugins_url( 'assets/css/feedback_styles.min.css', dirname( __FILE__ ) ), array(), MoScBaseConstants::VERSION, 'all' );
	?>

	<div id="mo_sc_feedback_modal" class="mo_sc_modal">

		<div class="mo_sc_feedback_content">
			<h3 style="margin: 2%; text-align:center;">
				<b>Your feedback</b>
				<span class="mo_sc_close">&times;</span>
			</h3>
			<hr class="mo_sc_feedback_hr">

			<form method="post" action="" id="mo_sc_feedback_submit">
				<?php wp_nonce_field( 'mo_sc_feedback_submit' ); ?>
				<input type="hidden" name="option" value="mo_sc_feedback_submit"/>
				<div>
					<h4 style="margin: 2%;">Please tell us what went wrong.<br></h4>

					<div style="text-align: left;padding:2% 10%;">
						<input type="radio" name="mo_sc_reason" value="Missing Features" id="sc_feature"/>
						<label for="sc_feature" class="mo_sc_feedback_option" > Does not have the features I'm looking for</label>
						<br>

						<input type="radio" name="mo_sc_reason" value="Costly" id="sc_costly" class="mo_sc_feedback_radio" />
						<label for="sc_costly" class="mo_sc_feedback_option">Do not want to upgrade - Too costly</label>
						<br>

						<input type="radio" name="mo_sc_reason" value="Confusing" id="sc_confusing" class="mo_sc_feedback_radio"/>
						<label for="sc_confusing" class="mo_sc_feedback_option">Confusing Interface</label>
						<br>

						<input type="radio" name="mo_sc_reason" value="Bugs" id="sc_bugs" class="mo_sc_feedback_radio"/>
						<label for="sc_bugs" class="mo_sc_feedback_option">Bugs in the plugin</label>
						<br>

						<input type="radio" name="mo_sc_reason" value="other" id="sc_other" class="mo_sc_feedback_radio"/>
						<label for="sc_other" class="mo_sc_feedback_option">Other Reasons</label>
						<br><br>

						<textarea id="mo_sc_query_feedback" name="mo_sc_query_feedback" rows="4" style="width: 100%"
								placeholder="Tell us what happened!"></textarea>
					</div>

					<hr class="mo_sc_feedback_hr">

					<div>Thank you for your valuable time</div>
					<br>

					<div class="mo_sc_feedback_footer">
						<input type="submit" name="miniorange_feedback_submit"
								class="button button-primary button-large" value="Send"/>
						<input type="button" name="miniorange_skip_feedback"
								class="button button-primary button-large" value="Skip" onclick="document.getElementById('mo_sc_skip_feedback').submit();"/>
					</div>
				</div>
			</form>
			<form method="post" action="" id="mo_sc_skip_feedback">
				<?php wp_nonce_field( 'mo_sc_skip_feedback' ); ?>
				<input type="hidden" name="option" value="mo_sc_skip_feedback" />
			</form>
		</div>
	</div>

	<script>
		jQuery('a[aria-label="Deactivate Web3 Smart Contracts"]').click(function () {

			var mo_modal = document.getElementById('mo_sc_feedback_modal');

			var span = document.getElementsByClassName("mo_sc_close")[0];

			mo_modal.style.display = "block";
			document.querySelector("#mo_sc_query_feedback").focus();
			span.onclick = function () {
				mo_modal.style.display = "none";
			};

			window.onclick = function (event) {
				if (event.target === mo_modal) {
					mo_modal.style.display = "none";
				}
			};

			return false;
		});
	</script>
	<?php
}

?>
