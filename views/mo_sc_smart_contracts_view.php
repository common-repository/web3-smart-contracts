<?php

function mo_sc_smart_contracts_page() {
    ?>
        <div class="mo-sc-ms-3">
            <div class="mo-sc-container-fluid">
                <div class="mo-sc-col-md-8 mo-sc-mt-4 mo-sc-ms-4">
                    Create and deploy powerful Smart Contracts on your Blockchain network in simple steps.
                </div>
                <div class="mo-sc-col-md-10 mo-sc-mt-4 mo-sc-ms-4">
                    <h4>Please select the type of Smart Contract you want to create:<h4><hr>
                </div>
                <div class="mo-sc-mt-2 mo-sc-ms-4 mo-sc-tile-container">
                    <a class="mo-sc-tile-anchor" href="<?php echo esc_url(add_query_arg('sc_type', 'NFT')); ?>">
                        <div class="mo-sc-tile">
                            <h2>NFT <code>ERC-721</code></h2>
                                <hr>
                                Create and deploy NFT smart contracts on your blockchain network.
                        </div>
                    </a>
                </div>
            </div>
        </div>
    <?php
}