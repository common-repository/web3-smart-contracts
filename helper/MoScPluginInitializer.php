<?php

class MoScPluginInitializer {

    function mo_sc_include_plugin_files() {

        foreach (glob(MoScUtils::mo_sc_get_plugin_dir_path().'views'.DIRECTORY_SEPARATOR.'*.php') as $filename)
        {
            include_once $filename;
        }
        foreach (glob(MoScUtils::mo_sc_get_plugin_dir_path().'handler'.DIRECTORY_SEPARATOR.'*.php') as $filename)
        {
            include_once $filename;
        }
        foreach (glob(MoScUtils::mo_sc_get_plugin_dir_path().'helper'.DIRECTORY_SEPARATOR.'*.php') as $filename)
        {
            include_once $filename;
        }
        foreach (glob(MoScUtils::mo_sc_get_plugin_dir_path().'helper'.DIRECTORY_SEPARATOR.'constants'.DIRECTORY_SEPARATOR.'*.php') as $filename)
        {
            include_once $filename;
        }
    }

    function mo_sc_initialize_hooks() {
        add_action('admin_menu', array($this, 'mo_sc_menu')); 
        add_action('admin_enqueue_scripts', array($this, 'mo_sc_enqueue_styles'));
        add_action('admin_enqueue_scripts', array($this, 'mo_sc_enqueue_scripts'));
        add_action( 'plugin_action_links_' . MoScUtils::mo_sc_get_plugin_basename(), array($this,'mo_sc_plugin_action_links') );
        add_action( 'admin_init' , array(MoScBaseFormHandler::class, 'moScHandleFormData'));
    }

    function mo_sc_menu() {
        $page = add_menu_page( 'Web3 Smart Contracts', 'Web3 Smart Contracts', 'administrator', 'mo_smart_contracts', 'mo_sc_settings' , MoScUtils::mo_sc_get_plugin_dir_url() . 'images/miniorange.png' );
    }

    function mo_sc_enqueue_styles($page) {
        if($page != 'toplevel_page_mo_smart_contracts')
            return;

        wp_enqueue_style('mo_sc_plugin_admin_style', plugins_url('assets/css/styles.min.css', dirname(__FILE__)), array(), MoScBaseConstants::Version, 'all');
    }

    function mo_sc_enqueue_scripts($page) {
        if($page != 'toplevel_page_mo_smart_contracts')
            return;

        wp_enqueue_script("jQuery");
        wp_enqueue_script('mo_sc_web3_script', plugins_url('assets/js/web3.min.js', dirname(__FILE__)), array(), MoScBaseConstants::Version, false);
        wp_enqueue_script('mo_sc_smart_contracts_script', plugins_url('assets/js/smart-contract.min.js', dirname(__FILE__)), array(), MoScBaseConstants::Version, false);
    }

    function mo_sc_plugin_action_links($links){
        $links = array_merge( array(
			'<a href="' . esc_url( admin_url( 'admin.php?page=mo_smart_contracts' ) ) . '">' . __( 'Settings','miniorange-smart-contracts' ) . '</a>'
		), $links );
		return $links;
    }
}