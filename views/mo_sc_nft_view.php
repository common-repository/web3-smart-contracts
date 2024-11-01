<?php

function mo_sc_nft_page() {
    ?>
        <div class="mo-sc-ms-3">
            <div class="mo-sc-container-fluid">
                <div class="mo-sc-col-md-8 mo-sc-mt-4 mo-sc-ms-4">
                    <h3>Deploy a Smart Contract for your NFT collection.</h3><hr>
                </div>
                <div class="mo-sc-col-md-8 mo-sc-mt-4 mo-sc-ms-4">
                    <p>Enter the wallet address from which you want to deploy the NFT Smart contract (ERC-721).</p>
                    <strong>Wallet Address:</strong> <input type="text" id="mo-sc-nft-wallet" name="mo-sc-nft-wallet" value=""/>
                </div>

                <div class="mo-sc-col-md-8 mo-sc-mt-4 mo-sc-ms-4">
                    <input type="button" name="mo-sc-nft-deploy" id="mo-sc-nft-deploy" class="button button-primary" value="Deploy Smart Contract"/>
                </div>
            </div>
        </div>


    <?php
}