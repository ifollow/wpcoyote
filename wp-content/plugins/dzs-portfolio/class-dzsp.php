<?php
class DZSPortfolio {

    public $mainoptions = '';
    public $index = 0;
    public $thepath;
    public $shortcode = 'portfolio';
    public $pluginmode = "plugin";
    public $alwaysembed = 'off';
    public $notices = array();
    public $translateconst = 'dzsp';
    public $dboptionsname = 'dzsp_options';
    public $sliders_index = 0;
    public $sliders_index_as = 0;
    public $fullscreen_cache_args = '';
    public $pb;

        function __construct() {
            if ($this->pluginmode == 'theme') {
                $this->thepath = THEME_URL . 'plugins/dzs-portfolio/';
            } else {
                $this->thepath = plugins_url('', __FILE__) . '/';
            }

        $this->mainoptions = get_option($this->dboptionsname);

        //print_r($this->mainoptions);
        //
        if ($this->mainoptions == '') {
            $this->mainoptions = array();
        }

        $defoptions = array(
            'enable_meta_for_pages_too' => 'off',
            'keyword_all' => 'All',
            'embed_always' => 'on',
            'thumbs_full_quality' => 'medium',
            'disable_pagebuilder' => 'off',
            'twitter_token' => '',
            'twitter_token_secret' => '',
            'twitter_consumer_key' => '',
            'twitter_consumer_secret' => '',
            'misc_force_featured_media_over_featured_image' => 'off',
            'zoombox_settings_disablezoom' => 'peritem',
            'zoombox_settings_zoom_donotgobeyond1x' => 'off',
        );
        $this->mainoptions = array_merge($defoptions, $this->mainoptions);

        load_plugin_textdomain('dzsp', false, basename(dirname(__FILE__)) . '/languages');

        $this->permalink_settings_save();
        add_theme_support('post-thumbnails');
        
        
        


        //$this->pb = PageBuilder::getInstance();

        add_action('init', array($this, 'handle_init'));
        //add_action('wp_print_styles', array($this, 'front_embed'));
        //add_action('admin_init', array($this, 'admin_init'));
        //add_action('admin_menu', array($this, 'admin_menu'));
        //add_action('admin_head', array($this, 'admin_menu_save'));
        //add_action('admin_head', array($this,'handle_admin_head'));
        add_shortcode($this->shortcode, array($this, 'show_shortcode'));
        add_shortcode('dzs_' . $this->shortcode, array($this, 'show_shortcode'));
        add_shortcode("zoomfolio", array($this, 'show_shortcode'));
        //add_shortcode($this->shortcode, array($this, 'show_shortcode_alt'));
        //add_shortcode('dzs_' . $this->shortcode, array($this, 'show_shortcode_alt'));
        add_action('admin_init', array($this, 'handle_admin_init'));
        add_action('add_meta_boxes', array($this, 'handle_add_meta_boxes'));
        add_action('admin_head', array($this, 'handle_admin_head'));
        add_action('admin_menu', array($this, 'handle_admin_menu'));
        add_action('admin_notices', array($this, 'handle_admin_notices'));

        add_action('save_post', array($this, 'admin_meta_save'));


        add_action('wp_head', array($this, 'handle_wp_head'));
        add_action('wp_footer', array($this, 'handle_footer'));


        add_action('wp_ajax_dzsp_ajax_mo', array($this, 'post_save_mo'));
        add_action('wp_ajax_dzsp_install_demo_data', array($this, 'ajax_install_demo_data'));
        add_action('wp_ajax_dzsp_delete_demo_data', array($this, 'ajax_delete_demo_data'));
        add_action('wp_ajax_dzsp_get_categories', array($this, 'ajax_get_categories'));
        add_action('wp_ajax_dzsp_preparePreview', array($this, 'ajax_preparePreview'));

        //=== setting up a thumbnail for our mp4 media
        add_filter("attachment_fields_to_edit", array($this, "filter_attachment_fields_to_edit"), null, 2);
        add_filter('attachment_fields_to_save', array($this, "filter_attachment_fields_to_save"), null, 2);
    }
    
    function ajax_preparePreview(){
        
//        echo $_POST['postdata'];
        echo do_shortcode(stripslashes($_POST['postdata']));
        die();
    }

    
    function ajax_install_demo_data(){
        
        $taxonomy = 'categoryportfolio';
        
        $arr_cats = array();
        
        $args = array('cat_name' => 'Fashion Items', 'category_description' => 'A sample collection', 'category_nicename' => 'fashion-items', 'taxonomy' => $taxonomy);
        $sample_cat_id = wp_insert_category($args);
        array_push($arr_cats, $sample_cat_id);
        
        $args = array('cat_name' => 'Movie Posters', 'category_description' => 'A sample collection', 'category_nicename' => 'movie-posters', 'taxonomy' => $taxonomy);
        $sample_cat_id = wp_insert_category($args);
        array_push($arr_cats, $sample_cat_id);
        
        $args = array('cat_name' => 'Skin Aura Category', 'category_description' => 'A sample collection', 'category_nicename' => 'skin-aura-category', 'taxonomy' => $taxonomy);
        $sample_cat_id = wp_insert_category($args);
        array_push($arr_cats, $sample_cat_id);
        
        
        $args = array('cat_name' => 'Example Testimonials Category', 'category_description' => 'A sample collection', 'category_nicename' => 'skin-aura-category', 'taxonomy' => $taxonomy);
        $sample_cat_id = wp_insert_category($args);
        array_push($arr_cats, $sample_cat_id);
        
        $args = array(
          'post_title'    => 'Sample Fashion 1',
          'post_content'  => 'Sample post.',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'   => 'dzs_portfolio',
        );

        $sample_post_1_id = wp_insert_post( $args );
        wp_set_post_terms( $sample_post_1_id, $arr_cats[0], $taxonomy );
        update_post_meta($sample_post_1_id, 'dzsp_featured_media', 'https://lh4.googleusercontent.com/-rQckYqrFP7s/ToXo4b0QAgI/AAAAAAAAAMM/hcH5EX6yKg8/w670-h360-no/slide22.jpg');
        
        
        $args = array(
          'post_title'    => 'Sample Fashion 2',
          'post_content'  => 'Sample post.',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'   => 'dzs_portfolio',
        );

        $sample_post_2_id = wp_insert_post( $args );
        wp_set_post_terms( $sample_post_2_id, $arr_cats[0], $taxonomy );
        update_post_meta($sample_post_2_id, 'dzsp_featured_media', 'https://lh5.googleusercontent.com/-RxO_2B3oxnQ/TocsbFXVaiI/AAAAAAAAAO4/BfPim5pzBC0/w440-h360-no/slide11.jpg');
        
        
        
        $args = array(
          'post_title'    => 'Sample Fashion 3',
          'post_content'  => 'Sample post.',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'   => 'dzs_portfolio',
        );

        $sample_post_3_id = wp_insert_post( $args );
        wp_set_post_terms( $sample_post_3_id, $arr_cats[0], $taxonomy );
        update_post_meta($sample_post_3_id, 'dzsp_featured_media', 'https://lh6.googleusercontent.com/-Tbavi5yzfZ0/TocsbHEUfTI/AAAAAAAAAO0/BTM0LroI0F8/w440-h360-no/slide12.jpg');
        
        
        
        
        $args = array(
          'post_title'    => 'Sample Cover 1',
          'post_content'  => 'Sample post.',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'   => 'dzs_portfolio',
        );

        $sample_post_4_id = wp_insert_post( $args );
        wp_set_post_terms( $sample_post_4_id, $arr_cats[1], $taxonomy );
        update_post_meta($sample_post_4_id, 'dzsp_featured_media', 'https://lh4.googleusercontent.com/-xEAujIuu02E/TrydTNactgI/AAAAAAAAAqg/aY5OWH6lvdg/w967-h679-no/1.jpg');
        
        
        $args = array(
          'post_title'    => 'Sample Cover 2',
          'post_content'  => 'Sample post.',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'   => 'dzs_portfolio',
        );

        $sample_post_5_id = wp_insert_post( $args );
        wp_set_post_terms( $sample_post_5_id, $arr_cats[1], $taxonomy );
        update_post_meta($sample_post_5_id, 'dzsp_featured_media', 'https://lh5.googleusercontent.com/-KHaErnnalf4/TryQZ18HuTI/AAAAAAAAApw/yR10HMwIXZU/w967-h803-no/4.jpg');
        
        
        
        $arr_posts = array($sample_post_1_id,$sample_post_2_id,$sample_post_3_id,$sample_post_4_id,$sample_post_5_id);
        
        
        
        $args = array(
          'post_title'    => 'Aura 1',
          'post_content'  => 'Sample post.',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'   => 'dzs_portfolio',
        );

        $sample_post_id = wp_insert_post( $args );
        wp_set_post_terms( $sample_post_id, $arr_cats[2], $taxonomy );
        update_post_meta($sample_post_id, 'dzsp_featured_media', 'https://lh4.googleusercontent.com/-tdCLfzUhf8Y/UuE3Kf_9TvI/AAAAAAAAALw/glibagYuM5s/s600/unsplash_52be0803ecaec_1.jpg');
        update_post_meta($sample_post_id, 'dzsp_force_width', '49%');
        array_push($arr_posts, $sample_post_id);
        
        
        $args = array(
          'post_title'    => 'Aura 2',
          'post_content'  => 'Sample post.',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'   => 'dzs_portfolio',
        );

        $sample_post_id = wp_insert_post( $args );
        wp_set_post_terms( $sample_post_id, $arr_cats[2], $taxonomy );
        update_post_meta($sample_post_id, 'dzsp_featured_media', 'https://lh3.googleusercontent.com/-cYT9New5kG8/UuE3I-Z2vdI/AAAAAAAAALM/I_ySDWsmqqA/s400/unsplash_52c36ed5df776_1.jpg');
        array_push($arr_posts, $sample_post_id);
        
        
        $args = array(
          'post_title'    => 'Aura 3',
          'post_content'  => 'Sample post.',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'   => 'dzs_portfolio',
        );

        $sample_post_id = wp_insert_post( $args );
        wp_set_post_terms( $sample_post_id, $arr_cats[2], $taxonomy );
        update_post_meta($sample_post_id, 'dzsp_featured_media', 'https://lh4.googleusercontent.com/-hIf5Ketpzs8/UuE3JQ_1-PI/AAAAAAAAALU/QUk8LTmJWYQ/s400/unsplash_52c36ef60f8df_1.jpg');
        array_push($arr_posts, $sample_post_id);
        
        
        
        
        $args = array(
          'post_title'    => 'Aura 4',
          'post_content'  => 'Sample post.',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'   => 'dzs_portfolio',
        );

        $sample_post_id = wp_insert_post( $args );
        wp_set_post_terms( $sample_post_id, $arr_cats[2], $taxonomy );
        update_post_meta($sample_post_id, 'dzsp_featured_media', 'https://lh5.googleusercontent.com/-ywZb8WeApus/UuE3J-kAURI/AAAAAAAAALc/v7y7UhBbYtM/s400/unsplash_52c36f5d2cdb2_1.jpg');
        array_push($arr_posts, $sample_post_id);
        
        
        
        
        $args = array(
          'post_title'    => 'Aura 5',
          'post_content'  => 'Sample post.',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'   => 'dzs_portfolio',
        );

        $sample_post_id = wp_insert_post( $args );
        wp_set_post_terms( $sample_post_id, $arr_cats[2], $taxonomy );
        update_post_meta($sample_post_id, 'dzsp_featured_media', 'https://lh4.googleusercontent.com/-R9frSJuZss8/UuE3KRJVghI/AAAAAAAAALk/57xbPdFrW0Y/s400/unsplash_52c470899a2e1_1.jpg');
        array_push($arr_posts, $sample_post_id);
        
        
        
        
        $args = array(
          'post_title'    => 'Aura 6',
          'post_content'  => 'Sample post.',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'   => 'dzs_portfolio',
        );

        $sample_post_id = wp_insert_post( $args );
        wp_set_post_terms( $sample_post_id, $arr_cats[2], $taxonomy );
        update_post_meta($sample_post_id, 'dzsp_featured_media', 'https://lh4.googleusercontent.com/-x4aJ7ZlGUH8/UuE3MthEwdI/AAAAAAAAAMQ/lzNczMMZCFM/s600/unsplash_52cf9489095e8_1.jpg');
        update_post_meta($sample_post_id, 'dzsp_force_width', '49%');
        array_push($arr_posts, $sample_post_id);
        
        
        
        
        $args = array(
          'post_title'    => 'Aura 7',
          'post_content'  => 'Sample post.',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'   => 'dzs_portfolio',
        );

        $sample_post_id = wp_insert_post( $args );
        wp_set_post_terms( $sample_post_id, $arr_cats[2], $taxonomy );
        update_post_meta($sample_post_id, 'dzsp_featured_media', 'https://lh3.googleusercontent.com/-8UkSrCSFXcI/UuE3LRWsHyI/AAAAAAAAAL8/NCQwaNprohg/s800/unsplash_52c56ffd153dd_1.jpg');
        array_push($arr_posts, $sample_post_id);
        
        
        
        
        $args = array(
          'post_title'    => 'Aura 8',
          'post_content'  => 'Sample post.',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'   => 'dzs_portfolio',
        );

        $sample_post_id = wp_insert_post( $args );
        wp_set_post_terms( $sample_post_id, $arr_cats[2], $taxonomy );
        update_post_meta($sample_post_id, 'dzsp_featured_media', 'https://lh4.googleusercontent.com/-MsVu5UEOOFU/UuE3Ld9ZK1I/AAAAAAAAAL4/6pBl53XaWbk/s400/unsplash_52c8b9c40b624_1.jpg');
        array_push($arr_posts, $sample_post_id);
        
        
        
        
        $args = array(
          'post_title'    => 'Aura 9',
          'post_content'  => 'Sample post.',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'   => 'dzs_portfolio',
        );

        $sample_post_id = wp_insert_post( $args );
        wp_set_post_terms( $sample_post_id, $arr_cats[2], $taxonomy );
        update_post_meta($sample_post_id, 'dzsp_featured_media', 'https://lh5.googleusercontent.com/-EbZx_qJpvBc/UuE3LkSdFrI/AAAAAAAAAME/Zyc0V5SvUxw/s400/unsplash_52cd96f512830_1.jpg');
        array_push($arr_posts, $sample_post_id);
        
        
        
        
        $args = array(
          'post_title'    => 'Aura 10',
          'post_content'  => 'Sample post.',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'   => 'dzs_portfolio',
        );

        $sample_post_id = wp_insert_post( $args );
        wp_set_post_terms( $sample_post_id, $arr_cats[2], $taxonomy );
        update_post_meta($sample_post_id, 'dzsp_featured_media', 'https://lh5.googleusercontent.com/--ez4YiWrDtc/UuE3MVEGRgI/AAAAAAAAAMM/7LScODT_Yzo/s800/unsplash_52d09387ae003_1.jpg');
        array_push($arr_posts, $sample_post_id);
        
        
        
        $args = array(
          'post_title'    => 'Testimonial 1',
          'post_content'  => 'Sample post.',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'   => 'dzs_portfolio',
        );

        $sample_post_id = wp_insert_post( $args );
        wp_set_post_terms( $sample_post_id, $arr_cats[3], $taxonomy );
        update_post_meta($sample_post_id, 'dzsp_featured_media', 'https://lh3.googleusercontent.com/-WkLbzscUCrg/U0HS0nlLXdI/AAAAAAAAAR4/Ep4Ds2lTcJM/s200/av1.png');
        update_post_meta($sample_post_id, 'dzsp_subtitle', 'Sample text.');
        array_push($arr_posts, $sample_post_id);
        
        
        
        $args = array(
          'post_title'    => 'Testimonial 2',
          'post_content'  => 'Sample post.',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'   => 'dzs_portfolio',
        );

        $sample_post_id = wp_insert_post( $args );
        wp_set_post_terms( $sample_post_id, $arr_cats[3], $taxonomy );
        update_post_meta($sample_post_id, 'dzsp_featured_media', 'https://lh5.googleusercontent.com/-UiXeltyuvk8/U0HS0oZFWkI/AAAAAAAAAR0/JLpHBuJxl_A/s200/av2.png');
        update_post_meta($sample_post_id, 'dzsp_subtitle', 'Sample text.');
        array_push($arr_posts, $sample_post_id);
        
        
        
        $args = array(
          'post_title'    => 'Testimonial 3',
          'post_content'  => 'Sample post.',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'   => 'dzs_portfolio',
        );

        $sample_post_id = wp_insert_post( $args );
        wp_set_post_terms( $sample_post_id, $arr_cats[3], $taxonomy );
        update_post_meta($sample_post_id, 'dzsp_featured_media', 'https://lh4.googleusercontent.com/-Uz_qO2nAMDY/U0HS0v484WI/AAAAAAAAAR8/L8Vy9w4cMGE/s200/av3.png');
        update_post_meta($sample_post_id, 'dzsp_subtitle', 'Sample text.');
        array_push($arr_posts, $sample_post_id);
        
        
        
        $args = array(
          'post_title'    => 'Testimonial 4',
          'post_content'  => 'Sample post.',
          'post_status'   => 'publish',
          'post_author'   => 1,
          'post_type'   => 'dzs_portfolio',
        );

        $sample_post_id = wp_insert_post( $args );
        wp_set_post_terms( $sample_post_id, $arr_cats[3], $taxonomy );
        update_post_meta($sample_post_id, 'dzsp_featured_media', 'https://lh3.googleusercontent.com/-7p9bYJECmxM/U0HS1Uo8zrI/AAAAAAAAASU/0WC8Emf-JsA/s200/av4.png');
        update_post_meta($sample_post_id, 'dzsp_subtitle', 'Sample text.');
        array_push($arr_posts, $sample_post_id);
        
        
//        print_r($arr_cats);
        
        echo $arr_cats[0].','.$arr_cats[1],','.$arr_cats[2];
        
        $demo_data = array('cats'=>$arr_cats, 'posts'=>$arr_posts);
        
        if(get_option('dzsp_demo_data')==''){
            update_option('dzsp_demo_data', $demo_data);
        }
        
        die();
    }
    function ajax_get_categories(){
        $terms=get_categories('orderby=count&hide_empty=0' );
        
        $i=0;
        foreach($terms as $cat){
            if($i>0){
                echo ',';
            }
            
            echo ($cat->term_id);
            
            ++$i;
        }
        
        
        echo ';';
        
        $i=0;
        foreach($terms as $cat){
            if($i>0){
                echo ',';
            }
            
            echo ($cat->name);
            
            ++$i;
        }
        
        die();
    }
    function ajax_delete_demo_data(){
        
        $demo_data = get_option('dzsp_demo_data');
        
//        print_r($demo_data);
        
        
        foreach($demo_data['posts'] as $pid){
            wp_delete_post($pid);
        };
        
        foreach($demo_data['cats'] as $categ_ID){
            wp_delete_term($categ_ID, 'categoryportfolio');
        };
        
        delete_option('dzsp_demo_data');
        
        
        die();
    }
    
