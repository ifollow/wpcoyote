<?php

class DZSPageBuilder {

    private static $_singleton;
    public $thepath = '';
    private $maintemplates;
    private $mainpagessliders;
    public $mainoptions;
    private $mainargs; //args for the current PageBuilder instance
    private $pageoptions;
    private $db_pagesliders = 'pagebuilder_pages'; /// ==== page layouts
    private $db_pagetemplates = 'pagebuilder_templates'; /// === templates
    private $db_mainoptions = 'pagebuilder_mainoptions'; /// === option
    private $translatevar = 'dzspb';
    private $pluginmode = 'plugin';
    private $allowed_posts_for_meta = array('post', 'dzs_portfolio');
    private $sliders_index_as = 0;

    function __construct() {


        if ($this->pluginmode == 'themedzsp') {
            $this->thepath = THEME_URL . 'plugins/dzs-portfolio/plugins/dzs-pagebuilder/';
        } else {
            if ($this->pluginmode == 'theme') {
                $this->thepath = THEME_URL . 'plugins/dzs-pagebuilder/';
            } else {
                $this->thepath = plugins_url('', __FILE__) . '/';
            }
        }

//        echo 'ceva'.$this->thepath;

        $this->maainargs = array(
            'title' => __('Page Builder', 'dzspb'),
        );



        $defaultOpts = array(
            'mode' => 'editor',
            'embed_always' => 'on',
            'layout_name_dzspb_con' => 'dzspb_lay_con',
            'layout_name_dzspb_raw' => 'dzspb_layb_raw',
            'layout_name_dzspb_one_full' => 'dzspb_layb_one_full',
            'layout_name_dzspb_one_half' => 'dzspb_layb_one_half',
            'layout_name_dzspb_one_third' => 'dzspb_layb_one_third',
            'layout_name_dzspb_two_third' => 'dzspb_layb_two_third',
            'layout_name_dzspb_one_fourth' => 'dzspb_layb_one_fourth',
            'layout_name_dzspb_three_fourth' => 'dzspb_layb_three_fourth',
            'layout_name_dzspb_layout_con' => 'dzspb_layb_layout',
            'pb_post_types' => array('post', 'page', 'dzs_portfolio')
        );
        $this->mainoptions = get_option($this->db_mainoptions);

        //==== default opts / inject into db
        if ($this->mainoptions == '') {
            $this->mainoptions = $defaultOpts;
            update_option($this->db_mainoptions, $this->mainoptions);
        }

        $this->mainoptions = array_merge($defaultOpts, $this->mainoptions);



        $this->maintemplates = get_option($this->db_pagetemplates);
        if ($this->maintemplates == '') {
            /*
              $this->maintemplates = array(
              array(
              'name' => 'main template',
              'output' => '',
              'type' => '',
              ),
              );
             * 
             */
            $this->maintemplates = array();
        };


        $this->mainpagessliders = get_option($this->db_pagesliders);


        $this->pageoptions = array(
            'page' => '',
            'mode' => 'default',
            'templatename' => '',
        );


        add_action('init', array($this, 'handle_init'));
        add_action('add_meta_boxes', array($this, 'handle_add_meta_boxes'));
        add_action('admin_head', array($this, 'handle_admin_head'));
        add_action('admin_menu', array($this, 'handle_admin_menu'));
        add_action('admin_footer', array($this, 'handle_admin_footer'));

        if ($this->mainoptions['mode'] == 'meta') {
            add_filter('the_content', array($this, 'filter_the_content'));
        }


        add_action('wp_ajax_pagebuilder_save', array($this, 'ajax_pagebuilder_save'));
        add_action('wp_ajax_pagebuilder_changetemplatename', array($this, 'ajax_pagebuilder_changetemplatename'));
        add_action('wp_ajax_dzspb_ajax_mo', array($this, 'ajax_dzspb_ajax_mo'));
        add_action('wp_ajax_dzspb_preparePreview', array($this, 'ajax_dzspb_preparePreview'));



        add_shortcode('pb_lay_raw', array($this, 'shortcode_pb_lay_raw'));


        add_shortcode('pb_lay_one_full', array($this, 'shortcode_pb_lay_one_full'));
        add_shortcode('pb_lay_one_half_one_half', array($this, 'shortcode_pb_lay_one_half_one_half'));
        add_shortcode('pb_lay_two_third_one_third', array($this, 'shortcode_pb_lay_two_third_one_third'));
        add_shortcode('pb_lay_one_third_two_third', array($this, 'shortcode_pb_lay_one_third_two_third'));
        add_shortcode('pb_lay_one_third_one_third_one_third', array($this, 'shortcode_pb_lay_one_third_one_third_one_third'));
        add_shortcode('pb_lay_one_half_one_fourth_one_fourth', array($this, 'shortcode_pb_lay_one_half_one_fourth_one_fourth'));
        add_shortcode('pb_lay_one_fourth_one_half_one_fourth', array($this, 'shortcode_pb_lay_one_fourth_one_half_one_fourth'));
        add_shortcode('pb_lay_one_fourth_one_fourth_one_half', array($this, 'shortcode_pb_lay_one_fourth_one_fourth_one_half'));
        add_shortcode('pb_lay_one_fourth_one_fourth_one_fourth_one_fourth', array($this, 'shortcode_pb_lay_one_fourth_one_fourth_one_fourth_one_fourth'));

        add_shortcode('pb_layb_one_full', array($this, 'shortcode_pb_layb_one_full'));
        add_shortcode('pb_layb_one_half', array($this, 'shortcode_pb_layb_one_half'));
        add_shortcode('pb_layb_one_third', array($this, 'shortcode_pb_layb_one_third'));
        add_shortcode('pb_layb_two_third', array($this, 'shortcode_pb_layb_two_third'));
        add_shortcode('pb_layb_one_fourth', array($this, 'shortcode_pb_layb_one_fourth'));
        add_shortcode('pb_layb_three_fourth', array($this, 'shortcode_pb_layb_three_fourth'));


        add_shortcode('shortcode_ul', array($this, 'shortcode_ul'));
        add_shortcode('shortcode_dzs_li', array($this, 'shortcode_li'));


        add_shortcode("advancedscroller", array($this, 'show_shortcode_as'));


        add_action('save_post', array($this, 'admin_meta_save'));

        //add_action('wp_ajax_nopriv_pagebuilder_save', array($this, 'ajax_pagebuilder_save'));
    }

    public function get_page_layouts() {
        return $this->mainpagessliders;
    }

