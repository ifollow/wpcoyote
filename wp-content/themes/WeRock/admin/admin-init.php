<?php

function addAndOverridePanelCSS() {
  wp_dequeue_style( 'redux-css' );
  wp_register_style(
    'redux-custom-css',
    get_template_directory_uri() . '/admin/assets/css/xv-redux.css',
    array( 'farbtastic' ), // Notice redux-css is removed and the wordpress standard farbtastic is included instead
    time(),
    'all'
  );   
  wp_enqueue_style('redux-custom-css');
}
// This example assumes your opt_name is set to redux_demo, replace with your opt_name value
add_action( 'redux/page/xv_data/enqueue', 'addAndOverridePanelCSS' );

// Load the TGM init if it exists
/*if (file_exists(dirname(__FILE__).'/tgm/tgm-init.php')) {
    require_once( dirname(__FILE__).'/tgm/tgm-init.php' );
}
*/
// Load the embedded Redux Framework
if (file_exists(dirname(__FILE__).'/ReduxCore/framework.php')) {
    require_once( dirname(__FILE__).'/ReduxCore/framework.php' );
}


// Load Redux extensions - MUST be loaded before your options are set
if (file_exists(dirname(__FILE__).'/redux-extensions/extensions-init.php')) {
    require_once( dirname(__FILE__).'/redux-extensions/extensions-init.php' );
}    

// Load the theme/plugin options
if (file_exists(dirname(__FILE__).'/options-init.php')) {
    require_once( dirname(__FILE__).'/options-init.php' );
}