    function filter_attachment_fields_to_edit($form_fields, $post) {
        
        
        $the_id = $post->ID;
        $post_type = get_post_mime_type($the_id);
        
        
        if(strpos($post_type, "video")===false){
            return $form_fields;
        }
        
        
        $form_fields["attachment_video_thumb"] = array(
            "label" => __("Video Thumbnail"),
            "input" => "text",
            "value" => get_post_meta($post->ID, "_attachment_video_thumb", true)
        );

        return $form_fields;
    }

    function filter_attachment_fields_to_save($post, $attachment) {
        if (isset($attachment['attachment_video_thumb'])) {
            update_post_meta($post['ID'], '_attachment_video_thumb', $attachment['attachment_video_thumb']);
        }
        return $post;
    }


    function handle_init() {

        //print_r($this->mainoptions);
        if ($this->mainoptions === false) {
            $this->mainoptions = array(
                'keyword_all' => 'All',
            );
            //update_option('dzsp_options', $this->mainoptions);
            $this->mainoptions = get_option('dzsp_options');
        };



        register_taxonomy(
            'categoryportfolio', 'dzs_portfolio', array(
            'label' => __('Portfolio Categories', 'dzsp'),
            'query_var' => true,
            'show_ui' => true,
            'hierarchical' => true,
                )
        );


        $labels = array(
            'name' => 'Portfolio Items',
            'singular_name' => 'Portfolio Item',
        );

        $permalinks = get_option('dzsp_permalinks');
        //print_r($permalinks);

        $item_slug_permalink = empty($permalinks['item_base']) ? _x('portfolio', 'slug', 'woocommerce') : $permalinks['item_base'];


        $args = array(
            'labels' => $labels,
            'public' => true,
            'has_archive' => true,
            'hierarchical' => false,
            'supports' => array('title', 'editor', 'author', 'thumbnail', 'post-thumbnail', 'comments', 'excerpt', 'revisions'),
            'rewrite' => array('slug' => $item_slug_permalink),
            'yarpp_support' => true,
                //'taxonomies' => array('categoryportfolio'),
        );
        register_post_type('dzs_portfolio', $args);
        //print_r(get_plugins());
        //====making the plugin qtranslate ready
        if (function_exists('qtrans_modifyTermFormFor')) {
            add_action('categoryportfolio_add_form', 'qtrans_modifyTermFormFor');
            add_action('categoryportfolio_edit_form', 'qtrans_modifyTermFormFor');
        }
        wp_enqueue_script('jquery');
        if (is_admin()) {
            if (current_user_can('edit_posts') || current_user_can('edit_pages')) {

                wp_enqueue_script('jquery-ui-core');
                wp_enqueue_script('jquery-ui-sortable');
                wp_enqueue_script('jquery-ui-droppable');
                wp_enqueue_script('dzs.zoombox', $this->thepath . 'zoombox/zoombox.js');
                wp_enqueue_style('dzs.zoombox', $this->thepath . 'zoombox/zoombox.css');
                wp_enqueue_script('dzs.uploader', $this->thepath . 'dzsuploader/upload.js');
                wp_enqueue_style('dzs.uploader', $this->thepath . 'dzsuploader/upload.css');
                wp_enqueue_script('dzsp.admin', $this->thepath . 'admin/admin.js');
                wp_enqueue_style('dzsp.admin', $this->thepath . 'admin/admin.css');
                wp_enqueue_script('htmleditor_plugin', $this->thepath . 'tinymce/plugin-htmleditor.js');
                wp_enqueue_script('dzs.farbtastic', $this->thepath . "colorpicker/farbtastic.js");
                wp_enqueue_style('dzs.farbtastic', $this->thepath . 'colorpicker/farbtastic.css');
                //add_filter("mce_external_plugins" , array($this, 'tinymce_plugin'));
                //add_filter("mce_buttons" , array($this, 'tinymce_register_button'));


                if (isset($_GET['page']) && $_GET['page'] == 'dzsp-mo') {
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

    function handle_admin_init() {

        // Add a section to the permalinks page
        add_settings_section('dzsp-permalink', __('Portfolio Items Permalink Base', 'dzsp'), array($this, 'permalink_settings'), 'permalink');
    }

    function handle_add_meta_boxes() {



        add_meta_box('dzsp_meta_options', __('DZS ZoomFolio Settings'), array($this, 'admin_meta_options'), 'dzs_portfolio', 'normal', 'high');
        add_meta_box('dzsp_meta_options', __('DZS ZoomFolio Settings'), array($this, 'admin_meta_options'), 'post', 'normal', 'high');
        add_meta_box('dzsp_meta_gallery', __('Item Gallery', 'dzsp'), array($this, 'admin_meta_gallery'), 'dzs_portfolio', 'side');
        add_meta_box('dzsp_meta_gallery', __('Item Gallery', 'dzsp'), array($this, 'admin_meta_gallery'), 'post', 'side');






        //add_meta_box( 'attachment_video_thumb', __( 'Thumbnail', 'dzsp' ), array($this,'admin_meta_attachment_video_thumb'), 'attachment', 'normal' );

        if ($this->mainoptions['enable_meta_for_pages_too'] == 'on') {
            add_meta_box('dzsp_meta_options', __('DZS ZoomFolio Settings'), array($this, 'admin_meta_options'), 'page', 'normal', 'high');
            add_meta_box('dzsp_meta_gallery', __('Item Gallery', 'dzsp'), array($this, 'admin_meta_gallery'), 'page', 'side');
        }
    }

    function admin_meta_attachment_video_thumb() {
        global $post;
    }


    function handle_admin_menu() {

        add_options_page(__('Portfolio Settings', 'dzsp'), __('DZS Portfolio Settings', 'dzsp'), 'manage_options', 'dzsp-mo', array($this, 'admin_page_mainoptions'));
        
    }

    function misc_input_checkbox($argname, $argopts) {
        $fout = '';
        $auxtype = 'checkbox';

        if (isset($argopts['type'])) {
            if ($argopts['type'] == 'radio') {
                $auxtype = 'radio';
            }
        }
        $fout.='<input type="' . $auxtype . '"';
        $fout.=' name="' . $argname . '"';
        if (isset($argopts['class'])) {
            $fout.=' class="' . $argopts['class'] . '"';
        }
        $theval = 'on';
        if (isset($argopts['val'])) {
            $fout.=' value="' . $argopts['val'] . '"';
            $theval = $argopts['val'];
        } else {
            $fout.=' value="on"';
        }
        //print_r($this->mainoptions); print_r($argopts['seekval']);
        if (isset($argopts['seekval'])) {
            $auxsw = false;
            if (is_array($argopts['seekval'])) {
                //echo 'ceva'; print_r($argopts['seekval']);
                foreach ($argopts['seekval'] as $opt) {
                    //echo 'ceva'; echo $opt; echo 
                    if ($opt == $argopts['val']) {
                        $auxsw = true;
                    }
                }
            } else {
                if ($argopts['seekval'] == $theval) {
                    //echo $argval;
                    $auxsw = true;
                }
            }
            if ($auxsw == true) {
                $fout.=' checked="checked"';
            }
        }
        $fout.='/>';
        return $fout;
    }

    function admin_page_mainoptions() {
        //print_r($this->mainoptions);
        //echo $this->mainoptions['twitter_token'];
        ?>

        <div class="wrap">
            <h2><?php echo __('Video Gallery Main Settings', 'dzsp'); ?></h2>
            <br/>
            <form class="mainsettings">
                <h3><?php echo __('Admin Options', 'dzsp'); ?></h3>
                <div class="setting">
                    <div class="label"><?php echo __('Replace "All" with ...', 'dzsp'); ?></div>
        <?php echo $this->misc_input_text('keyword_all', array('val' => '', 'seekval' => $this->mainoptions['keyword_all'])); ?>
                    <div class="sidenote"><?php echo __('', 'dzsp'); ?></div>
                </div>
                <div class="dzs-setting"> 
                    <h4><?php echo __('Enable Meta For Pages Too ? ', 'dzsp'); ?></h4>
        <?php
        $lab = 'enable_meta_for_pages_too';
        echo $this->misc_generate_select($lab, $this->mainoptions[$lab], array(
            array(
                'value' => 'off',
                'label' => __('off', 'dzsp'),
            ),
            array(
                'value' => 'on',
                'label' => __('on', 'dzsp'),
            ),
                ), array('class' => 'styleme', 'def_value' => ''));
        ?>
                    <div class="clear"></div>
                    <div class='sidenote'><?php echo __('allows to display Pages too in the Portfolio .. and set option for them', 'dzsp'); ?></div>
                    <div class="clear"></div>
                </div>
                <div class="dzs-setting">
                    <h4><?php echo __('Disable Page Builder? ', 'dzsp'); ?></h4>
        <?php
        $lab = 'disable_pagebuilder';
        echo $this->misc_generate_select($lab, $this->mainoptions[$lab], array(
            array(
                'value' => 'off',
                'label' => __('off', 'dzsp'),
            ),
            array(
                'value' => 'on',
                'label' => __('on', 'dzsp'),
            ),
                ), array('class' => 'styleme', 'def_value' => ''));
        ?>
                    <div class="clear"></div>
                    <div class='sidenote'><?php echo __('disable the included page builder', 'dzsp'); ?></div>
                    <div class="clear"></div>
                </div>
                <div class="dzs-setting"> 
                    <h4><?php echo __('Always Embed Scripts ? ', 'dzsp'); ?></h4>
                    <?php
                    $lab = 'embed_always';
                    echo $this->misc_generate_select($lab, $this->mainoptions[$lab], array(
                        array(
                            'value' => 'on',
                            'label' => __('on', 'dzsp'),
                        ),
                        array(
                            'value' => 'off',
                            'label' => __('off', 'dzsp'),
                        ),
                            ), array('class' => 'styleme', 'def_value' => ''));
                    ?>
                    <div class="clear"></div>
                    <div class='sidenote'><?php echo __('always embed zoomfolio scripts ( on ) / embed them only when needed ( off ) ', 'dzsp'); ?></div>
                    <div class="clear"></div>
                </div>
                <div class="dzs-setting"> 
                    <h4><?php echo __('Always Full Quality for Thumbnails ? ', 'dzsp'); ?></h4>
                    <?php
                    $lab = 'thumbs_full_quality';
                    echo $this->misc_generate_select($lab, $this->mainoptions[$lab], array(
                        array(
                            'value' => 'medium',
                            'label' => __('Medium Quality', 'dzsp'),
                        ),
                        array(
                            'value' => 'full',
                            'label' => __('Full Quality', 'dzsp'),
                        ),
                        array(
                            'value' => 'default',
                            'label' => __('Default Quality', 'dzsp'),
                        ),
                            ), array('class' => 'styleme', 'def_value' => ''));
                    ?>
                    <div class="clear"></div>
                    <div class='sidenote'><?php echo __('always embed zoomfolio scripts ( on ) / embed them only when needed ( off ) ', 'dzsp'); ?></div>
                    <div class="clear"></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Extra CSS', 'dzsp'); ?></div>
                    <?php echo $this->misc_input_textarea('extra_css', array('val' => '', 'seekval' => $this->mainoptions['extra_css'])); ?>
                    <div class="sidenote"><?php echo __('', 'dzsp'); ?></div>
                </div>
                <h4><?php echo __('Twitter Options', 'dzsp'); ?></h4>
                <div class="sidenote"><?php echo __('If you want Twitter items in your portfolio, you have to input here the required oAuth keys for Twitter 1.1 - 
                    you can register for an api key <a href="https://dev.twitter.com/apps/new">here</a>', 'dzsp'); ?></div>
                <div class="setting">
                    <div class="label"><?php echo __('Token', 'dzsp'); ?></div>
        <?php echo $this->misc_input_text('twitter_token', array('val' => '', 'seekval' => $this->mainoptions['twitter_token'])); ?>
                    <div class="sidenote"><?php echo __('', 'dzsp'); ?></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Token Secret', 'dzsp'); ?></div>
        <?php echo $this->misc_input_text('twitter_token_secret', array('val' => '', 'seekval' => $this->mainoptions['twitter_token_secret'])); ?>
                    <div class="sidenote"><?php echo __('', 'dzsp'); ?></div>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Consumer Key', 'dzsp'); ?></div>
        <?php echo $this->misc_input_text('twitter_consumer_key', array('val' => '', 'seekval' => $this->mainoptions['twitter_consumer_key'])); ?>
                </div>
                <div class="setting">
                    <div class="label"><?php echo __('Consumer Secret', 'dzsp'); ?></div>
        <?php echo $this->misc_input_text('twitter_consumer_secret', array('val' => '', 'seekval' => $this->mainoptions['twitter_consumer_secret'])); ?>
                </div>
                <br/>
                <h4>ZoomBox Settings</h4>
                
                
                <div class="setting">
                    <div class="label"><?php echo __('Disable Zoom', 'dzszb'); ?></div>
                    <?php $lab = 'zoombox_settings_disablezoom'; echo DZSHelpers::generate_select($lab, array('options' => array('peritem','off', 'on'), 'class' => 'styleme', 'seekval' => $this->mainoptions[$lab])); ?>
                    <div class="sidenote"><?php echo __('disable the zoom', 'dzszb'); ?></div>
                </div>
                
                <div class="setting">
                    <div class="label"><?php echo __('Do Not Super Zoom ', 'dzsp'); ?></div>
                    <?php
                    $lab = 'zoombox_settings_zoom_donotgobeyond1x';
                    echo $this->misc_generate_select($lab, $this->mainoptions[$lab], array(
                        array(
                            'value' => 'off',
                            'label' => __('off', 'dzsp'),
                        ),
                        array(
                            'value' => 'on',
                            'label' => __('on', 'dzsp'),
                        ),
                    ), array('class' => 'styleme', 'def_value' => ''));
                    ?>
                    
                    
                    <div class="clear"></div>
                    <div class='sidenote'><?php echo __('on images opened in zoombox there is a zoom icon - you can select to not go past the 1:1 pixel ratio when zoomed ', 'dzsp'); ?></div>
                    <div class="clear"></div>
                </div>
                
                <div class="setting">
                    <div class="label"><?php echo __('Prefer Featured Media ', 'dzsp'); ?></div>
                    <?php
                    $lab = 'misc_force_featured_media_over_featured_image';
                    echo $this->misc_generate_select($lab, $this->mainoptions[$lab], array(
                        array(
                            'value' => 'off',
                            'label' => __('off', 'dzsp'),
                        ),
                        array(
                            'value' => 'on',
                            'label' => __('on', 'dzsp'),
                        ),
                    ), array('class' => 'styleme', 'def_value' => ''));
                    ?>
                    
                    
                    <div class="clear"></div>
                    <div class='sidenote'><?php echo __('prefer Featured Media over Featured Image always ', 'dzsp'); ?></div>
                    <div class="clear"></div>
                </div>
            
                
                <br/>
                <a href='#' class="button-primary save-btn save-mainoptions"><?php echo __('Save Options', 'dzsp'); ?></a>
            </form>
            <div class="saveconfirmer" style=""><img alt="" style="" id="save-ajax-loading2" src="<?php echo site_url(); ?>/wp-admin/images/wpspin_light.gif"/></div>
            <script>
                jQuery(document).ready(function($){
                    dzsp_mainoptions_ready();
                    $('input:checkbox').checkbox();
                })
            </script>
        </div>
                <?php
            }

            function admin_meta_gallery() {
                global $post;
                ?>
        <div id="product_images_container">
            <ul class="dzsp_item_gallery_list">
                <?php
                $product_image_gallery = '';
                if (metadata_exists('post', $post->ID, 'dzsp_image_gallery')) {
                    $product_image_gallery = get_post_meta($post->ID, 'dzsp_image_gallery', true);
                }

                $attachments = array_filter(explode(',', $product_image_gallery));

                if ($attachments) {
                    foreach ($attachments as $attachment_id) {
                        echo '<li class="item-element" data-id="' . $attachment_id . '">
' . wp_get_attachment_image($attachment_id, 'thumbnail') . '
<div class="ui-delete"></div>
</li>';
                    }
                }
                ?>
            </ul>

            <input type="hidden" id="dzsp_image_gallery" name="dzsp_image_gallery" value="<?php echo esc_attr($product_image_gallery); ?>" />
            <button class="button-secondary dzsp-add-gallery-item"><?php echo __('Add Media', 'dzsp'); ?></button>
        </div>
        <?php
    }

    function permalink_settings() {

        echo wpautop(__('These settings control the permalinks used for products. These settings only apply when <strong>not using "default" permalinks above</strong>.', 'dzsp'));

        $permalinks = get_option('dzsp_permalinks');
        $dzsp_permalink = $permalinks['item_base'];
        //echo 'ceva';

        $item_base = _x('portfolio', 'default-slug', 'dzsp');

        $structures = array(
            0 => '',
            1 => '/' . trailingslashit($item_base)
        );
        ?>
        <table class="form-table">
            <tbody>
                <tr>
                    <th><label><input name="dzsp_permalink" type="radio" value="<?php echo $structures[0]; ?>" class="dzsptog" <?php checked($structures[0], $dzsp_permalink); ?> /> <?php _e('Default'); ?></label></th>
                    <td><code><?php echo home_url(); ?>/?portfolio=sample-item</code></td>
                </tr>
                <tr>
                    <th><label><input name="dzsp_permalink" type="radio" value="<?php echo $structures[1]; ?>" class="dzsptog" <?php checked($structures[1], $dzsp_permalink); ?> /> <?php _e('Nice', 'dzsp'); ?></label></th>
                    <td><code><?php echo home_url(); ?>/<?php echo $item_base; ?>/sample-item/</code></td>
                </tr>
                <tr>
                    <th><label><input name="dzsp_permalink" id="dzsp_custom_selection" type="radio" value="custom" class="tog" <?php checked(in_array($dzsp_permalink, $structures), false); ?> />
        <?php _e('Custom Base', 'dzsp'); ?></label></th>
                    <td>
                        <input name="dzsp_permalink_structure" id="dzsp_permalink_structure" type="text" value="<?php echo esc_attr($dzsp_permalink); ?>" class="regular-text code"> <span class="description"><?php _e('Enter a custom base to use. A base <strong>must</strong> be set or WordPress will use default instead.', 'dzsp'); ?></span>
                    </td>
                </tr>
            </tbody>
        </table>
        <script type="text/javascript">
            jQuery(function($){
                jQuery('input.dzsptog').change(function() {
                    jQuery('#dzsp_permalink_structure').val( jQuery(this).val() );
                });

                jQuery('#dzsp_permalink_structure').focus(function(){
                    jQuery('#dzsp_custom_selection').click();
                });
            });
        </script>
        <?php
    }

    function permalink_settings_save() {
        if (!is_admin()) {
            return;
        }

        // We need to save the options ourselves; settings api does not trigger save for the permalinks page
        if (isset($_POST['dzsp_permalink_structure']) || isset($_POST['dzsp_category_base']) && isset($_POST['dzsp_product_permalink'])) {
            // Cat and tag bases
//            $product_category_slug = dzs_clean($_POST['dzsp_product_category_slug']);
//            $product_tag_slug = dzs_clean($_POST['dzsp_product_tag_slug']);
//            $product_attribute_slug = dzs_clean($_POST['dzsp_product_attribute_slug']);

            $permalinks = get_option('dzsp_permalinks');
            if (!$permalinks)
                $permalinks = array();

//            $permalinks['category_base'] = untrailingslashit($product_category_slug);
//            $permalinks['tag_base'] = untrailingslashit($product_tag_slug);
//            $permalinks['attribute_base'] = untrailingslashit($product_attribute_slug);

            // Product base
            $product_permalink = dzs_clean($_POST['dzsp_permalink']);

            if ($product_permalink == 'custom') {
                $product_permalink = dzs_clean($_POST['dzsp_permalink_structure']);
            } elseif (empty($product_permalink)) {
                $product_permalink = false;
            }

            $permalinks['item_base'] = untrailingslashit($product_permalink);

            update_option('dzsp_permalinks', $permalinks);
        }
    }

    function misc_input_textarea($argname, $otherargs = array()) {
        $fout = '';
        $fout.='<textarea';
        $fout.=' name="' . $argname . '"';

        $margs = array(
            'class' => '',
            'val' => '', // === default value
            'seekval' => '', // ===the value to be seeked
            'type' => '',
        );
        $margs = array_merge($margs, $otherargs);



        if ($margs['class'] != '') {
            $fout.=' class="' . $margs['class'] . '"';
        }
        $fout.='>';
        if (isset($margs['seekval']) && $margs['seekval'] != '') {
            $fout.='' . $margs['seekval'] . '';
        } else {
            $fout.='' . $margs['val'] . '';
        }
        $fout.='</textarea>';

        return $fout;
    }

    function misc_input_text($argname, $otherargs = array()) {
        $fout = '';
        $fout.='<input type="text"';
        $fout.=' name="' . $argname . '"';

        $margs = array(
            'class' => '',
            'val' => '', // === default value
            'seekval' => '', // ===the value to be seeked
            'type' => '',
        );
        $margs = array_merge($margs, $otherargs);

        if ($margs['type'] == 'colorpicker') {
            $margs['class'].=' with_colorpicker';
        }



        if ($margs['class'] != '') {
            $fout.=' class="' . $margs['class'] . '"';
        }
        if (isset($margs['seekval']) && $margs['seekval'] != '') {
            //echo $argval;
            $fout.=' value="' . $margs['seekval'] . '"';
        } else {
            $fout.=' value="' . $margs['val'] . '"';
        }
        $fout.='/>';



        //print_r($args); print_r($otherargs);
        if ($margs['type'] == 'slider') {
            $fout.='<div id="' . $argname . '_slider" style="width:200px;"></div>';
            $fout.='<script>
jQuery(document).ready(function($){
$( "#' . $argname . '_slider" ).slider({
range: "max",
min: 8,
max: 72,
value: 15,
stop: function( event, ui ) {
//console.log($( "*[name=' . $argname . ']" ));
$( "*[name=' . $argname . ']" ).val( ui.value );
$( "*[name=' . $argname . ']" ).trigger( "change" );
}
});
});</script>';
        }
        if ($margs['type'] == 'colorpicker') {
            $fout.='<div class="picker-con"><div class="the-icon"></div><div class="picker"></div></div>';
            $fout.='<script>
jQuery(document).ready(function($){
jQuery(".with_colorpicker").each(function(){
        var _t = jQuery(this);
        if(_t.hasClass("treated")){
            return;
        }
        if(jQuery.fn.farbtastic){
        //console.log(_t);
        _t.next().find(".picker").farbtastic(_t);
            
        }else{ if(window.console){ console.info("declare farbtastic..."); } };
        _t.addClass("treated");

        _t.bind("change", function(){
            //console.log(_t);
            jQuery("#customstyle_body").html("body{ background-color:" + $("input[name=color_bg]").val() + "} .dzsportfolio, .dzsportfolio a{ color:" + $("input[name=color_main]").val() + "} .dzsportfolio .portitem:hover .the-title, .dzsportfolio .selector-con .categories .a-category.active { color:" + $("input[name=color_high]").val() + " }");
        });
        _t.trigger("change");
        _t.bind("click", function(){
            if(_t.next().hasClass("picker-con")){
                _t.next().find(".the-icon").eq(0).trigger("click");
            }
        })
    });
});</script>';
        }

        return $fout;
    }

    function post_save_mo() {
        $auxarray = array();
        //parsing post data
        parse_str($_POST['postdata'], $auxarray);
        print_r($auxarray);

        update_option($this->dboptionsname, $auxarray);
        die();
    }

    function misc_generate_select($argname, $argval, $argopts = array(), $otherargs = array()) {
        $fout = '';
        $fout.='<select';
        $fout.=' name="' . $argname . '"';

        if (isset($otherargs['class'])) {
            $fout.=' class="' . $otherargs['class'] . '"';
        }
        $fout.='>';
        //print_r($argopts);
        if (isset($otherargs['generatedcontent']) && $otherargs['generatedcontent'] != '') {
            $fout.=$otherargs['generatedcontent'];
        } else {
            foreach ($argopts as $argopt) {
                $the_label = '';
                $the_val = '';
                $str_selected = '';
                if (is_array($argopt)) {
                    $the_val = $argopt['value'];
                    $the_label = $argopt['label'];
                } else {
                    $the_val = $argopt;
                    $the_label = $argopt;
                }
                if ($the_val == $argval) {
                    $str_selected = ' selected="selected"';
                }

                $fout.='<option value="' . $the_val . '"' . $str_selected . '>' . $the_label . '</option>';
            }
        }
        $fout.='</select>';
        return $fout;
    }

    function admin_meta_options() {
        global $post, $wp_version;
        $struct_uploader = '<div class="dzs-wordpress-uploader">
<a href="#" class="button-secondary">' . __('Upload', 'dzsp') . '</a>
</div>';
        //$wp_version = '3.4.1';
        if ($wp_version < 3.5) {
            $struct_uploader = '<div class="dzs-single-upload">
<input id="files-upload" class="" name="file_field" type="file">
</div>';
        }
        ?>
        <div class="dzsp-meta-bigcon">
            <input type="hidden" name="dzs_nonce" value="<?php echo wp_create_nonce('dzs_nonce'); ?>" />


            <?php
            echo '<div class="dzs-setting">
            <h4 class="setting-label">' . __('Select Featured Media Type', 'dzsp') . '</h4>
                <div class="main-feed-chooser select-hidden-metastyle">';


            echo $this->misc_generate_select('dzsp_item_type', get_post_meta($post->ID, 'dzsp_item_type', true), array(
                array(
                    'value' => 'thumb',
                    'label' => __('image', 'dzsp'),
                ),
                array(
                    'value' => 'gallery',
                    'label' => __('gallery', 'dzsp'),
                ),
                array(
                    'value' => 'audio',
                    'label' => __('image', 'dzsp'),
                ),
                array(
                    'value' => 'video',
                    'label' => __('gallery', 'dzsp'),
                ),
                array(
                    'value' => 'youtube',
                    'label' => __('youtube', 'dzsp'),
                ),
                array(
                    'value' => 'vimeo',
                    'label' => __('vimeo', 'dzsp'),
                ),
                array(
                    'value' => 'link',
                    'label' => __('image', 'dzsp'),
                ),
                array(
                    'value' => 'testimonial',
                    'label' => __('testimonial', 'dzsp'),
                ),
                array(
                    'value' => 'twitter',
                    'label' => __('twitter', 'dzsp'),
                ),
                    ), array('class' => 'textinput mainsetting', 'def_value' => ''));


            echo '<div class="option-con clearfix">
                    <div class="an-option" title="' . __('thumb', 'dzsp') . '">
                    <div class="fullbg" style="background-image:url(' . $this->thepath . 'dzsportfolio/img/hero-type-image.png' . ');"></div>
                    </div>
                    
                    <div class="an-option" title="' . __('gallery', 'dzsp') . '">
                    <div class="fullbg" style="background-image:url(' . $this->thepath . 'dzsportfolio/img/hero-type-gallery.png' . ');"></div>
                    </div>
                    
                    <div class="an-option" title="' . __('audio', 'dzsp') . '">
                    <div class="fullbg" style="background-image:url(' . $this->thepath . 'dzsportfolio/img/hero-type-audio.png' . ');"></div>
                    </div>
                    
                    <div class="an-option" title="' . __('video', 'dzsp') . '">
                    <div class="fullbg" style="background-image:url(' . $this->thepath . 'dzsportfolio/img/hero-type-video.png' . ');"></div>
                    </div>
                    
                    <div class="an-option" title="' . __('youtube', 'dzsp') . '">
                    <div class="fullbg" style="background-image:url(' . $this->thepath . 'dzsportfolio/img/hero-type-video-youtube.png' . ');"></div>
                    </div>
                    
                    <div class="an-option" title="' . __('vimeo', 'dzsp') . '">
                    <div class="fullbg" style="background-image:url(' . $this->thepath . 'dzsportfolio/img/hero-type-video-vimeo.png' . ');"></div>
                    </div>
                    
                    <div class="an-option" title="' . __('link', 'dzsp') . '">
                    <div class="fullbg" style="background-image:url(' . $this->thepath . 'dzsportfolio/img/hero-type-link.png' . ');"></div>
                    </div>
                    
                    <div class="an-option" title="' . __('testimonial', 'dzsp') . '">
                    <div class="fullbg" style="background-image:url(' . $this->thepath . 'dzsportfolio/img/hero-type-testimonial.png' . ');"></div>
                    </div>
                    
                    <div class="an-option" title="' . __('twitter', 'dzsp') . '">
                    <div class="fullbg" style="background-image:url(' . $this->thepath . 'dzsportfolio/img/hero-type-twitter.png' . ');"></div>
                    </div>
                </div>
            </div>
        </div>';
            ?>
            <div class="dzs-setting">
                <h4><?php echo __('Featured Media', 'dzsp'); ?></h4>
        <?php echo $this->misc_input_text('dzsp_featured_media', array('class' => 'input-big-image', 'def_value' => '', 'seekval' => get_post_meta($post->ID, 'dzsp_featured_media', true))); ?>
        <?php echo $struct_uploader; ?>
                <div class="dzs-img-preview-con"><div class="dzs-img-preview"></div></div>
                <div class='sidenote mode_thumb'><?php echo __('the path to the location of the image / if you have a featured image set, there is no need to input anything here', 'dzsp'); ?></div>
                <div class='sidenote mode_gallery'><?php echo __('use the Item Gallery form in the right to upload the gallery ( this field is not needed ) --->', 'dzsp'); ?></div>
                <div class='sidenote mode_audio'><?php echo __('the path to the location of the mp3 / if you have a ogg for firefox too you can place it in the backup field below', 'dzsp'); ?></div>
                <div class='sidenote mode_video'><?php echo __('the path to the location of the mp4 / if you have a ogg for firefox too you can place it in the backup field below', 'dzsp'); ?></div>
                <div class='sidenote mode_youtube mode_vimeo'><?php echo __('input here the id of the video', 'dzsp'); ?></div>
                <div class='sidenote mode_link'><?php echo __('the link on which the click directs too', 'dzsp'); ?></div>
                <div class='sidenote mode_testimonial'><?php echo __('some testimonial text', 'dzsp'); ?></div>
                <div class='sidenote mode_twitter'><?php echo __('the twitter id to get the last tweet from', 'dzsp'); ?></div>
            </div>
            <div class="dzs-setting mode_video mode_audio"> 
                <h4><?php echo __('Featured Media OGG backup', 'dzsp'); ?></h4>
        <?php echo $this->misc_input_text('dzsp_sourceogg', array('class' => 'input-big-image', 'def_value' => '', 'seekval' => get_post_meta($post->ID, 'dzsp_sourceogg', true))); ?>
        <?php echo $struct_uploader; ?>
                <div class='sidenote mode_thumb'><?php echo __('a backup ogg file for html5 streaming', 'dzsp'); ?></div>
            </div>
            <div class="dzs-setting"> 
                <h4><?php echo __('Big Image', 'dzsp'); ?></h4>
        <?php echo $this->misc_input_text('dzsp_big_image', array('class' => 'input-big-image', 'def_value' => '', 'seekval' => get_post_meta($post->ID, 'dzsp_big_image', true))); ?>
        <?php echo $struct_uploader; ?>
                <div class="dzs-img-preview-con"><div class="dzs-img-preview"></div></div>
            </div>
            <div class="dzs-setting"> 
                <h4><?php echo __('Big Gallery', 'dzsp'); ?></h4>
        <?php echo $this->misc_input_text('dzsp_biggallery', array('class' => '', 'def_value' => '', 'seekval' => get_post_meta($post->ID, 'dzsp_biggallery', true))); ?>
                <div class='sidenote'><?php echo __('make the big image part of a gallery. the different items on the same page with the same gallery name will have appear in the same gallery.', 'dzsp'); ?></div>
            </div>
            
            
            
            <div class="dzs-setting"> 
                <h4><?php echo __('Disable Title and Subtitle', 'dzsp'); ?></h4>
                <?php
                $lab = 'dzsp_disable_title_subtitle';
                echo DZSHelpers::generate_select($lab, array('seekval' => get_post_meta($post->ID, $lab, true), 'options' => array(
                    array(
                        'val' => 'off',
                        'lab' => __('off', 'dzsp'),
                    ),
                    array(
                        'val' => 'on',
                        'lab' => __('on', 'dzsp'),
                    ),
                        ), 'class' => 'styleme', 'def_value' => ''));
                ?>
                <div class="clear"></div>
                <div class='sidenote'><?php echo __('disable the title and subtitle', 'dzsp'); ?></div>
                <div class="clear"></div>
            </div>
            <div class="dzs-setting"> 
                <h4><?php echo __('Disable Content', 'dzsp'); ?></h4>
                <?php
                echo $this->misc_generate_select('dzsp_disable_content', get_post_meta($post->ID, 'dzsp_disable_content', true), array(
                    array(
                        'value' => 'off',
                        'label' => __('off', 'dzsp'),
                    ),
                    array(
                        'value' => 'on',
                        'label' => __('on', 'dzsp'),
                    ),
                        ), array('class' => 'styleme', 'def_value' => ''));
                ?>
                <div class="clear"></div>
                <div class='sidenote'><?php echo __('disable the content in skin-clean and skin-accordion', 'dzsp'); ?></div>
                <div class="clear"></div>
            </div>
            <div class="dzs-setting"> 
                <h4><?php echo __('Force Item Width', 'dzsp'); ?></h4>
                <?php echo $this->misc_input_text('dzsp_force_width', array('class' => '', 'def_value' => '', 'seekval' => get_post_meta($post->ID, 'dzsp_force_width', true))); ?>
                <div class='sidenote'><?php echo __('force a specific width for this item', 'dzsp'); ?></div>
            </div>
            <div class="dzs-setting"> 
                <h4><?php echo __('Force Item Height', 'dzsp'); ?></h4>
                <?php echo $this->misc_input_text('dzsp_force_height', array('class' => '', 'def_value' => '', 'seekval' => get_post_meta($post->ID, 'dzsp_force_height', true))); ?>
                <div class='sidenote'><?php echo __('force a specific height for this item', 'dzsp'); ?></div>
            </div>
            <div class="dzs-setting"> 
                <h4><?php echo __('Force Thumb Width', 'dzsp'); ?></h4>
                <?php echo $this->misc_input_text('dzsp_force_thumb_width', array('class' => '', 'def_value' => '', 'seekval' => get_post_meta($post->ID, 'dzsp_force_thumb_width', true))); ?>
                <div class='sidenote'><?php echo __('force a specific width for the thumb of this item', 'dzsp'); ?></div>
            </div>
            <div class="dzs-setting"> 
                <h4><?php echo __('Force Thumb Height', 'dzsp'); ?></h4>
                <?php echo $this->misc_input_text('dzsp_force_thumb_height', array('class' => '', 'def_value' => '', 'seekval' => get_post_meta($post->ID, 'dzsp_force_thumb_height', true))); ?>
                <div class='sidenote'><?php echo __('force a specific height for the thumb of this item', 'dzsp'); ?></div>
            </div>
            <div class="dzs-setting"> 
                <h4><?php echo __('Highlight Color', 'dzsp'); ?></h4>
                <?php echo $this->misc_input_text('dzsp_highlight_color', array('class' => '', 'def_value' => '', 'type' => 'colorpicker', 'seekval' => get_post_meta($post->ID, 'dzsp_highlight_color', true))); ?>
                <div class='sidenote'><?php echo __('represents the overlay color of the item ( if for example the selected skin is skin-blog ) / leave blank for default ', 'dzsp'); ?></div>
            </div>
            <div class="dzs-setting"> 
                <h4><?php echo __('Skin Blog / Position Top Overlay', 'dzsp'); ?></h4>
                <?php echo $this->misc_input_text('dzsp_infometa_top', array('class' => '', 'def_value' => '', 'seekval' => get_post_meta($post->ID, 'dzsp_infometa_top', true))); ?>
                <div class='sidenote'><?php echo __('set the overlay initial top position ( only for skin-blog )', 'dzsp'); ?></div>
            </div>
            <div class="dzs-setting"> 
                <h4><?php echo __('Subtitle', 'dzsp'); ?></h4>
                <?php $lab = 'dzsp_subtitle'; echo $this->misc_input_text($lab, array('class' => '', 'def_value' => '', 'seekval' => get_post_meta($post->ID, $lab, true))); ?>
                <div class='sidenote'><?php echo __('set a subtitle for aplicable skins ( like skin-default or skin-corporate )', 'dzsp'); ?></div>
            </div>
            <div class="dzs-setting"> 
                <h4><?php echo __('Meta Order', 'dzsp'); ?></h4>
                <?php echo $this->misc_input_text('dzsp_meta_order', array('class' => '', 'def_value' => '500', 'seekval' => get_post_meta($post->ID, 'dzsp_meta_order', true))); ?>
                <div class='sidenote'><?php echo __('used only if orderby is set to <strong>meta order</strong> in the shortcode parameters. it will display the portfolio items based on the 
        values of each portfolio item defined here', 'dzsp'); ?></div>
            </div>
            <div class="dzs-setting"> 
                <h4><?php echo __('Excerpt Length', 'dzsp'); ?></h4>
                <?php echo $this->misc_input_text('dzsp_excerpt_len', array('class' => '', 'def_value' => '500', 'seekval' => get_post_meta($post->ID, 'dzsp_excerpt_len', true))); ?>
                <div class='sidenote'><?php echo __('Only if you are using a skin that shows the content of the portfolio item / like skin-corporate - limit number of characters to show. If you have anything entered in the Excerpt field it will pull content from there.', 'dzsp'); ?></div>
            </div>
            <div class="dzs-setting"> 
                <h4><?php echo __('Gallery Slideshow Time', 'dzsp'); ?></h4>
                <?php echo $this->misc_input_text('dzsp_slideshowtime', array('class' => '', 'def_value' => '', 'seekval' => get_post_meta($post->ID, 'dzsp_slideshowtime', true))); ?>
                <div class='sidenote'><?php echo __('only for the gallery type / the time between image changes', 'dzsp'); ?></div>
            </div>
            <div class="dzs-setting"> 
                <h4><?php echo __('Extra Classes', 'dzsp'); ?></h4>
        <?php echo $this->misc_input_text('dzsp_extra_classes', array('class' => '', 'def_value' => '', 'seekval' => get_post_meta($post->ID, 'dzsp_extra_classes', true))); ?>
                <div class='sidenote'><?php echo __('[advanced] some extra classes that you want added to the portfolio item', 'dzsp'); ?></div>
            </div>
            <h4 class="bigger-heading"><?php echo __('Linking Settings', 'dzsp'); ?></h4>
            <p><img class="border-image" src="https://lh6.googleusercontent.com/-LWAgfGsX1IM/Ub5OHWlAx-I/AAAAAAAADpE/1mj0Eb6JrJc/w537-h268-no/help_structure.jpg"/></p>

            <div class="dzs-setting"> 
                <h4><?php echo __('Featured Area Links To....', 'dzsp'); ?></h4>
                <?php
                $lab = 'dzsp_link_featurearea';
                echo $this->misc_generate_select($lab, get_post_meta($post->ID, $lab, true), array(
                    array(
                        'value' => 'bigimage',
                        'label' => __('Big Image', 'dzsp'),
                    ),
                    array(
                        'value' => 'item',
                        'label' => __('Item URL', 'dzsp'),
                    ),
                    array(
                        'value' => 'customlink',
                        'label' => __('Custom Link', 'dzsp'),
                    ),
                    array(
                        'value' => 'none',
                        'label' => __('Nowhere', 'dzsp'),
                    ),
                        ), array('class' => 'styleme', 'def_value' => ''));
                ?>
                <div class="clear"></div>
                <div class='sidenote'><?php echo __('Choose where clicking the featured area should go.', 'dzsp'); ?></div>
                <div class="clear"></div>
            </div>
            <div class="dzs-setting">
                <h4><?php echo __('Open Big Image In Lightbox', 'dzsp'); ?></h4>
                <?php
                echo $this->misc_generate_select('dzsp_open_big_image_in_lightbox', get_post_meta($post->ID, 'dzsp_open_big_image_in_lightbox', true), array(
                    array(
                        'value' => 'on',
                        'label' => __('on', 'dzsp'),
                    ),
                    array(
                        'value' => 'off',
                        'label' => __('off', 'dzsp'),
                    ),
                        ), array('class' => 'styleme', 'def_value' => ''));
                ?>
                <div class="clear"></div>
            </div>
            
            
            

            <div class="dzs-setting"> 
                <h4><?php echo __('Meta Area Links To....', 'dzsp'); ?></h4>
                <?php
                $lab = 'dzsp_link_metaarea';
                echo $this->misc_generate_select($lab, get_post_meta($post->ID, $lab, true), array(
                    array(
                        'value' => 'item',
                        'label' => __('Item URL', 'dzsp'),
                    ),
                    array(
                        'value' => 'bigimage',
                        'label' => __('Big Image', 'dzsp'),
                    ),
                    array(
                        'value' => 'customlink',
                        'label' => __('Custom Link', 'dzsp'),
                    ),
                    array(
                        'value' => 'none',
                        'label' => __('Nowhere', 'dzsp'),
                    ),
                        ), array('class' => 'styleme', 'def_value' => ''));
                ?>
                <div class="clear"></div>
                <div class='sidenote'><?php echo __('Choose where clicking the featured area should go. You can input the custom link below.', 'dzsp'); ?></div>
                <div class="clear"></div>
            </div>
            <div class="dzs-setting"> 
                <h4><?php echo __('Title Links To....', 'dzsp'); ?></h4>
                <?php
                $lab = 'dzsp_link_title';
                echo $this->misc_generate_select($lab, get_post_meta($post->ID, $lab, true), array(
                    array(
                        'value' => 'none',
                        'label' => __('Nowhere', 'dzsp'),
                    ),
                    array(
                        'value' => 'item',
                        'label' => __('Item URL', 'dzsp'),
                    ),
                    array(
                        'value' => 'customlink',
                        'label' => __('Custom Link', 'dzsp'),
                    ),
                        ), array('class' => 'styleme', 'def_value' => ''));
                ?>
                <div class="clear"></div>
                <div class='sidenote'><?php echo __('Choose where clicking the item area should go. Default - no link on title. You can input the custom link below.', 'dzsp'); ?></div>
                <div class="clear"></div>
            </div>
            <div class="dzs-setting"> 
                <h4><?php echo __('Custom Link', 'dzsp'); ?></h4>
        <?php $lab = 'dzsp_customlink';
        echo $this->misc_input_text($lab, array('class' => '', 'def_value' => '', 'seekval' => get_post_meta($post->ID, $lab, true))); ?>
            </div>

        </div>

        <?php
    }

    function admin_meta_save($post_id) {
        global $post;
        if (!$post) {
            return;
        }
        if (isset($post->post_type) && !($post->post_type == 'dzs_portfolio' || $post->post_type == 'post')) {
            return $post_id;
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
            foreach ($auxa as $label => $value) {

                //print_r($label); print_r($value); 
                if (strpos($label, 'dzsp_') !== false) {
                    dzs_savemeta($post->ID, $label, $value);
                }
            }
        }

    }

    function handle_admin_head() {
        if (is_admin()) {
            echo '<script>
var dzsp_settings = {
    thepath : "' . $this->thepath . '"
};
jQuery(document).ready(function($){
window.dzs_upload_path = "' . $this->thepath . 'upload/";
window.dzs_phpfile_path = "' . $this->thepath . 'upload.php";
    if(typeof(window.dzsuploader_single_init)!="undefined"){
    window.dzsuploader_single_init(".dzs-single-upload",{});
}
                $("body").zoomBox({
                    settings_disableSocial : "on"
                    ,settings_deeplinking : "off"
                })
});
</script>';
            wp_enqueue_script('dzsp_configreceiver', $this->thepath . 'tinymce/receiver.js');
        }
    }

    function handle_admin_notices() {
        //print_r($this->notices);
        foreach ($this->notices as $notice) {
            echo $notice;
        }
    }

    function handle_wp_head() {
        echo '<script>';
        echo 'window.dzsp_settings = {';
        if ($this->mainoptions['keyword_all']) {
            echo 'settings_categories_strall : "' . $this->mainoptions['keyword_all'] . '"';
        }

        echo '}';
        echo '</script>';
        if (isset($this->mainoptions['extra_css']) && $this->mainoptions['extra_css'] != '') {
            echo '<style>';
            echo $this->mainoptions['extra_css'];
            echo '</style>';
        }
    }

    function handle_footer() {

        global $post;
        if (!$post) {
            return;
        }
        
        if ($this->fullscreen_cache_args == '') {
            return;
        }
        
        
        
        //echo 'ceva';

        if (is_array($this->fullscreen_cache_args)) {
            $this->fullscreen_cache_args['fullscreen'] = 'justdoit';
            echo $this->show_shortcode($this->fullscreen_cache_args);
        }
    }

    function admin_page() {
        ?>
        <div class="wrap">
        </div>
        <?php
    }

    function front_scripts() {

        wp_enqueue_script('dzs.portfolio', $this->thepath . 'dzsportfolio/dzsportfolio.js');
        wp_enqueue_style('dzs.portfolio', $this->thepath . 'dzsportfolio/dzsportfolio.css');
        wp_enqueue_script('dzs.advancedscroller', $this->thepath . 'advancedscroller/plugin.js');
        wp_enqueue_style('dzs.advancedscroller', $this->thepath . 'advancedscroller/plugin.css');
        wp_enqueue_script('dzs.zoombox', $this->thepath . 'zoombox/zoombox.js');
        wp_enqueue_style('dzs.zoombox', $this->thepath . 'zoombox/zoombox.css');
    }

    function show_shortcode($atts) {
        //[zoomfolio]
        $fout = '';

        $taxonomy = 'categoryportfolio';

        $margs = array(
            'settings_wpqargs' => '',
            'width' => '940',
            'height' => '300',
            'type' => 'bannerrotator',
            'menu_position' => 'right',
            'settings_mode' => 'masonry',
            'design_item_width' => '280',
            'design_item_height' => 'auto',
            'design_item_height_same_as_width' => 'off',
            'design_thumbw' => '',
            'design_thumbh' => '',
            'settings_posttype' => 'default',
            'design_categories_pos' => 'top',
            'menuitem_height' => '70',
            'settings_disablecats' => 'off',
            'settings_ajax' => 'off',
            'skin' => 'skin-default',
            'sortable' => 'on',
            'excerptlen' => '300',
            'bgcolor' => 'transparent',
            'cats' => '',
            'color_main' => '',
            'color_highlight' => '',
            'settings_specialgrid' => '',
            'posts_per_page' => '100',
            'settings_lightboxlibrary' => 'zoombox',
            'settings_preloadall' => 'off',
            'disable_itemmeta' => 'off',
            'fullscreen' => 'off',
            'orderby' => 'date',
            'defaultcategory' => '',
            'sort_order' => 'ASC',
            'design_categories_style' => 'normal',
            'design_pageContent_pos' => 'top',
            'settings_specialgrid_chooser_enabled' => 'off',
            'settings_extraclasses' => '',
            'settings_ajax_loadmoremethod' => 'scroll',
            'settings_mode_masonry_layout' => 'masonry',
            'design_preloader_bottom' => 'off',
            'design_total_height_full' => 'off',
            'settings_mode_masonry_layout_straightacross_setitemsoncenter' => 'off',
            'is_rtl' => 'off',
            'maxlen' => 'default',
            'settings_hide_category_all' => 'off',
            'settings_uselinksforcategories' => 'off',
            'settings_uselinksforcategories_enablehistoryapi' => 'off',
            
            
        );
        
        if (!isset($atts) || $atts == false) {
            $atts = array();
        }

        $margs = array_merge($margs, $atts);
        
//        print_r($atts);
//        print_r($margs);

        //===if is set to fullscreen we pass the arguments to the fullscreen call waiting in the footer
        if ($margs['fullscreen'] == 'on') {
            $this->fullscreen_cache_args = $margs;
            return;
        }
        if ($margs['skin'] == 'skin-default' || $margs['skin'] == 'skin-corporate') {
            if ($margs['design_item_height'] == '') {
                $margs['design_item_height'] = 'auto';
            }
        }
        if ($margs['skin'] == 'skin-blog') {
            if ($margs['design_item_height'] == '') {
                $margs['design_item_height'] = '280';
            }
            if ($margs['design_thumbh'] == '') {
                $margs['design_thumbh'] = 'auto';
            }
        }
        
        
        


        $tw = $margs['width'];
        $th = $margs['height'];


        $this->front_scripts();

        if ($margs['settings_lightboxlibrary'] == 'prettyphoto') {
            wp_enqueue_script('jquery.prettyphoto', $this->thepath . 'prettyphoto/prettyphoto.js');
            wp_enqueue_style('jquery.prettyphoto', $this->thepath . 'prettyphoto/prettyphoto.css');
        }

        if ($margs['settings_mode'] == 'wall') {
            wp_enqueue_script('dzs.wall', $this->thepath . 'dzswall/wall.js');
            wp_enqueue_style('dzs.wall', $this->thepath . 'dzswall/wall.css');
        }

        if ($margs['settings_mode'] == 'masonry') {
            wp_enqueue_script('jquery.isotope', $this->thepath . 'dzsportfolio/jquery.isotope.min.js');
        }

        if ($margs['skin'] == 'skin-blog') {
            //wp_enqueue_style('font.open.sans', 'http://fonts.googleapis.com/css?family=Open+Sans');
        }
        
        $settings_ajax_loadmoremethod = $margs['settings_ajax_loadmoremethod'];
        if($margs['settings_ajax_loadmoremethod']=='pages'){
            $settings_ajax_loadmoremethod = 'normal';
        }

        //=====start the LOOP
        $args_wpqargs = array();
        //print_r($margs); echo '<br><br>';        print_r($atts); echo '<br><br>';        print_r($margs['wpqargs']);
        //===lets parse custom wp query args
        $margs['settings_wpqargs'] = html_entity_decode($margs['settings_wpqargs']);
        parse_str($margs['settings_wpqargs'], $args_wpqargs);

        $wpqargs = array(
            'post_type' => 'dzs_portfolio',
            'posts_per_page' => '100',
        );

        if (!isset($args_wpqargs) || $args_wpqargs == false || is_array($args_wpqargs)==false) {
            $args_wpqargs = array();
        }
        $wpqargs = array_merge($wpqargs, $args_wpqargs);

        $pageNumber = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $wpqargs['paged'] = $pageNumber;

        //print_r($atts);
        if (isset($atts['posts_per_page']) && $atts['posts_per_page'] > 0) {
            //print_r($atts);
            $wpqargs['posts_per_page'] = $margs['posts_per_page'];
        }
        if ( $margs['settings_posttype'] != '' && $margs['settings_posttype'] != 'default') {
            //print_r($atts);
            $wpqargs['post_type'] = $margs['settings_posttype'];
        }
        //print_r($wpqargs);
        $thecustomcats = array();
        $original_thecustomcats = $thecustomcats;
        //=======custom categories
        if ($margs['cats'] != '') {

            //$wpqargs['cat'] = $margs['cats'];
            $thecustomcats = explode(',', $margs['cats']);
            $original_thecustomcats = $thecustomcats;
            
            if(isset($_GET['dzsp_defCategory_port'.$this->sliders_index]) && $margs['settings_uselinksforcategories']=='on' && $margs['settings_uselinksforcategories_enablehistoryapi']!='on' && count($thecustomcats)>1){
                $nr_selected_cat = $_GET['dzsp_defCategory_port'.$this->sliders_index];
                $nr_selected_cat = (int)$nr_selected_cat;
                $nr_selected_cat--;
                
                
                $ij = 0;
                $len = count($thecustomcats);
                for($ij=0;$ij<$len;$ij++){
                    if($ij!=$nr_selected_cat){
                        unset($thecustomcats[$ij]);
                    }
                }
                
                $thecustomcats = array_values($thecustomcats);
                
//                print_r($original_thecustomcats);
            }
            
            if ($wpqargs['post_type'] == 'post') {
                $wpqargs['cat'] = $margs['cats'];
            }
            if ($wpqargs['post_type'] == 'dzs_portfolio') {
                $wpqargs['tax_query'] = array(
                    array(
                        'taxonomy' => $taxonomy,
                        'field' => 'id',
                        'terms' => $thecustomcats,
                    )
                );
            }
        }
        //=======custom categories END

        if ($margs['orderby']) {
            $wpqargs['orderby'] = $margs['orderby'];
            if ($margs['orderby'] == 'meta order') {
                $wpqargs['orderby'] = 'meta_value_num';
                $wpqargs['meta_key'] = 'dzsp_meta_order';

                //$wpqargs['meta_query'] = array(array('key' => ''));
            }
        }
        if ($margs['sort_order'] != '') {
            $wpqargs['order'] = $margs['sort_order'];
        }

        //print_r($wpqargs);
        if ($wpqargs['post_type'] == 'post') {
            $taxonomy = 'category';
        }

        //echo urlencode(json_encode($wpqargs));
        //$wpqargs['paged']=2;
        
        if(isset($_GET['dzsp_paged'])){
            $wpqargs['paged']=$_GET['dzsp_paged'];
        }
        
        $query = new WP_Query($wpqargs);
        //print_r($query->max_num_pages);
        //print_r($query);


        $its = $query->posts;
        
//        print_r($query);

        if ($margs['color_main'] != '' || $margs['color_highlight']) {
            $fout.='<style class="custom-dzsp-styling">';
            if ($margs['color_main'] != '') {
                $fout.=' #port' . $this->sliders_index . ', #port' . $this->sliders_index . ' a { color: ' . $margs['color_main'] . '; }';
            }
            if ($margs['color_highlight'] != '') {
                $fout.=' #port' . $this->sliders_index . ' .portitem:hover .the-title, 
                    #port' . $this->sliders_index . ' .selector-con .categories .a-category.active { color: ' . $margs['color_highlight'] . '; }';
            }
            $fout.='</style>';
            $fout.="\n";
        }



        $fout.='<div id="port'.$this->sliders_index.'" class="dzsportfolio';
        if ($margs['sortable'] == 'on') {
            $fout.=' is-sortable';
        } else {
            $fout.=' is-not-sortable';
        }
        if ($margs['fullscreen'] == 'justdoit') {
            $fout.=' portfolio-is-fullscreen';
        }
        if ($margs['settings_specialgrid'] != '' && $margs['settings_specialgrid'] != 'none') {
            // echo 'ceva' . $margs['settings_specialgrid'];
            $fout.=' ' . $margs['settings_specialgrid'];
            $margs['design_item_width'] = "";
        }
        $fout.=' ' . $margs['skin'];
        $fout.= ' ' . $margs['settings_extraclasses'];
        $fout.='" style="background-color:' . $margs['bgcolor'] . '">';
        $fout.='<div class="items">';
        $fout.=$this->parse_items($its, $margs, $wpqargs);
        $fout.='</div>';




        $fout.='<div class="preloader';
        if($margs['design_preloader_bottom']=='on'){
            $fout.=' bottom';
        }
        
        $fout.='"></div>';
        $fout.='</div>';
        
        
        if($margs['settings_ajax_loadmoremethod']=='pages'){
            if($query->max_num_pages>1){
                //
                $fout.='<div class="con-dzsp-pagination">';
                for($ip=0;$ip<$query->max_num_pages;$ip++){
                    
                    $fout.='<a href="'.add_query_arg('dzsp_paged', ($ip+1), dzs_curr_url()).'" class="pagination-number';
                    if(isset($_GET['dzsp_paged'])){
                        if($_GET['dzsp_paged'] == ($ip+1)){
                            $fout.=' active';
                        }
                    }else{
                        if($ip==0){
                            $fout.= ' active';
                        }
                    }
                    $fout.='">'.($ip+1).'</a>';
                }
                $fout.='</div>';
            }
            
            
        }

        $jreadycall = 'jQuery(document).ready(function($){';

        if (isset($margs['wall_settings_thumbs_per_row']) && $margs['wall_settings_thumbs_per_row'] != '') {
            
        }else{
            $margs['wall_settings_thumbs_per_row'] = 5;
        }

        if ($margs['fullscreen'] == 'justdoit') {
            $fout.='<div class="wall-close" style="z-index: 50006">CLOSE PORTFOLIO</div>';
        }
        

        $fout.='<script>';

        if ($margs['fullscreen'] == 'justdoit') {
            $fout.='var dzsp_videofs = true; ';
        }
        $fout.=$jreadycall; ///====jQuery document ready
        if($margs['is_rtl']=='on'){
            $fout.='$.Isotope.prototype._positionAbs = function( x, y ) {
    return { right: x, top: y };
}; ';
            //$("body").attr("dir", "rtl");
        }
        if ($margs['settings_mode'] == 'wall') {
            $fout.='var wall_settings = {
    settings_thumbs_per_row:"' . $margs['wall_settings_thumbs_per_row'] . '",
    settings_width:0,
    settings_height:0,
    thumb_width:"' . $margs['design_item_width'] . '",
    thumb_height:"' . $margs['design_item_height'] . '",
    thumb_space:"' . $margs['wall_thumb_space'] . '"
};';
        }
        if ($margs['fullscreen'] == 'justdoit') {
            $fout.='jQuery(".wall-close").click(handle_wall_close);
        function handle_wall_close(){
var _t = jQuery(this);
if(dzsp_videofs==true){
    _t.html("OPEN PORTFOLIO");
    jQuery(".portfolio-is-fullscreen").fadeOut("slow");
    jQuery("body > .cat-selector").fadeOut("slow");
    dzsp_videofs = false;
}else{
    _t.html("CLOSE PORTFOLIO");
    jQuery(".portfolio-is-fullscreen").fadeIn("slow");
    jQuery("body > .cat-selector").fadeIn("slow");
    dzsp_videofs = true;
}
}';
        }
        
        
        
            if ($margs['settings_mode'] == 'masonry' && $margs['settings_mode_masonry_layout']=='straightAcross') {
                wp_enqueue_script('dzs.scroller', $this->thepath . 'dzsscroller/scroller.js');
                wp_enqueue_style('dzs.scroller', $this->thepath . 'dzsscroller/scroller.css');
            }
            
        
        $fout.=' window.dzsp_init("#port' . $this->sliders_index . '",{
settings_slideshowTime:3
,settings_mode: "' . $margs['settings_mode'] . '"
,title: ""
,design_item_width: "' . $margs['design_item_width'] . '"
,design_item_height: "' . $margs['design_item_height'] . '"
,design_categories_style: "' . $margs['design_categories_style'] . '"
,design_categories_pos: "' . $margs['design_categories_pos'] . '"
,design_pageContent_pos: "' . $margs['design_pageContent_pos'] . '"
,settings_disableCats: "' . $margs['settings_disablecats'] . '"
,settings_lightboxlibrary: "' . $margs['settings_lightboxlibrary'] . '"
,settings_preloadall: "' . $margs['settings_preloadall'] . '"
,audioplayer_swflocation: "' . $this->thepath . 'ap.swf"
,videoplayer_swflocation: "' . $this->thepath . 'preview.swf"
,disable_itemmeta: "' . $margs['disable_itemmeta'] . '"
,settings_ajax_loadmoremethod: "' . $settings_ajax_loadmoremethod . '"
    ,settings_useLinksForCategories : "'.$margs['settings_uselinksforcategories'].'"
    ,settings_useLinksForCategories_enableHistoryApi : "'.$margs['settings_uselinksforcategories_enablehistoryapi'].'"
,settings_mode_masonry_layout: "' . $margs['settings_mode_masonry_layout'] . '"
,design_total_height_full: "' . $margs['design_total_height_full'] . '"
,settings_mode_masonry_layout_straightacross_setitemsoncenter: "' . $margs['settings_mode_masonry_layout_straightacross_setitemsoncenter'] . '"
,design_item_height_same_as_width : "' . $margs['design_item_height_same_as_width'] . '"';

        if ($margs['cats'] != '') {
            $fout.=',settings_forceCats:[';
            //echo 'hmmdada';
            $iaux = 0;
            foreach ($original_thecustomcats as $customcatid) {
                //print_r($customcat);
                $customcat = get_term($customcatid, $taxonomy);
                if(isset($customcat->name)){
                    //print_r($customcat);
                    if ($iaux > 0) {
                        $fout.=',';
                    }
                    
                    $aux = $customcat->name;
                    $aux = str_replace('"', '', $aux);

                        $fout.='"' . $aux . '"';
                    $iaux++;
                }
            }
            $fout.=']';
        }
        if ($margs['defaultcategory'] != '') {

            $auxcat = get_term($margs['defaultcategory'], $taxonomy);

            $fout.=' ,settings_defaultCat:"' . $auxcat->name . '"';
        }
        if ($margs['settings_hide_category_all'] == 'on') {
            $fout.=',settings_categories_strall:""';
        }
        
        
        
        if ($margs['design_thumbw'] != '') {
            $fout.=',design_thumbw:"' . $margs['design_thumbw'] . '"';
        }
        if ($margs['design_thumbh'] != '') {
            $fout.=',design_thumbh:"'.$margs['design_thumbh'].'"';
        }
        if ($margs['settings_specialgrid_chooser_enabled'] == 'on') {
            $fout.=',settings_specialgrid_chooser: ["special-grid-4","special-grid-5"]';
        }
        if ($margs['settings_ajax'] == 'on' && $query->max_num_pages > 1) {
            $fout.=',settings_ajax_enabled:"on"';
            $fout.=',settings_ajax_pages:[';
            for ($i = 1; $i < $query->max_num_pages; ++$i) {
                if ($i > 1) {
                    $fout.=',';
                }
                $aux_wpqargs = $wpqargs;
                if (isset($aux_wpqargs['paged'])) {
                    
                }
                $fout.='"' . $this->thepath . 'ajaxreceiver.php?wpqargs=' . urlencode(json_encode($aux_wpqargs)) . '&args=' . urlencode(json_encode($margs)) . '&paged=' . ($i + 1) . '"';
            }
            $fout.=']';
        }
        if($margs['is_rtl']=='on'){
            $fout.=',settings_isotope_settings: {transformsEnabled: false}';
        }
        
        $fout.=',zoombox_settings: { settings_disablezoom: "'.$this->mainoptions['zoombox_settings_disablezoom'].'", settings_zoom_doNotGoBeyond1X: "'.$this->mainoptions['zoombox_settings_zoom_donotgobeyond1x'].'"}';
        $fout.='})
});
</script>';





        $this->sliders_index++;
        return $fout;
    }


    public function parse_items($its, $margs, $wpqargs) {
        //echo 'ceva';
        $fout = '';
        $taxonomy = 'categoryportfolio';


        $thecustomcats = array();
        //print_r($margs);
        //=======custom categories
        if ($margs['cats'] != '') {
            $thecustomcats = explode(',', $margs['cats']);
        }
        //print_r($thecustomcats);

        for ($i = 0; $i < count($its); $i++) {
            //print_r($its[$i]);
            $che = $its[$i];

            //===stabilizing meta ;;;;;
            $the_id = $che->ID;
            $the_link = get_permalink($the_id); //== the link to the actual item
            $the_type = 'thumb';
            

            $meta_disable_title_subtitle = get_post_meta($the_id, 'dzsp_disable_title_subtitle', true);
            $meta_disable_content = get_post_meta($the_id, 'dzsp_disable_content', true);
            $meta_biggallery = get_post_meta($the_id, 'dzsp_biggallery', true);

            $meta_image_gallery = get_post_meta($the_id, 'dzsp_image_gallery', true);
            $meta_image_gallery_images = explode(',', $meta_image_gallery);

            if (get_post_meta($the_id, 'dzsp_item_type', true) != '') {
                $the_type = get_post_meta($the_id, 'dzsp_item_type', true);
            }


            if ($the_type == 'thumb') {
                if ($meta_image_gallery != '') {
                    $meta_biggallery = 'gallery-for-item-' . $the_id;
                }
            }

            if ($the_type == 'link') {
                $the_link = get_post_meta($the_id, 'dzsp_featured_media', true);
            }


            if (($margs['skin'] == 'skin-accordion') && ($the_type == 'video' || $the_type == 'youtube' || $the_type == 'vimeo' || $the_type == 'gallery' || $the_type == 'audio')) {
                $meta_disable_content = 'on';
                $meta_disable_title_subtitle = 'on';
            }

            //===== setting up links START

            $link_featuredmedia = get_post_meta($the_id, 'dzsp_big_image', true);
            //dzsp_link_featurearea
            if (get_post_meta($the_id, 'dzsp_link_featurearea', true) == 'item') {
                $link_featuredmedia = $the_link;
            }
            if (get_post_meta($the_id, 'dzsp_link_featurearea', true) == 'customlink') {
                $link_featuredmedia = get_post_meta($the_id, 'dzsp_customlink', true);
            }
            if (get_post_meta($the_id, 'dzsp_link_featurearea', true) == 'none') {
                $link_featuredmedia = '';
            }

            $link_metaarea = $the_link;
            //dzsp_link_featurearea
            if (get_post_meta($the_id, 'dzsp_link_metaarea', true) == 'bigimage') {
                $link_metaarea = get_post_meta($the_id, 'dzsp_featured_media', true);
            }
            if (get_post_meta($the_id, 'dzsp_link_metaarea', true) == 'customlink') {
                $link_metaarea = get_post_meta($the_id, 'dzsp_customlink', true);
            }
            if (get_post_meta($the_id, 'dzsp_link_metaarea', true) == 'none') {
                $link_metaarea = '';
            }
            
            
            
            $link_title = '';
            //dzsp_link_featurearea
            if (get_post_meta($the_id, 'dzsp_link_title', true) == 'item') {
                $link_title = $the_link;
            }
            if (get_post_meta($the_id, 'dzsp_link_title', true) == 'customlink') {
                $link_title = get_post_meta($the_id, 'dzsp_customlink', true);
            }
            if (get_post_meta($the_id, 'dzsp_link_title', true) == 'none') {
                $link_title = '';
            }
            
            $the_subtitle = get_post_meta($the_id, 'dzsp_subtitle', true);
            if ($the_subtitle=='' && ($margs['skin'] == 'skin-default' || $margs['skin'] == 'skin-zero') && $che->post_excerpt) {
                $the_subtitle=$che->post_excerpt;
            }
            


            if ($wpqargs['post_type'] == 'dzs_portfolio') {
                $taxonomy = 'categoryportfolio';
                $post_terms = wp_get_post_terms($the_id, $taxonomy, array("fields" => "names"));
            }
            if ($wpqargs['post_type'] == 'post') {
                //echo 'ceva';
                $taxonomy = 'category';
                $post_terms = wp_get_post_terms($the_id, 'category', array("fields" => "names"));
            }

            //print_r($post_terms);


            if ($the_type == 'gallery') {

                $aux = get_post_meta($the_id, 'dzsp_image_gallery', true);
                $auximages = explode(',', $aux);
                //echo 'cevaa'.is_array($auximages).count($auximages);
                if (count($auximages) < 2) {
                    continue;
                }
            }


            //====start output the item

            $fout.='<div class="portitem-tobe';
            if (get_post_meta($the_id, 'dzsp_extra_classes', true) != '') {
                $fout.=' ' . get_post_meta($the_id, 'dzsp_extra_classes', true);
            }
            $fout.='" ';


            //=== needs improving, zoomit
            $design_item_width = $margs['design_item_width'];
            $design_item_height = $margs['design_item_height'];
            if ($design_item_height == '') {
                $design_item_height = 300;
            }
            //==temp solution
            //echo $design_item_width; echo $design_item_height; echo '';
            if ($this->mainoptions['thumbs_full_quality'] == 'full') {
                $the_src = wp_get_attachment_image_src(get_post_thumbnail_id($che->ID), 'full');
            } else if ($this->mainoptions['thumbs_full_quality'] == 'medium') {
                $the_src = wp_get_attachment_image_src(get_post_thumbnail_id($che->ID), array(($design_item_width*2), ($design_item_height*2)));
            }else {
                $the_src = wp_get_attachment_image_src(get_post_thumbnail_id($che->ID), array($design_item_width, $design_item_height));
            }

            //print_r($the_src);
            $the_real_src = $the_src[0];

            if (($this->mainoptions['misc_force_featured_media_over_featured_image']=='on'&&get_post_meta($the_id, 'dzsp_featured_media', true)!='') || ($the_real_src == '' && get_post_meta($the_id, 'dzsp_featured_media', true) != '') ) {
                $the_real_src = get_post_meta($the_id, 'dzsp_featured_media', true);
            }

            //====we force the youtube and vimeo to Featured Media Meta Field ( it's a id, you can't set it in Featured Image ) 

            
            
            if ($the_type == 'youtube' || $the_type == 'vimeo' || $the_type == 'video') {
                // ---- videos
                // ------ if there is a featured image
                if($the_src[0]!=''){
                    $fout.=' data-thumbnail="' . $the_src[0] . '"';
                }
                $fout.=' data-source_video="' . get_post_meta($the_id, 'dzsp_featured_media', true) . '"';
            }else{
                
                $fout.=' data-thumbnail="' . $the_real_src . '"';
            }


            if (get_post_meta($the_id, 'dzsp_sourceogg', true) != '') {
                $fout.=' data-source_video_ogg="' . get_post_meta($the_id, 'dzsp_sourceogg', true) . '"';
            }
            if ($the_type == 'thumb' && isset($margs['settings_biggalleryall']) && $margs['settings_biggalleryall'] == 'on') {
                $fout.=' data-biggallery="' . 'port1' . '"';
            } else {
                if ($the_type == 'thumb' && $meta_biggallery != '') {
                    $fout.=' data-biggallery="' . $meta_biggallery . '"';
                }
            }




            if (get_post_meta($the_id, 'dzsp_open_big_image_in_lightbox', true) == 'off') {
                $fout.=' data-donotopenbigimageinzoombox="on"';
            }

            if (get_post_meta($the_id, 'dzsp_highlight_color', true) != '') {
                $fout.=' data-color_highlight="' . get_post_meta($the_id, 'dzsp_highlight_color', true) . '"';
            }
            if (get_post_meta($the_id, 'dzsp_slideshowtime', true) != '') {
                $fout.=' data-slideshowtime="' . get_post_meta($the_id, 'dzsp_slideshowtime', true) . '"';
            }

            $fout.=' data-link="' . $link_metaarea . '"';

            $dataType = $the_type;
            if ($the_type == 'twitter') {
                $dataType = 'testimonial';
            }
            $fout.=' data-typefeaturedarea="' . $dataType . '"';

            if (get_post_meta($the_id, 'dzsp_big_image', true) != '') {
                $fout.=' data-bigimage="' . $link_featuredmedia . '"';
            }
            if (get_post_meta($the_id, 'dzsp_force_width', true) != '') {
                $fout.=' data-forcewidth="' . get_post_meta($the_id, 'dzsp_force_width', true) . '"';
            }
            if (get_post_meta($the_id, 'dzsp_force_height', true) != '') {
                $fout.=' data-forceheight="' . get_post_meta($the_id, 'dzsp_force_height', true) . '"';
            }
            if (get_post_meta($the_id, 'dzsp_force_thumb_width', true) != '') {
                $fout.=' data-forcethumbwidth="' . get_post_meta($the_id, 'dzsp_force_thumb_width', true) . '"';
            }
            if (get_post_meta($the_id, 'dzsp_force_thumb_height', true) != '') {
                $fout.=' data-forcethumbheight="' . get_post_meta($the_id, 'dzsp_force_thumb_height', true) . '"';
            }
            if (is_array($post_terms)) {
                $ik = 0;
                $fout.=' data-category="';

                foreach ($post_terms as $post_term) {
                    //print_r($post_term); echo 'ceva'; print_r($thecustomcats);
                    //$cat
                    $auxsw = false;
                    foreach ($thecustomcats as $customcat) {
                        $aux = get_term($customcat, $taxonomy);
                        //print_r($aux);
                        if ($aux->name == $post_term) {
                            $auxsw = true;
                        }
                    }
                    if ($margs['cats'] == '') {
                        $auxsw = true;
                    }
                    if ($auxsw == false) {
                        continue;
                    }
                    //print_r($thecustomcats);
                    if ($ik > 0) {
                        $fout.=';';
                    }
                    $post_term = str_replace('"', '', $post_term);
                    $fout.=$post_term;
                    $ik++;
                }
                $fout.='"';
            }

            if ($the_type == 'youtube') {
                $fout.=' data-heroimage="' . $this->thepath . 'dzsportfolio/img/hero-type-video-youtube.png"';
            }
            if ($the_type == 'vimeo') {
                $fout.=' data-heroimage="' . $this->thepath . 'dzsportfolio/img/hero-type-video-vimeo.png"';
            }
            if ($the_type == 'twitter') {
                $fout.=' data-heroimage="' . $this->thepath . 'dzsportfolio/img/hero-type-twitter.png"';
            }
            if ($the_type == 'link') {
                $fout.=' data-heroimage="' . $this->thepath . 'dzsportfolio/img/hero-type-link.png"';
            }


            $fout.='>';

            if ($the_type == 'gallery') {
                wp_enqueue_script('dzs.advancedscroller', $this->thepath . 'advancedscroller/plugin.js');
                wp_enqueue_style('dzs.advancedscroller', $this->thepath . 'advancedscroller/plugin.css');
                $fout.='<div class="the-feature-data">';
                $aux = get_post_meta($the_id, 'dzsp_image_gallery', true);
                $auximages = explode(',', $aux);
                if (is_array($auximages)) {
                    foreach ($auximages as $img) {
                        //echo ;
                        $imgsrc = wp_get_attachment_image_src($img, 'full');
                        //echo $imgsrc;
                        $fout.='<img class="fullwidth" src="' . $imgsrc[0] . '"/>';
                    }
                }

                $fout.='</div>';
            }
            if ($the_type == 'testimonial') {
                //echo 'ceva';
                $fout.='<div class="the-feature-data">';
                $fout.= get_post_meta($the_id, 'dzsp_featured_media', true);
                $fout.='</div>';
            }
            if ($the_type == 'twitter') {
                //echo 'ceva';
                $fout.='<div class="the-feature-data">';
                include_once(dirname(__FILE__) . '/twitterapiwrapper/twitterapi.php');

//==complete these with your twitter api key details
                $token = $this->mainoptions['twitter_token'];
                $token_secret = $this->mainoptions['twitter_token_secret'];
                $consumer_key = $this->mainoptions['twitter_consumer_key'];
                $consumer_secret = $this->mainoptions['twitter_consumer_secret'];

                $api1 = new TwitterAPI($token, $token_secret, $consumer_key, $consumer_secret);


                $query = array(// query parameters
                    'screen_name' => get_post_meta($the_id, 'dzsp_featured_media', true),
                    'count' => '1'
                );
                $data = $api1->do_query($query);
//print_r($data);
                if (isset($data->errors)) {
                    print_r($data);
                    //echo 'ceva';
                } else {
                    $fout.= ($data[0]->text);
                }
                $fout.='</div>';
            }
            if ($the_type == 'audio') {

                wp_enqueue_script('dzs.audioplayer', $this->thepath . 'audioplayer/audioplayer.js');
                wp_enqueue_style('dzs.audioplayer', $this->thepath . 'audioplayer/audioplayer.css');
            }
            if ($the_type == 'video' || $the_type == 'youtube' || $the_type == 'vimeo') {

                wp_enqueue_script('dzs.vplayer', $this->thepath . "videogallery/vplayer.js");
                wp_enqueue_style('dzs.vplayer', $this->thepath . 'videogallery/vplayer.css');
            }


            $the_post_content = '';

            $attachments = get_children(array('post_parent' => $the_id, 'post_type' => 'attachment', 'post_mime_type' => 'image', 'orderby' => 'menu_order',
                'order' => 'ASC',));
            //echo 'the post is ' . $the_id . "\n";
            $str_items = '';



            $aux = get_post_meta($the_id, 'dzsp_image_gallery', true);
            $auximages = explode(',', $aux);
            
            
            if ($aux != '') {
                foreach ($auximages as $img) {
                    //echo ;
                    $imgsrcarr = wp_get_attachment_image_src($img, 'full');
                    //echo $imgsrc;
                    $str_items .= '<li class="item-tobe needs-loading">
<img class="fullwidth" src="' . $imgsrcarr[0] . '" style="min-height:150px;"/>
</li>';
                }
            }
            
            
//            echo $margs['skin'] . 'ceva';
            if ($margs['skin'] == 'skin-corporate'){
                $fout.='<div class="item-meta" style="margin-top: 15px;">';
            }
            
            $the_post_content.='<div class="row">';
            //echo 'ceva23'; echo $str_items; echo $str_items!='';
            
            
            //===skins which have a slider
            if ($margs['skin'] == 'skin-accordion' || $margs['skin'] == 'skin-clean'){
                if ($str_items != '') {
                    $the_post_content.='<div class="lspan-4 project-slider-con"><div class="advancedscroller-con">
    <div class="advancedscroller skin-inset" style="width:100%;"><ul class="items">';
                    $the_post_content.=$str_items;
                    $the_post_content.='</ul></div></div></div>';
                    $the_post_content.='<div class="lspan-8';
                    if ($margs['skin'] == 'skin-accordion' || $margs['skin'] == 'skin-clean'){
                        $the_post_content.=' project-meta-con';
                    }

                    $the_post_content.='">';
                } else {
                    $the_post_content.='<div class="lspan-12';
                    if ($margs['skin'] == 'skin-accordion' || $margs['skin'] == 'skin-clean'){
                        $the_post_content.=' project-meta-con';
                    }

                    $the_post_content.='">';
                }
                
                
            }
            
            
            
            
            
            $maxlen = 500;
            if ( $margs['skin'] == 'skin-clean' || $margs['skin'] == 'skin-accordion'){
                //=== for skin-clean and skin-boxed lets make default max len to 1500
                $maxlen = 15000;
            }
//            echo 'maxlen'.$maxlen;
            
            if($margs['maxlen']!='default'){
                $maxlen = $margs['maxlen'];
            }
            
            if (get_post_meta($the_id, 'dzsp_excerpt_len', true) != '') {
                $maxlen = get_post_meta($the_id, 'dzsp_excerpt_len', true);
            }
            
            
//            echo 'maxlen'.$maxlen;
            
            //skin-clean will get all contents wwhile skin-corporate will get excerpt
            $the_post_content_inner = '';
            if ($margs['skin'] == 'skin-corporate' || $margs['skin'] == 'skin-boxed' || $margs['skin'] == 'skin-clean' || $margs['skin'] == 'skin-accordion' || $margs['skin'] == 'skin-vintage'){
                
                $striptags = true;
                
                if(class_exists('DOMDocument')){
//                    $striptags = false;
                }
                if ( $margs['skin'] == 'skin-clean' || $margs['skin'] == 'skin-accordion'){
                    $striptags = false;
                }
                
//                echo 'striptags'. $striptags.class_exists('DOMDocument');
                
                $po_excerpt_content = '';
                
                //we make this so that we can shorten the content even if a excerpt is set
                if($margs['maxlen']!='default'){
                    if($che->post_excerpt!=''){
                        $po_excerpt_content = $che->post_excerpt;
                    }
                }
                
                $the_post_content_inner.=stripslashes(DZSHelpers::wp_get_excerpt($the_id, array('forceexcerpt' => false, 'readmore' => 'auto', 'stripshortcodes'=>false, 'striptags' => $striptags, 'maxlen' => $maxlen, 'content'=>$po_excerpt_content, 'aftercutcontent_html' => ' [...]')));
                $the_post_content_inner = str_replace('{link_metaarea}', $link_metaarea, $the_post_content_inner);
                
                
                
//                echo 'ceva'.$the_post_content_inner;;
                
                //we run the html through a parser to close unclosed tags
                if($striptags==false && $the_post_content_inner!='' && class_exists('DOMDocument')){
                    $doc = new DOMDocument();
                    $doc->loadHTML($the_post_content_inner);

                    $aux_body_html = '';


                    $children = $doc->childNodes;
                    $scriptTags = $doc->getElementsByTagName('script');
//                    echo $the_post_content_inner; 
                    
                    
                    foreach ($scriptTags as $script) {
    if ($script->childNodes->length && $script->firstChild->nodeType == 4) {
        $cdata = $script->removeChild($script->firstChild);
        $text = $doc->createTextNode($cdata->nodeValue);
        $script->appendChild($text);
    }
                    }
                    
                    foreach ($children as $child) { 
//                        print_r($child);
//                        echo $child->ownerDocument->saveXML( $child );
                        $aux_body_html .= $child->ownerDocument->saveXML( $child ); 
                    }
                    

                    $aux_body_html = str_replace('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd"><html><body>', '', $aux_body_html);
                    $aux_body_html = str_replace('</body></html>', '', $aux_body_html);
                    
                    $aux_body_html = str_replace(array('<![CDATA['), '', $aux_body_html);
                    $aux_body_html = str_replace(array('&#13;'), '', $aux_body_html);
                    
                    
//                    $aux_body_html = preg_replace('&gt;', 'dadahmm', $aux_body_html);
//                    echo 'auxhtml'; echo $aux_body_html;
                    
                    $the_post_content_inner = $aux_body_html;
                }
                
//                echo 'ceva'.$the_post_content_inner;;
                
            }
            
            
            //echo 'hmmceva'.$the_post_content_inner.'hmmalceva';;
            
            $the_post_content.=$the_post_content_inner;
            
            
            
            //===skins which have a slider
            if ($margs['skin'] == 'skin-accordion' || $margs['skin'] == 'skin-clean'){
            $the_post_content.='</div>';//===END skins which have a slider
                
            }



            $the_post_content.='</div>'; //close row
            
//            echo $the_post_content;
            
            
            
            //==skin default and skin-nebula and skin-timeline have only title and desc
            //=== skin corporate has content but uses these too..
            if (($margs['skin'] == 'skin-timeline' || $margs['skin'] == 'skin-nebula' || $margs['skin'] == 'skin-clean' || $margs['skin'] == 'skin-corporate' || $margs['skin'] == 'skin-default' || $margs['skin'] == 'skin-zero' || $margs['skin'] == 'skin-accordion' || $margs['skin'] == 'skin-boxed' || $margs['skin'] == 'skin-aura' || $margs['skin'] == 'skin-vintage') && $meta_disable_title_subtitle != 'on') {
                if ($che->post_title) {
                    $fout.='<div class="the-title">';
                    if($link_title!=''){
                        $fout.='<a href="'.$link_title.'">';
                    }
                    $fout.=$che->post_title;
                    if($link_title!=''){
                        $fout.='</a>';
                    }
                    
                    $fout.='</div>';
                }
                if ($the_subtitle!='' &&  $margs['skin'] != 'skin-boxed') {
                    $fout.='<div class="the-desc">';
                    $fout.=$the_subtitle;
                    $fout.='</div>';
                }
            }

            
//            echo 'cevahmm'.($margs['skin'] == 'skin-clean' || $margs['skin'] == 'skin-corporate' || $margs['skin'] == 'skin-accordion').' ; '.($meta_disable_content != 'on').' ; '.($the_post_content_inner!=''). $the_post_content_inner;
            if (($margs['skin'] == 'skin-clean' || $margs['skin'] == 'skin-corporate' || $margs['skin'] == 'skin-accordion' || $margs['skin'] == 'skin-boxed' || $margs['skin'] == 'skin-vintage') && $meta_disable_content != 'on' && ($the_post_content_inner!='')) {
//                echo 'hmmdadadada';
                if($margs['skin'] == 'skin-boxed' || $margs['skin'] == 'skin-vintage'){
                    $fout.='<div class="the-desc">';
                    
                    if ($margs['skin'] == 'skin-boxed') {
                        $fout.='<hr class="separator-short">';
                    }
                }else{
                    $fout.='<div class="the-content">';
                }
                
                
                $fout.= $the_post_content . '';

                //echo $str_items;
                if ($str_items != '') {
                    wp_enqueue_script('dzs.advancedscroller', $this->thepath . 'advancedscroller/plugin.js');
                    wp_enqueue_style('dzs.advancedscroller', $this->thepath . 'advancedscroller/plugin.css');
                    $fout.='<div class="toexecute">(function() {
var aux = window.dzsp_execute_target.find(".advancedscroller");
jQuery(document).ready(function($){
    if(jQuery(".the-content").has(aux).length>0 || jQuery(".pageContent").has(aux).length>0){
    window.dzsas_init(aux,{
        settings_mode: "onlyoneitem"
        ,design_arrowsize: "0"
        ,settings_swipe: "on"
        ,settings_swipeOnDesktopsToo: "on"
        ,settings_slideshow: "on"
        ,settings_slideshowTime: "15"
    });
    }
});
})();
</div>';
                }
                
                
                $fout.='</div>';
            }
            
            
            
            if ($margs['skin'] == 'skin-corporate'){
                $fout.='</div>';///===end item-meta
            }

            if (get_post_meta($the_id, 'dzsp_highlight_color', true) != '') {
                if ($margs['skin'] == 'skin-default') {
                    $fout.='<style>';
                    $fout.=' #port' . $this->sliders_index . ' .portitem:nth-child(' . ($i + 1) . '):hover .the-title{ color: ' . get_post_meta($the_id, 'dzsp_highlight_color', true) . ';}';
                    $fout.=' #port' . $this->sliders_index . ' .portitem:nth-child(' . ($i + 1) . '):hover:after{ border-bottom-color: ' . get_post_meta($the_id, 'dzsp_highlight_color', true) . '; }';
                    $fout.=' #port' . $this->sliders_index . ' .portitem:nth-child(' . ($i + 1) . '):hover{ border-bottom: 1px solid ' . get_post_meta($the_id, 'dzsp_highlight_color', true) . ';}';
                    $fout.='</style>';
                }
            }

            //------------
            //===skinblog custom markup
            if ($margs['skin'] == 'skin-blog') {
                ///===== skin blog
                $str_bg = '';
                if (get_post_meta($the_id, 'dzsp_highlight_color', true) != '') {
                    $str_bg = 'background-color:' . get_post_meta($the_id, 'dzsp_highlight_color', true) . ';';
                }
                $str_datainittop = '';
                if (get_post_meta($the_id, 'dzsp_infometa_top', true) != '') {
                    $str_datainittop = ' data-inittop="' . get_post_meta($the_id, 'dzsp_infometa_top', true) . '"';
                }
                //echo $str_datainittop;
                if ($meta_disable_content != 'on') {

                    $fout.='<div class="item-meta" ' . $str_datainittop . ' style="' . $str_bg . '">';
                    $fout.='<div class="the-title">';
                    if ($the_link != '') {
                        $fout.='<a href="' . $the_link . '">';
                    }
                    $fout.=$che->post_title;
                    if ($the_link != '') {
                        $fout.='</a>';
                    }
                    $fout.='</div>';
                    $fout.='<div class="the-post-meta">';

                    //==calendar
                    $fout.='<span class="meta-property">';
                    $fout.='<span class="icon-meta-calendar"></span>';
                    $fout.='<span class="meta-property-content">';
                    $fout.=get_the_time('Y-m-d', $the_id);
                    $fout.='</span>';
                    $fout.='</span>';



                    $post_terms_ids = wp_get_post_terms($the_id, 'categoryportfolio', array("fields" => "ids"));
                    $ik = 0;
                    if (is_array($post_terms_ids)) {
                        $fout.='<span class="meta-property"><span class="icon-meta-category"></span><span class="meta-property-content">';

                        foreach ($post_terms_ids as $post_term) {
                            if ($ik > 0) {
                                $fout.=', ';
                            }
                            $aux_term = get_term($post_term, 'categoryportfolio');
                            //print_r($aux_term); echo ' ';
                            $term_link = get_term_link($aux_term->slug, 'categoryportfolio');
                            $fout.='<a href="' . $term_link . '">' . $aux_term->name . '</a>';
                            $ik++;
                        }
                        $fout.='</span></span>';
                    }




                    if (comments_open($the_id)) {

                        $num_comments = get_comments_number($the_id);
                        if ($num_comments == 0) {
                            
                        } else {
                            //==comments
                            $fout.='<span class="meta-property">';
                            $fout.='<span class="icon-meta-comment"></span>';
                            $fout.='<span class="meta-property-content""><a href="' . get_permalink($the_id) . '#comments">';
                            $fout.=$num_comments;
                            $fout.=' ' . __('comments', 'dzsp') . '</a></span>';
                            $fout.='</span>';
                        }
                    }

                    $fout.='</div>';
                    
                    $maxlen = 500;
                    if (get_post_meta($the_id, 'dzsp_excerpt_len', true) != '') {
                        $maxlen = get_post_meta($the_id, 'dzsp_excerpt_len', true);
                    }
                    
                    $fout.='<div class="the-post-content">' . dzs_get_excerpt($the_id, array('forceexcerpt' => false, 'readmore' => 'on', 'maxlen' => $maxlen)) . '</div>';
                    $fout.='</div>'; // END item-meta
                }
            }

            //$the_meta = $this->get_post_meta_all($the_id);
            //print_r($the_meta);
            //
            //echo $the_link;


            $fout.='</div>';
            //continue;


            if ($the_type == 'thumb') {
                if (is_array($meta_image_gallery_images))
                    foreach ($meta_image_gallery_images as $img) {
                        //echo ;
                        $aux_po = get_post($img);

                        $the_src = '';
                        $the_thumb = '';
                        if ($aux_po && $aux_po->post_mime_type == 'video/mp4') {
                            $the_src = $aux_po->guid;
                        } else {
                            $imgsrc = wp_get_attachment_image_src($img, 'full');
                            $the_src = $imgsrc[0];
                            $the_thumb = $the_src;
                        }

                        if (get_post_meta($img, '_attachment_video_thumb', true) != '') {
                            $the_thumb = get_post_meta($img, '_attachment_video_thumb', true);
                        }

                        //echo $imgsrc;
                        //echo 'ceva'; print_r($aux);
                        $fout.='<a href="' . $the_src . '" class="hidden zoombox" data-biggallery="' . $meta_biggallery . '" data-biggallerythumbnail="' . $the_thumb . '"></a>';
                    }
            }
        }
        return $fout;
    }

}


if(!class_exists('DZSPageBuilder')){
    $filename = dirname(__FILE__).'/plugins/dzs-pagebuilder/pagebuilder.php';
    
    
    if (file_exists($filename)) {
        include_once($filename);
    }
}