    function shortcode_pb_lay_one_half_one_half($atts, $content = null) {

        $fout = '';
        if ($this->mainoptions['layout_name_dzspb_con'] != '') {
            $fout.='<div class="' . $this->mainoptions['layout_name_dzspb_con'] . '">';
        }
        $fout.=stripslashes(do_shortcode($content));
        if ($this->mainoptions['layout_name_dzspb_con'] != '') {
            $fout.='</div>';
        }
        return $fout;
    }

    function shortcode_pb_lay_two_third_one_third($atts, $content = null) {

        $fout = '';
        if ($this->mainoptions['layout_name_dzspb_con'] != '') {
            $fout.='<div class="' . $this->mainoptions['layout_name_dzspb_con'] . '">';
        }
        $fout.=stripslashes(do_shortcode($content));
        if ($this->mainoptions['layout_name_dzspb_con'] != '') {
            $fout.='</div>';
        }
        return $fout;
    }

    function shortcode_pb_lay_one_third_two_third($atts, $content = null) {

        $fout = '';
        if ($this->mainoptions['layout_name_dzspb_con'] != '') {
            $fout.='<div class="' . $this->mainoptions['layout_name_dzspb_con'] . '">';
        }
        $fout.=stripslashes(do_shortcode($content));
        if ($this->mainoptions['layout_name_dzspb_con'] != '') {
            $fout.='</div>';
        }
        return $fout;
    }

    function shortcode_pb_lay_one_third_one_third_one_third($atts, $content = null) {

        $fout = '';
        if ($this->mainoptions['layout_name_dzspb_con'] != '') {
            $fout.='<div class="' . $this->mainoptions['layout_name_dzspb_con'] . '">';
        }
        $fout.=stripslashes(do_shortcode($content));
        if ($this->mainoptions['layout_name_dzspb_con'] != '') {
            $fout.='</div>';
        }
        return $fout;
    }

    function shortcode_pb_lay_one_half_one_fourth_one_fourth($atts, $content = null) {

        $fout = '';
        if ($this->mainoptions['layout_name_dzspb_con'] != '') {
            $fout.='<div class="' . $this->mainoptions['layout_name_dzspb_con'] . '">';
        }
        $fout.=stripslashes(do_shortcode($content));
        if ($this->mainoptions['layout_name_dzspb_con'] != '') {
            $fout.='</div>';
        }
        return $fout;
    }

    function shortcode_pb_lay_one_fourth_one_half_one_fourth($atts, $content = null) {

        $fout = '';
        if ($this->mainoptions['layout_name_dzspb_con'] != '') {
            $fout.='<div class="' . $this->mainoptions['layout_name_dzspb_con'] . '">';
        }
        $fout.=stripslashes(do_shortcode($content));
        if ($this->mainoptions['layout_name_dzspb_con'] != '') {
            $fout.='</div>';
        }
        return $fout;
    }

    function shortcode_pb_lay_one_fourth_one_fourth_one_half($atts, $content = null) {

        $fout = '';
        if ($this->mainoptions['layout_name_dzspb_con'] != '') {
            $fout.='<div class="' . $this->mainoptions['layout_name_dzspb_con'] . '">';
        }
        $fout.=stripslashes(do_shortcode($content));
        if ($this->mainoptions['layout_name_dzspb_con'] != '') {
            $fout.='</div>';
        }
        return $fout;
    }

    function shortcode_pb_lay_one_fourth_one_fourth_one_fourth_one_fourth($atts, $content = null) {

        $fout = '';
        if ($this->mainoptions['layout_name_dzspb_con'] != '') {
            $fout.='<div class="' . $this->mainoptions['layout_name_dzspb_con'] . '">';
        }
        $fout.=stripslashes(do_shortcode($content));
        if ($this->mainoptions['layout_name_dzspb_con'] != '') {
            $fout.='</div>';
        }
        return $fout;
    }

    function shortcode_pb_lay_one_full($atts, $content = null) {

        $fout = '';
        if ($this->mainoptions['layout_name_dzspb_con'] != '') {
            $fout.='<div class="' . $this->mainoptions['layout_name_dzspb_con'] . '">';
        }
        $fout.=stripslashes(do_shortcode($content));
        if ($this->mainoptions['layout_name_dzspb_con'] != '') {
            $fout.='</div>';
        }
        return $fout;
    }

    function layb_type_parser($atts = array()) {
        $fout = '';
        $margs = array(
            'type' => 'Simple'
        );
        if(is_array($atts)==false){
            $atts = array();
        }
        $margs = array_merge($margs, $atts);
        if ($margs['type'] == 'Separator') {
            $fout.='<hr class="dzspb-separator">';
        }
        return $fout;
    }

    function layb_type_parser_end($atts = array()) {
        $fout = '';
        $margs = array(
            'type' => 'Simple'
        );
        if(is_array($atts)==false){
            $atts = array();
        }
        $margs = array_merge($margs, $atts);
        if ($margs['type'] == 'Separator') {
            
        }
        return $fout;
    }

    function shortcode_pb_layb_one_full($atts, $content = null) {

        $fout = '';
        //print_r($atts);
        $fout.='<div class="' . $this->mainoptions['layout_name_dzspb_one_full'] . '">';
        $fout.=$this->layb_type_parser($atts);
        $fout.=stripslashes(do_shortcode($content));
        $fout.=$this->layb_type_parser_end($atts);
        $fout.='</div>';
        return $fout;
    }

    function shortcode_pb_layb_one_half($atts, $content = null) {
        //[pb_layb_one_half type="Simple"]test[/pb_layb_one_half]
        $fout = '';
        $fout.='<div class="' . $this->mainoptions['layout_name_dzspb_one_half'] . '">';
        $fout.=$this->layb_type_parser($atts);
        $fout.=stripslashes(do_shortcode($content));
        $fout.=$this->layb_type_parser_end($atts);
        $fout.='</div>';
        return $fout;
    }

    function shortcode_pb_layb_one_third($atts, $content = null) {

        $fout = '';
        $fout.='<div class="' . $this->mainoptions['layout_name_dzspb_one_third'] . '">';
        $fout.=$this->layb_type_parser($atts);
        $fout.=stripslashes(do_shortcode($content));
        $fout.=$this->layb_type_parser_end($atts);
        $fout.='</div>';
        return $fout;
    }

    function shortcode_pb_layb_two_third($atts, $content = null) {

        $fout = '';
        $fout.='<div class="' . $this->mainoptions['layout_name_dzspb_two_third'] . '">';
        $fout.=$this->layb_type_parser($atts);
        $fout.=stripslashes(do_shortcode($content));
        $fout.=$this->layb_type_parser_end($atts);
        $fout.='</div>';
        return $fout;
    }

