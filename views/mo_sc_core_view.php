<?php

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

function mo_sc_display_plugin_header() {
    ?>
        <h1>Smart Contracts</h1>  
    <?php
}

function mo_sc_display_settings_page() {
    $sc_type = array_key_exists('sc_type',$_REQUEST) ? sanitize_text_field($_REQUEST['sc_type']) : '';
    switch($sc_type) {
        case 'NFT':
            mo_sc_nft_page();
            break;
        default:
            mo_sc_smart_contracts_page();
            break;
    }
}