    function shortcode_pb_layb_one_fourth($atts, $content = null) {

        $fout = '';
        $fout.='<div class="' . $this->mainoptions['layout_name_dzspb_one_fourth'] . '">';
        $fout.=$this->layb_type_parser($atts);
        $fout.=stripslashes(do_shortcode($content));
        $fout.=$this->layb_type_parser_end($atts);
        $fout.='</div>';
        return $fout;
    }

    function shortcode_pb_layb_three_fourth($atts, $content = null) {

        $fout = '';
        $fout.='<div class="' . $this->mainoptions['layout_name_dzspb_three_fourth'] . '">';
        $fout.=stripslashes(do_shortcode($content));
        $fout.='</div>';
        return $fout;
    }

    function admin_meta_save($post_id) {
        global $post;
        if (!$post) {
            return;
        }
        /* Check autosave */
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return $post_id;
        }
        if (isset($_REQUEST['dzs_nonce'])) {
            $nonce = $_REQUEST['dzs_nonce'];
            if (!wp_verify_nonce($nonce, 'dzs_nonce'))
                wp_die('Security check');
        }
        if (is_array($_POST)) {
            $auxa = $_POST;
            //print_r($_POST);
            if (isset($_POST['dzspb_last_editor'])) {
                DZSHelpers::wp_savemeta($post->ID, 'dzspb_last_editor', $_POST['dzspb_last_editor']);
            }
            /*
              foreach ($auxa as $label => $value) {

              //print_r($label); print_r($value);
              if (strpos($label, 'dzspb_') !== false) {
              DZSHelpers::wp_save_meta($post->ID, $label, $value);
              }
              }
             * 
             */
        }
    }

    public function shortcode_pb_lay_raw($atts, $content = '') {
        $fout = '';
        $fout.='<div class="' . $this->mainoptions['layout_name_dzspb_raw'] . '">';
        //die('ceva'.$content.'alceva');
        $fout.=stripslashes(do_shortcode($content));
        $fout.='</div>';
        return $fout;
    }

    function ajax_dzspb_preparePreview() {

        echo stripslashes(do_shortcode($_POST['postdata']));
        die();
    }

    function ajax_dzspb_ajax_mo() {

        $auxarray = array();
        //parsing post data
        parse_str($_POST['postdata'], $auxarray);
//        print_r($auxarray);

        if (!isset($auxarray['pb_post_types'])) {
            $auxarray['pb_post_types'] = array();
        }

        update_option($this->db_mainoptions, $auxarray);
        die();
    }

    function handle_add_meta_boxes() {
        if ($this->mainoptions['mode'] != 'meta') {
            return;
        }
        foreach ($this->allowed_posts_for_meta as $allowed_post_for_meta) {
            add_meta_box('dzspb_builder', __('Page Builder', 'dzspb'), array($this, 'admin_meta_builder'), $allowed_post_for_meta, 'normal', 'high');
        }
    }

    function handle_init() {
        global $post;

//        print_r($post);

        wp_enqueue_script('jquery');
        if (is_admin()) {
            if (current_user_can('edit_posts') || current_user_can('edit_pages')) {

                wp_enqueue_script('jquery-ui-core');
                wp_enqueue_script('jquery-ui-sortable');
                wp_enqueue_script('jquery-ui-droppable');
                wp_enqueue_script('dzspb.admin', $this->thepath . 'admin/admin.js');
                wp_enqueue_style('dzspb.admin', $this->thepath . 'admin/admin.css');


                wp_enqueue_script('dzs.pagebuilder', $this->thepath . 'admin/pagebuilder.js');
                wp_enqueue_style('dzs.pagebuilder', $this->thepath . 'admin/pagebuilder.css');


                wp_enqueue_script('dzs.zoombox', $this->thepath . 'zoombox/zoombox.js');
                wp_enqueue_style('dzs.zoombox', $this->thepath . 'zoombox/zoombox.css');


                if (isset($_GET['page']) && $_GET['page'] == 'dzsbp-mo') {
                    wp_enqueue_style('iphone.checkbox', $this->thepath . 'admin/checkbox/checkbox.css');
                    wp_enqueue_script('iphone.checkbox', $this->thepath . "admin/checkbox/checkbox.dev.js");
                }
            }
        } else {
            if ($this->mainoptions['embed_always'] == 'on') {
                $this->front_scripts();
            }
        }
    }

    function handle_admin_menu() {
        //echo 'cevaa';
        if ($this->pluginmode == 'wha') {
            //$zsvg_page = add_theme_page(__('DZS Video Gallery', 'dzspb'), __('DZS Video Gallery', 'dzspb'), $this->admin_capability, $this->adminpagename, array($this, 'admin_page'));
        } else {
            //echo 'ceva';
            add_options_page(__('PageBuilder Settings', 'dzspb'), __('DZS PageBuilder Settings', 'dzspb'), 'manage_options', 'dzspb-mo', array($this, 'admin_page_mainoptions'));
        }
        //echo $zsvg_page;
    }

    function handle_admin_head() {
        global $post, $forcepagebuilder;


//        echo 'ceva2'.$forcepagebuilder;
        if ($post == false && $forcepagebuilder == false) {
            return;
        }

        if (in_array($post->post_type, $this->mainoptions['pb_post_types']) == false && $forcepagebuilder == false) {
            return;
        }
//        echo 'whoawhoa';


        $mode = $this->mainoptions['mode'];
        
        if($this->pageoptions['mode']!='default'){
            $mode = $this->pageoptions['mode'];
        }
        
        
        

        $currSlider = 'none';
        if (isset($_REQUEST['currslider'])) {
            $currSlider = $_GET['currslider'];
        } else {
            
        }
        
//        echo 'currslider'.$currSlider; print_r($its);

//        print_r($this->maintemplates);
        $templatename = '';
        if ($currSlider != 'none') {
            if (isset($this->maintemplates[$currSlider])) {
                $its = $this->maintemplates[$currSlider];
                $templatename = $its['settings']['name'];
            }
        }
        
        if($this->pageoptions['templatename']!=''){
            $templatename = $this->pageoptions['templatename'];
        }else{
            if($post){
                $templatename = 'post'.$post->ID;
            }
        }

        $san_struct_layoutbody = $this->insert_layout_body();
        $san_struct_layoutbody = str_replace(array("\r", "\r\n", "\n", "'"), '', $san_struct_layoutbody);

        //print_r(get_post_meta_all($post->ID));
        ?><script>
            var pagebuilder_settings = {
                ajaxurl: "<?php echo admin_url('admin-ajax.php'); ?>"
                , currSlider: "<?php echo $currSlider; ?>"
                , pageid: "<?php echo $this->pageoptions['page']; ?>"
                , mode: "<?php echo $mode; ?>"
                , templatename: "<?php echo $templatename; ?>"
                , structure_layoutbody: '<?php echo $san_struct_layoutbody; ?>'
                , last_editor: '<?php echo get_post_meta($post->ID, 'dzspb_last_editor', true); ?>'
                , thepath: '<?php echo $this->thepath; ?>'
            };
            var dzspb_settings = pagebuilder_settings;
            jQuery(document).ready(function($) {
                //zoomdropdown_init('.zoomdropdown-con', {});
            })
        </script><?php
    }

    function handle_admin_footer() {
        global $post;
        if ($post == false) {
            return;
        }
//        print_r($post);
        if ($this->mainoptions['mode'] == 'editor') {


            $args = array(
                //'thepath' => $this->thepath . 'admin/pagebuilder/',
                'page' => 'item'.$post->ID,
                'title' => "Page Builder",
            );
            $this->set_config($args);

            echo '<div class="aux-pb-holder">';
            $this->show_gui();
            echo '</div>';
        }
        ?><script>
            jQuery(document).ready(function($) {
                dzspb_builder_ready();
                init_zoombox();
            })
        </script><?php
                }

                function admin_page_mainoptions() {
                    //print_r($this->mainoptions);
                    //echo $this->mainoptions['twitter_token'];
                    ?>

        <div class="wrap">
            <h2><?php echo __('Page Builder Main Settings', 'dzspb'); ?></h2>
            <br/>
            <form class="mainsettings">
                <h3><?php echo __('Admin Options', 'dzspb'); ?></h3>

                <div class="setting">
                    <div class="label"><?php echo __('Main Container', 'dzspb'); ?></div>
                    <?php echo DZSHelpers::generate_input_text('layout_name_dzspb_con', array('val' => '', 'seekval' => $this->mainoptions['layout_name_dzspb_con'])); ?>
                    <div class="sidenote"><?php echo __('', 'dzspb'); ?></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Layout Layout Container', 'dzspb'); ?></div>
                    <?php echo DZSHelpers::generate_input_text('layout_name_dzspb_layout_con', array('val' => '', 'seekval' => $this->mainoptions['layout_name_dzspb_layout_con'])); ?>
                    <div class="sidenote"><?php echo __('', 'dzspb'); ?></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Layout Raw Class', 'dzspb'); ?></div>
                    <?php echo DZSHelpers::generate_input_text('layout_name_dzspb_raw', array('val' => '', 'seekval' => $this->mainoptions['layout_name_dzspb_raw'])); ?>
                    <div class="sidenote"><?php echo __('', 'dzspb'); ?></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Layout One Full', 'dzspb'); ?></div>
                    <?php echo DZSHelpers::generate_input_text('layout_name_dzspb_one_full', array('val' => '', 'seekval' => $this->mainoptions['layout_name_dzspb_one_full'])); ?>
                    <div class="sidenote"><?php echo __('', 'dzspb'); ?></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Layout One Half', 'dzspb'); ?></div>
                    <?php echo DZSHelpers::generate_input_text('layout_name_dzspb_one_half', array('val' => '', 'seekval' => $this->mainoptions['layout_name_dzspb_one_half'])); ?>
                    <div class="sidenote"><?php echo __('', 'dzspb'); ?></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Layout One Third', 'dzspb'); ?></div>
                    <?php echo DZSHelpers::generate_input_text('layout_name_dzspb_one_third', array('val' => '', 'seekval' => $this->mainoptions['layout_name_dzspb_one_third'])); ?>
                    <div class="sidenote"><?php echo __('', 'dzspb'); ?></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Layout Two Third', 'dzspb'); ?></div>
                    <?php echo DZSHelpers::generate_input_text('layout_name_dzspb_two_third', array('val' => '', 'seekval' => $this->mainoptions['layout_name_dzspb_two_third'])); ?>
                    <div class="sidenote"><?php echo __('', 'dzspb'); ?></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Layout One Fourth', 'dzspb'); ?></div>
                    <?php echo DZSHelpers::generate_input_text('layout_name_dzspb_one_fourth', array('val' => '', 'seekval' => $this->mainoptions['layout_name_dzspb_one_fourth'])); ?>
                    <div class="sidenote"><?php echo __('', 'dzspb'); ?></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Layout Three Fourth', 'dzspb'); ?></div>
        <?php echo DZSHelpers::generate_input_text('layout_name_dzspb_three_fourth', array('val' => '', 'seekval' => $this->mainoptions['layout_name_dzspb_three_fourth'])); ?>
                    <div class="sidenote"><?php echo __('', 'dzspb'); ?></div>
                </div>
                <div class="dzs-setting"> 
                    <h4><?php echo __('Mode ', 'dzspb'); ?></h4>
                    <?php
                    $lab = 'mode';
                    echo DZSHelpers::generate_select($lab, array('class' => 'styleme', 'def_value' => '', 'seekval' => $this->mainoptions[$lab], 'options' => array(
                            array(
                                'val' => 'editor',
                                'lab' => __('editor', 'dzspb'),
                            ),
                            array(
                                'val' => 'meta',
                                'lab' => __('meta', 'dzspb'),
                            ),
                    )));
                    ?>
                    <div class="clear"></div>
                    <div class='sidenote'><?php echo __('allows to display Pages too in the Portfolio .. and set option for them', 'dzspb'); ?></div>
                    <div class="clear"></div>
                </div>
                <div class="dzs-setting"> 
                    <h4><?php echo __('Enable Page Builder for ... ', 'dzspb'); ?></h4>
                    <?php
                    $lab = 'pb_post_types';
//        print_r($this->mainoptions[$lab]);
//        print_r(get_option('active_plugins'));



                    $args = array(
                        'public' => true,
                        '_builtin' => false
                    );

                    $output = 'names'; // names or objects, note names is the default
                    $operator = 'and'; // 'and' or 'or'

                    $post_types = get_post_types($args, $output, $operator);




                    echo DZSHelpers::generate_input_checkbox($lab . '[]', array('class' => 'styleme', 'def_value' => '', 'seekval' => $this->mainoptions[$lab], 'val' => 'post'));
                    echo __(' post', 'dzspb');
                    echo '<br/>';
                    echo DZSHelpers::generate_input_checkbox($lab . '[]', array('class' => 'styleme', 'def_value' => '', 'seekval' => $this->mainoptions[$lab], 'val' => 'page'));
                    echo __(' page', 'dzspb');
                    echo '<br/>';
                    foreach ($post_types as $post_type) {
                        echo DZSHelpers::generate_input_checkbox($lab . '[]', array('class' => 'styleme', 'def_value' => '', 'seekval' => $this->mainoptions[$lab], 'val' => $post_type));
                        echo __(' ' . $post_type, 'dzspb');
                        echo '<br/>';
                    }
                    ?>
                    <div class="clear"></div>
                    <div class='sidenote'><?php echo __('allows to display Pages too in the Portfolio .. and set option for them', 'dzspb'); ?></div>
                    <div class="clear"></div>
                </div>
                <br/>
                <a href='#' class="button-primary save-btn save-mainoptions"><?php echo __('Save Options', 'dzspb'); ?></a>
            </form>
            <div class="saveconfirmer" style=""><img alt="" style="" id="save-ajax-loading2" src="<?php echo site_url(); ?>/wp-admin/images/wpspin_light.gif"/></div>
            <script>
                jQuery(document).ready(function($) {
                    dzspb_mainoptions_ready();
                })
            </script>
        </div>
        <?php
    }

    function admin_meta_builder() {
        global $post;
        //print_r($post);


        $args = array(
            //'thepath' => $this->thepath . 'admin/pagebuilder/',
            'page' => 'item' . $post->ID,
        );
        $this->set_config($args);
        $this->show_gui();
    }

    public static function getInstance() {
        if (is_null(self::$_singleton)) {
            self::$_singleton = new PageBuilder();
        }
        return self::$_singleton;
    }

    function set_config($pargs) {
        
        if(is_array($pargs)==false){
            $pargs = array();
        }
        $this->pageoptions = array_merge($this->pageoptions, $pargs);
        if (isset($pargs['thepath'])) {
            $this->thepath = $pargs['thepath'];
        }
    }

    function get_layout($page) {
        // get the layout object for a specific page

        if (isset($this->mainpagessliders[$page]) && $this->mainpagessliders[$page] != '') {
            return $this->mainpagessliders[$page];
        };
    }

    function ajax_pagebuilder_save() {

        //print_r($_POST);
        //echo 'success - ';
        $temparray = array();
        parse_str($_POST['postdata'], $temparray);
        //print_r($this->maintemplates);
        //$this->maintemplates = unserialize($mainarray);
        
        
        
        
        //===if slider id is set, then it's a template we are saving.
        if (isset($_POST['sliderid'])) {
            $this->maintemplates[$_POST['sliderid']] = $temparray;
            
            
            if (isset($_POST['slidername'])) {
                $templatename = $_POST['slidername'];
                foreach($this->maintemplates as $maintemplate){
                    if($maintemplate['settings']['name'] == $templatename){
                        $templatename = $templatename.rand(0,999);
                    }
                }
                
                $this->maintemplates[$_POST['sliderid']]['settings']['name'] = $templatename;
            }
            
//            print_r($this->maintemplates);

            
            // === transforms "none" into .index.
            $this->maintemplates = array_values($this->maintemplates);
            update_option($this->db_pagetemplates, $this->maintemplates);
        }

        //===if page id is set, then it's a page layout we are saving.
        if (isset($_POST['pageid'])) {
            
//            if(isset($_POST['saveoption']) && $_POST['saveoption']=='on'){
//                
//                
//            }else{
                
//            }
            
            print_r($temparray);
            
            $this->mainpagessliders[$_POST['pageid']] = $temparray;
            //$this->mainpagessliders = array_values($this->mainpagessliders);
            update_option($this->db_pagesliders, $this->mainpagessliders);
        }

        

        die();
    }

    function ajax_pagebuilder_changetemplatename() {
        if (isset($_POST['template_ind'])) {
            $this->maintemplates[$_POST['template_ind']]['settings']['name'] = $_POST['postdata'];
            update_option($this->db_pagetemplates, $this->maintemplates);
        }
        //print_r($this->maintemplates);
        die();
    }

    function insert_layout_body($pargs = array()) {
        $margs = array(
            'content' => '',
            'title' => 'Simple',
        );
        $margs = array_merge($margs, $pargs);

        $sanitized_title = $margs['title'];

        $sanitized_title = str_replace(' ', '-', $sanitized_title);

        $layoutbody = '<div class="dzs-layout-body title-' . $sanitized_title . '">
<div class="dzs-layout-body-header">
<div class="switcher-type" style="display:inline-block;"><!--<div class="aux-padder"></div>-->
<i class="fa fa-caret-down"></i> <div class="the-label" style="color: #eee;">' . $margs['title'] . '</div>
<!--<ul class="zoomdropdown" style="z-index:999; top:100%; width: 240px; box-shadow: 0 0 5px 0 rgba(101,100,100,0.2)">
    <li class="dd-selectitem-type" style=" ">Simple</li><li class="dd-selectitem-type dd-selectitem-type-is-content" style="">Content</li><li class="dd-selectitem-type" style="">Gallery</li>
</ul>-->
</div>

</div>
<div class="textarea-con"><textarea class="the-layout-body-content">' . $margs['content'] . '</textarea></div>
    <input class="field-title" type="hidden" value="' . $margs['title'] . '"/>
</div>';
        return $layoutbody;
    }

    function front_scripts() {
        wp_enqueue_script('dzs.advancedscroller', $this->thepath . 'advancedscroller/plugin.js');
        wp_enqueue_style('dzs.advancedscroller', $this->thepath . 'advancedscroller/plugin.css');

        wp_enqueue_style('dzs.front.pagebuilder', $this->thepath . 'front-pagebuilder.css');
        
        

        //if($this->mainoptions['embed_masonry']=='on'){
        //wp_enqueue_script('jquery.masonry', $this->thepath . "masonry/jquery.masonry.min.js");
        //}
    }

    function filter_the_content($content) {
        global $post;
        if ($post->post_type != 'dzs_portfolio') {
            return $content;
        }
        $fout = '';

        $pagelayouts = ($this->get_page_layouts());

        $sw = false;


        $i = 0;
        $k = 0;
        $id = 'item' . $post->ID;



        if (is_array($pagelayouts) && count($pagelayouts) > 0) {
            foreach ($pagelayouts as $lab => $pagelayout) {
                if ((isset($id)) && ($id == $pagelayout['settings']['name'])) {
                    $k = $lab;
                    $sw = true;
                    //echo 'ceva' . $id . $k . 'id ' . $id . '  ' . 'pagelayout - ' . $pagelayout['settings']['name'] . 'next ... '. 'cacat'.$sw==false.' sw==true?'.$sw;
                }
            }
        }


        if ($sw == false) {
            return $content;
        }

        $this->front_scripts();
        $its = $pagelayouts[$k];

        //print_r($its);

        if (is_array($its['layout'])) {
            $layout_buffer = 0;
            foreach ($its['layout'] as $layout) {
                //print_r($layout);
                $fout.= '<div class="' . $this->mainoptions['layout_name_dzspb_layout_con'] . '">';
                $rel_arr_aux = $layout['settings']['rel'];
                $rel_arr = explode("+", $rel_arr_aux);
                $i = 0;
                foreach ($rel_arr as $layoutbodyrel) {
                    //$fout.= $layoutbodyrel;
                    $closeit = false;

                    //echo 'ceva'.(calculate_string('1/3') + 0.01);

                    /*
                     * 
                     * == overflow but not the case
                      $layout_buffer+=(calculate_string('1/3') + 0.01);

                      if($layout_buffer>=1.1){
                      $fout.= '<div class="clear"></div>';
                      $layout_buffer = 0;
                      }
                     * 
                     */

                    if ($layoutbodyrel == '1/1') {
                        $layout_buffer+=1;
                        $fout.= '<div class="' . $this->mainoptions['layout_name_dzspb_one_full'] . '">';
                        $closeit = true;
                    }
                    if ($layoutbodyrel == '1/2') {
                        $layout_buffer+=0.5;
                        $fout.= '<div class="' . $this->mainoptions['layout_name_dzspb_one_half'] . '">';
                        $closeit = true;
                    }
                    if ($layoutbodyrel == '1/3') {
                        $layout_buffer+=0.34;
                        $fout.= '<div class="' . $this->mainoptions['layout_name_dzspb_one_third'] . '">';
                        $closeit = true;
                    }
                    if ($layoutbodyrel == '2/3') {
                        $layout_buffer+=0.67;
                        $fout.= '<div class="' . $this->mainoptions['layout_name_dzspb_two_third'] . '">';
                        $closeit = true;
                    }
                    if ($layoutbodyrel == '1/4') {
                        $layout_buffer+=0.25;
                        $fout.= '<div class="' . $this->mainoptions['layout_name_dzspb_one_fourth'] . '">';
                        $closeit = true;
                    }
                    if ($layoutbodyrel == '3/4') {
                        $layout_buffer+=0.75;
                        $fout.= '<div class="' . $this->mainoptions['layout_name_dzspb_three_fourth'] . '">';
                        $closeit = true;
                    }


                    if ($layout[$i]['title'] != 'Content') {
                        $fout.= stripslashes(do_shortcode($layout[$i]['content']));
                    } else {
                        //this is the actual post content
                        $fout.=$content;
                    }

                    if ($closeit) {
                        $fout.= '</div>';
                    }

                    //print_r($layout[$i]);
                    $i++;


                    //echo $layout_buffer;
                    if ($layout_buffer >= 1) {
                        $fout.= '<div class="clear"></div>';
                        $layout_buffer = 0;
                    }
                }
                $fout.= '</div>';
            }
        } else {
            return $content;
        }


        return $fout;
    }
    
    public function parse_layout($playb){
        
        $fout = '';
        
        
        if($playb['settings']['rel']!='raw'){
            $fout.= '<div class="'.$this->mainoptions['layout_name_dzspb_layout_con'].'">';
        

            $rel_arr_aux = $playb['settings']['rel'];
            $rel_arr = explode("+", $rel_arr_aux);
            $i = 0;
            foreach ($rel_arr as $layoutbodyrel) {
    //            print_r($layoutbodyrel); /// === 1/2 astea


                    if ($layoutbodyrel == '1/1') {
                        $layout_buffer+=1;
                        $fout.= '[pb_layb_one_full type="'.$playb[$i]['title'].'"]';
                        $fout.=$playb[$i]['content'];
                        $fout.= '[/pb_layb_one_full]';
                    }
                    if ($layoutbodyrel == '1/2') {


                        $layout_buffer+=0.5;
                        $fout.= '[pb_layb_one_half type="'.$playb[$i]['title'].'"]';
                        $fout.=$playb[$i]['content'];
                        $fout.= '[/pb_layb_one_half]';
                    }
                    if ($layoutbodyrel == '1/3') {
                        $layout_buffer+=0.34;
                        $fout.= '<div class="' . $this->mainoptions['layout_name_dzspb_one_third'] . '">';
                        $closeit = true;
                    }
                    if ($layoutbodyrel == '2/3') {
                        $layout_buffer+=0.67;
                        $fout.= '<div class="' . $this->mainoptions['layout_name_dzspb_two_third'] . '">';
                        $closeit = true;
                    }
                    if ($layoutbodyrel == '1/4') {
                        $layout_buffer+=0.25;
                        $fout.= '<div class="' . $this->mainoptions['layout_name_dzspb_one_fourth'] . '">';
                        $closeit = true;
                    }
                    if ($layoutbodyrel == '3/4') {
                        $layout_buffer+=0.75;
                        $fout.= '<div class="' . $this->mainoptions['layout_name_dzspb_three_fourth'] . '">';
                        $closeit = true;
                    }

                $i++;
            }


            $fout.='</div>';
        }else{
            $fout = $playb[0]['content'];
        }
        
        $fout = stripslashes(do_shortcode($fout));
        
        return $fout;
    }

    function show_gui($pargs = array()) {

        $margs = array(
            'title' => "Page Builder"
        );

        $margs = array_merge($margs, $pargs);


        // --- no reason to return anything if user does not have tinymce
        if (!(current_user_can('edit_posts') || current_user_can('edit_pages'))) {
            return;
        }
        


        $currSlider = 'none';
        if (isset($_REQUEST['currslider'])) {
            $currSlider = $_REQUEST['currslider'];
        } else {
            
        }

//        print_r($this->maintemplates);
        $templatename = '';
        if ($currSlider != 'none') {
            if (isset($this->maintemplates[$currSlider])) {
                $its = $this->maintemplates[$currSlider];
                $templatename = $its['settings']['name'];
            }
        }
        
        
//        print_r($its);
        
        
//        echo 'templatename'.$templatename;



        wp_enqueue_script('dzs.zoomdropdown', $this->thepath . 'zoomdropdown/zoomdropdown.js');
        wp_enqueue_style('dzs.zoomdropdown', $this->thepath . 'zoomdropdown/zoomdropdown.css');
        wp_enqueue_style('fontawesome', $this->thepath . 'tinymce/fontawesome/font-awesome.min.css');

        $layoutbody = $this->insert_layout_body();
        $layoutbody = str_replace(array("\r", "\r\n", "\n"), '', $layoutbody);
        if ($this->pageoptions['page'] != '') {
            //$this->mainpagessliders[$this->pageoptions['page']] = $currSlider;
            //update_option($this->db_pagesliders, $this->mainpagessliders);
        }



        $i = 0;
        $k = 0;
        $id = $this->pageoptions['page'];
        
//        echo 'id '.$id . ' '; print_r($this->mainpagessliders);

        if (is_array($this->mainpagessliders)) {
            foreach ($this->mainpagessliders as $lab => $mainpagesslider) {
                if ((isset($id)) && ($id == $mainpagesslider['settings']['name'])) {
                    $k = $lab;
                }
            }
        } else {
            $this->mainpagessliders = array();
        }
        
//        print_r($this->mainpagessliders);

        
//        echo 'def currSlider '.$currSlider;
//        print_r($its);
        
        if($currSlider=='none' || $currSlider==''){
           if (isset($this->mainpagessliders[$k])) {
                $its = $this->mainpagessliders[$k];
            } else {
                $its = array();
            }
 
        }
        
        //print_r($its);



        if (isset($_GET['addslider']) && $_GET['addslider'] == 'on') {
            //echo 'ceva'; echo $this->maintemplates[$currSlider]=='';

            $this->maintemplates[$currSlider] = $its;
            $this->maintemplates[$currSlider]['settings']['name'] = ('template' . rand(1, 900));
        }


        $aux = remove_query_arg('addslider', dzs_curr_url());
        $aux = remove_query_arg('deleteslider', $aux);
        $params = array('currslider' => '_currslider_');
        $newurl = add_query_arg($params, $aux);
        $params = array('deleteslider' => $currSlider); //'_currslider_'
        $delurl = add_query_arg($params, $aux);
        $san_struct_layoutbody = $this->insert_layout_body();
        $san_struct_layoutbody = str_replace(array("\r", "\r\n", "\n", "'"), '', $san_struct_layoutbody);


        $currurl_noslider = remove_query_arg('currslider', dzs_curr_url());
        
        $struct_chooserlayout = '<div class="zoomdropdown-con chooser-layout" style="display:inline-block; position:absolute; top:3px; width: 150px; margin-left: -75px; text-align: center; left:50%; background:rgba(255,255,255,0.9); border: 1px solid rgba(100,100,100,0.3); padding: 7px 5px;"><div class="aux-padder"></div>
<div class="the-label" style="color: #aaa; font-size:11px; position:relative; top: -3px;">1/1</div>
<ul class="zoomdropdown" style="z-index:999; width: 300px; box-shadow: 0 0 5px 0 rgba(101,100,100,0.2)">
    <li class="dd-selectitem-layout" style="width:100px; text-align: center; display:inline-block; ">1/1</li><li class="dd-selectitem-layout" style="width:100px; text-align: center; display:inline-block; ">1/2+1/2</li><li class="dd-selectitem-layout" style="width:100px; text-align: center; display:inline-block; ">1/3+2/3</li><li class="dd-selectitem-layout" style="width:100px; text-align: center; display:inline-block; ">2/3+1/3</li><li class="dd-selectitem-layout" style="width:100px; text-align: center; display:inline-block; ">1/4+3/4</li><li class="dd-selectitem-layout" style="width:100px; text-align: center; display:inline-block; ">3/4+1/4</li><li class="dd-selectitem-layout" style="width:100px; text-align: center; display:inline-block; ">1/3+1/3+1/3</li><li class="dd-selectitem-layout" style="width:100px; text-align: center; display:inline-block; ">1/2+1/4+1/4</li><li class="dd-selectitem-layout" style="width:100px; text-align: center; display:inline-block; ">1/4+1/2+1/4</li><li class="dd-selectitem-layout" style="width:100px; text-align: center; display:inline-block; ">1/4+1/4+1/2</li><li class="dd-selectitem-layout" style="width:100px; text-align: center; display:inline-block;  ">1/4 * 4</li><li class="dd-selectitem-layout" style="width:100px; text-align: center; display:inline-block;  ">raw</li>
</ul>
</div>';
        ?>
            <div class="pagebuilder-wrap mode-<?php echo $this->mainoptions['mode']; ?>">
                <div class="clear"></div>
                <p>&nbsp;</p>
                <h2 class="title-builder"><?php echo __($margs['title'], 'dzspb'); ?></h2>
                <div class="wrap-thebuilder">
                    <div class="wrap-widgets">
                        <h4 class='header-tools'><?php echo __('Layouts', 'dzspb'); ?></h4>
                        <div class="dzs-layout static clearfix" rel="1/1">
                            <div class="dzs-layout-head"><div></div><div></div><div></div><div></div><div class="item-close"></div><?php echo $struct_chooserlayout; ?></div>
        <?php echo $layoutbody; ?>
                            <input class="field-rel" type="hidden" value="1/1"/>
                        </div>

                        <div class="dzs-layout static clearfix" rel="1/2+1/2"><div class="dzs-layout-head"><div></div><div></div><div></div><div></div><div class="item-close"></div><?php echo $struct_chooserlayout; ?></div>
                            <?php echo $layoutbody; ?>
                            <input class="field-rel" type="hidden" value="1/2+1/2"/>
                        </div>
                        <div class="dzs-layout static clearfix" rel="2/3+1/3"><div class="dzs-layout-head"><div></div><div></div><div></div><div></div><div class="item-close"></div><?php echo $struct_chooserlayout; ?></div>
                            <?php echo $layoutbody; ?>
                            <input class="field-rel" type="hidden" value="2/3+1/3"/>
                        </div>
                        <div class="dzs-layout static clearfix" rel="1/3+2/3"><div class="dzs-layout-head"><div></div><div></div><div></div><div></div><div class="item-close"></div><?php echo $struct_chooserlayout; ?></div>
                            <?php echo $layoutbody; ?>
                            <input class="field-rel" type="hidden" value="1/3+2/3"/>
                        </div>
                        <div class="dzs-layout static clearfix" rel="1/3+1/3+1/3"><div class="dzs-layout-head"><div></div><div></div><div></div><div></div><div class="item-close"></div><?php echo $struct_chooserlayout; ?></div>
        <?php echo $layoutbody; ?>
                            <input class="field-rel" type="hidden" value="1/3+1/3+1/3"/>
                        </div>
                        <div class="dzs-layout static clearfix" rel="1/2+1/4+1/4"><div class="dzs-layout-head"><div></div><div></div><div></div><div></div><div class="item-close"></div><?php echo $struct_chooserlayout; ?></div>
                            <?php echo $layoutbody; ?>
                            <input class="field-rel" type="hidden" value="1/2+1/4+1/4"/>
                        </div>
                        <div class="dzs-layout static clearfix" rel="1/4+1/2+1/4"><div class="dzs-layout-head"><div></div><div></div><div></div><div></div><div class="item-close"></div><?php echo $struct_chooserlayout; ?></div>
                        <?php echo $layoutbody; ?>
                            <input class="field-rel" type="hidden" value="1/4+1/2+1/4"/>
                        </div>
                        <div class="dzs-layout static clearfix" rel="1/4+1/4+1/2"><div class="dzs-layout-head"><div></div><div></div><div></div><div></div><div class="item-close"></div><?php echo $struct_chooserlayout; ?></div>
                        <?php echo $layoutbody; ?>
                            <input class="field-rel" type="hidden" value="1/4+1/4+1/2"/>
                        </div>
                        <div class="dzs-layout static clearfix" rel="1/4+1/4+1/4+1/4"><div class="dzs-layout-head"><div></div><div></div><div></div><div></div><div class="item-close"></div><?php echo $struct_chooserlayout; ?></div>
                        <?php echo $layoutbody; ?>
                            <input class="field-rel" type="hidden" value="1/4+1/4+1/4+1/4"/>
                        </div>
                        <div class="dzs-layout static clearfix" rel="raw"><div class="dzs-layout-head"><div></div><div></div><div></div><div></div><div class="item-close"></div><?php echo $struct_chooserlayout; ?></div>
                        <?php echo $layoutbody; ?>
                            <input class="field-rel" type="hidden" value="raw"/>
                        </div>
                    </div>
                    <div class="wrap-build">
                        <h4 class='header-tools'><?php echo __('Layout ', 'dzspb');
                echo '<span class="px15">';
                echo $this->pageoptions['page'];
                echo '</span>';
                if ($templatename != '') {
                            ?>
                                <span class="sidenote"><?php echo __('from template ', 'dzspb'); ?><strong><?php echo $templatename; ?></strong></span>
                                <p><a class="button-secondary" href="<?php echo $currurl_noslider; ?>"><?php echo __('Discard Template', 'dzspb'); ?></a></p>
                        <?php } ?>
                        </h4>
                        <?php
                        /// === template zone
                        //print_r($currSlider); print_r($this->maintemplates); print_r($this->maintemplates[$currSlider]); 
                        echo '<input type="hidden" name="settings[name]" value="' . $this->pageoptions['page'] . '"/>';
                        //echo 'cevaalceva';
                        if (is_array($its)) {
                            foreach ($its as $lab => $val) {
                                //print_r($lab); print_r($val);
                                if ($lab == 'settings') {
                                    continue;
                                }
                                foreach ($val as $layout) {
                                    //print_r($layout);
                                    echo '<div class="dzs-layout clearfix" rel="' . $layout['settings']['rel'] . '">
                        <div class="dzs-layout-head"><div></div><div></div><div></div><div></div>
                        <div class="item-close"></div>' . $struct_chooserlayout . '</div>';

                                    //print_r($layout);;
                                    foreach ($layout as $layout_lab => $layout_val) {
                                        if ($layout_lab === 'settings') {
                                            continue;
                                        }
                                        //echo 'ceva';print_r($layout_val);
                                        $args = array(
                                            'title' => $layout_val['title'],
                                            'content' => '',
                                        );
                                        if (isset($layout_val['content'])) {
                                            $args['content'] = $layout_val['content'];
                                        }

                                        //echo $layout_lab; echo 'ceva'; print_r($layout_val);
                                        echo $this->insert_layout_body($args);
                                    }

                                    echo '<input class="field-rel" type="hidden" value="' . $layout['settings']['rel'] . '"/>';
                                    echo '</div>';
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="saveconfirmer" style=""><img alt="" style="" id="save-ajax-loading2" src="<?php echo site_url(); ?>/wp-admin/images/wpspin_light.gif"/></div>

            <div class="templates-wrap">
                <?php
                //print_r($this->maintemplates);
                //echo count($this->maintemplates);

                if (is_array($this->maintemplates) && count($this->maintemplates) > 0) {
                    echo '<div class="templates-title">Templates <span class="sidenote">hold click for one second to change template name</span></div>';
                    echo '<div class="wrap-templates">';
                    $is = 0;
                    //print_r($this->maintemplates);
                    foreach ($this->maintemplates as $maintemplate) {
                        //echo $currSlider . ' cevava ' . $is;
                        if (!isset($maintemplate['settings'])) {
                            continue;
                        }
                        $aux = $newurl;
                        $aux = str_replace('_currslider_', $is, $aux);
                        echo '<a href="' . $aux . '" class="template-item';

                        echo '">';

                        echo '<input type="text" class="template-item-input" value="' . $maintemplate['settings']['name'] . '"/>';

                        echo '</a>'; //'<a class="template-item">';
                        $is++;
                    }
                    $aux = $newurl;
                    $params = array('addslider' => 'on');
                    $aux = add_query_arg($params, $aux);
                    $aux = str_replace('_currslider_', $is, $aux);
                    echo '</div>'; //<div class="wrap-templates">
                    if ($templatename != '') {

                        echo '<a href="'.$aux.'" class="savetemplate ui-layout-button';
                        echo '">';
                        echo 'save ' . $templatename;
                        echo '</a>'; //'<a class="template-item addlayout">';
                    }
                }
                    echo '<a href="' . $aux . '" class="savetemplate ui-layout-button';
                    echo '">';
                    echo __('make template from this layout', $this->translatevar);
                    echo '</a>'; //'<a class="template-item addlayout">';
                ?>
            </div>
        <?php
    }

    function show_shortcode_as($atts, $content = '') {
        $fout = '';

        $fout.='<div id="" class="advancedscroller skin-inset as' . $this->sliders_index_as . '" style="width:100%;"><ul class="items">';
        //$content = str_replace(array('\n', '\r'), '', $content);
        //echo 'alceva'; print_r($content); echo 'ceva';

        $fout.=stripslashes(do_shortcode($content));
        $fout.='</ul></div>';



        $fout.='<script>';
        $fout.='jQuery(document).ready(function($){';
        $fout.='dzsas_init(".as' . $this->sliders_index_as . '",{
settings_mode: "onlyoneitem"
,design_arrowsize: "0"
,settings_swipe: "on"
,settings_swipeOnDesktopsToo: "on"
,settings_slideshow: "on"
,settings_slideshowTime: "3"
});';
        $fout.='});';
        $fout.='</script>';


        $this->sliders_index_as++;
        return $fout;
    }

    function shortcode_ul($atts, $content = '') {
        $fout = '';
        $margs = array(
            'class' => '',
        );
        $margs = array_merge($margs, $atts);

        $fout.='<ul class="' . $margs['class'] . '">' . stripslashes(do_shortcode($content)) . '</ul>';
        return $fout;
    }

    function shortcode_li($atts, $content = '') {
        $fout = '';
        $margs = array(
            'class' => '',
        );
        //print_r($atts);
        $margs = array_merge($margs, $atts);

        $fout.='<li class="' . $margs['class'] . '">' . stripslashes(do_shortcode($content)) . '</li>';
        return $fout;
    }

}
