<?php
/**
 * werock functions and definitions
 *
 * @package werock
 */
    global $xv_data; //fetch options stored in $smof_data 


    require_once ('admin/admin-init.php');

  	/**
     * Slightly Modified Options Framework
     *
     */
    //require_once ('admin/index.php');

    /**
     * TGM Plugin Installer
     *
     */
    require_once ('inc/plugin-installer.php');   
       /**
     * Image resizer
     *
     */
    require_once ('inc/mr-image-resize.php');
    /**
 	   * Custom Fields
 	   */
    include_once 'inc/class-metaboxes.php';
    /**
     * Auto import a XML file
     */
    // require_once ('inc/autoimport/autoimporter.php'); 
    /**
     * Enabe Woocommerce Supprt for theme
     */
    require get_template_directory() . '/inc/woo-config.php';

    require_once ('inc/widgets/widget-functions.php');
    

add_action('admin_head', 'my_custom_logo');

function my_custom_logo() {
echo '<style type="text/css">
#wp-admin-bar-wp-logo .ab-icon {background: url('.get_bloginfo('template_directory').'/images/minilogo.png) no-repeat center top !important; }</style>';
}

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
	$content_width = 640; /* pixels */

if ( ! function_exists( 'werock_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function werock_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on werock, use a find and replace
	 * to change 'werock' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'werock', get_template_directory() . '/languages' );

  $domain = 'werock';

    load_theme_textdomain( $domain, WP_LANG_DIR . '/werock/' );
    load_theme_textdomain( $domain, get_stylesheet_directory() . '/languages/' );
    load_theme_textdomain( $domain, get_template_directory() . '/languages/' );


	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );
  add_image_size( 'masonry-thumb', 200, 300,true);
  add_image_size( 'news-thumb', 100, 100,true);
  
  function theme_thumb($url, $width, $height=0, $align='') { 
  return mr_image_resize($url, $width, $height, true, $align, false);
}

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'main' => __( 'Main Menu', 'werock' ),
    //'top' => __( 'Top Menu', 'werock' ),
	) );

	/*
	*
	*	Include Menu Walker Class
	*/
	 	 require 'inc/class-bootstrapwp_walker_nav_menu.php';

	// Setup the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'werock_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // werock_setup
add_action( 'after_setup_theme', 'werock_setup' );

/**
 * Register widgetized area and update sidebar with default widgets.
 */
function werock_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'werock' ),
		'id'            => 'sidebar-1',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

    register_sidebar( array(
    'name'          => __( 'Contact Page Sidebar', 'werock' ),
    'id'            => 'contact-sidebar',
    'before_widget' => '<aside id="%1$s" class="widget %2$s">',
    'after_widget'  => '</aside>',
    'before_title'  => '<h3 class="widget-title">',
    'after_title'   => '</h3>',
  ) );


    register_sidebar( array(
        'name'          => __( 'Footer Widget1', 'werock' ),
        'id'            => 'footer-widget1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer Widget2', 'werock' ),
        'id'            => 'footer-widget2',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer Widget3', 'werock' ),
        'id'            => 'footer-widget3',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ) );
        register_sidebar( array(
        'name'          => __( 'Footer Widget4', 'werock' ),
        'id'            => 'footer-widget4',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h4 class="footer-widget-title">',
        'after_title'   => '</h4>',
    ) );
            
}
add_action( 'widgets_init', 'werock_widgets_init' );










/**
 * Enqueue scripts and styles.
 */ 
 
function werock_scripts() {
  global $smof_data;

	wp_enqueue_style( 'Oswald', 'http://fonts.googleapis.com/css?family=Oswald:400,700,300'); 
	wp_enqueue_style( 'Roboto', 'http://fonts.googleapis.com/css?family=Roboto:400,400italic,700'); 


  wp_enqueue_style('bootstrap-min', get_template_directory_uri() . '/assets/css/bootstrap.min.css', false, '1.0', 'all');
  wp_enqueue_style( 'werock-style', get_stylesheet_uri());

  
   wp_enqueue_style('options', get_template_directory_uri() . '/admin/assets/css/options.css', 'style');





wp_enqueue_script( 'plugins', get_template_directory_uri() . '/assets/js/plugins.js', array(), '1.0', true );
wp_enqueue_script( 'jplayer', get_template_directory_uri() . '/assets/jPlayer/jquery.jplayer.min.js', array(), '1.0', true );
wp_enqueue_script( 'playlist', get_template_directory_uri() . '/assets/jPlayer/add-on/jplayer.playlist.min.js', array(), '1.0', true );
wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array(), '1.0', true );
wp_enqueue_script( 'googleapis', 'https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false', array(), '3.0', true );
wp_enqueue_script( 'main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0', true );
wp_enqueue_script( 'modernizr', get_template_directory_uri() . '/assets/js/modernizr-2.6.2-respond-1.1.0.min.js', array(), '2.6.2', false );

wp_enqueue_script( 'jquery' );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ){
		wp_enqueue_script( 'comment-reply' );

    }
}


add_action( 'wp_enqueue_scripts', 'werock_scripts' );


    


/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

    
     /**
     * custom-posts
     */
     require_once ('inc/custom-posts.php');
/* 
Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';





function xv_videoType($url) {
    if (strpos($url, 'youtube') > 0) {
        return 'youtube';
    } elseif (strpos($url, 'vimeo') > 0) {
        return 'vimeo';
    } else {
        return 'unknown';
    }
}








/**
 * Custom post type date archives
 */

/**
 * Custom post type specific rewrite rules
 * @return wp_rewrite             Rewrite rules handled by Wordpress
 */
function cpt_rewrite_rules($wp_rewrite) {
    $rules = cpt_generate_date_archives('event', $wp_rewrite);
    $wp_rewrite->rules = $rules + $wp_rewrite->rules;
    return $wp_rewrite;
}
add_action('generate_rewrite_rules', 'cpt_rewrite_rules');

/**
 * Generate date archive rewrite rules for a given custom post type
 * @param  string $cpt        slug of the custom post type
 * @return rules              returns a set of rewrite rules for Wordpress to handle
 */
function cpt_generate_date_archives($cpt, $wp_rewrite) {
    $rules = array();
    $slug_archive  = '';
    $post_type = get_post_type_object($cpt);
    if(!empty($post_type->has_archive)){
    $slug_archive = $post_type->has_archive;
    }
    
    if ($slug_archive === false) return $rules;
    if ($slug_archive === true) {
        $slug_archive = $post_type->name;
    }

    $dates = array(
        array(
            'rule' => "([0-9]{4})/([0-9]{1,2})/([0-9]{1,2})",
            'vars' => array('year', 'monthnum', 'day')),
        array(
            'rule' => "([0-9]{4})/([0-9]{1,2})",
            'vars' => array('year', 'monthnum')),
        array(
            'rule' => "([0-9]{4})",
            'vars' => array('year'))
        );

    foreach ($dates as $data) {
        $query = 'index.php?post_type='.$cpt;
        $rule = $slug_archive.'/'.$data['rule'];

        $i = 1;
        foreach ($data['vars'] as $var) {
            $query.= '&'.$var.'='.$wp_rewrite->preg_index($i);
            $i++;
        }

        $rules[$rule."/?$"] = $query;
        $rules[$rule."/feed/(feed|rdf|rss|rss2|atom)/?$"] = $query."&feed=".$wp_rewrite->preg_index($i);
        $rules[$rule."/(feed|rdf|rss|rss2|atom)/?$"] = $query."&feed=".$wp_rewrite->preg_index($i);
        $rules[$rule."/page/([0-9]{1,})/?$"] = $query."&paged=".$wp_rewrite->preg_index($i);
    }
    return $rules;
}


function wps_translation_mangler($translation, $text, $domain) {
        global $post;
    if ( !empty( $post ) && $post->post_type == 'event') {
        $translations = get_translations_for_domain( $domain);
        if ( $text == 'Scheduled for: <b>%1$s</b>') {
            return $translations->translate( 'Event Start Date: <b>%1$s</b>' );
        }
        if ( $text == 'Published on: <b>%1$s</b>') {
            return $translations->translate( 'Event Start Date: <b>%1$s</b>' );
        }
        if ( $text == 'Publish <b>immediately</b>') {
            return $translations->translate( 'Event Start Date: <b>%1$s</b>' );
        }
    }
    return $translation;
}
add_filter('gettext', 'wps_translation_mangler', 10, 4);




add_action( 'post_submitbox_misc_actions', 'article_or_box' );
add_action( 'save_post', 'save_article_or_box' );
function article_or_box() {
    global $post;
    if (get_post_type($post) == 'event') {
        echo '<div class="misc-pub-section misc-pub-section-last" style="border-top: 1px solid #eee;">';
       wp_nonce_field( 'my_meta_box_nonce', 'meta_box_nonce' );
       

        
          $values = get_post_custom( $post->ID );
          $xv_event_location = isset( $values['xv_event_location'] ) ? esc_attr( $values['xv_event_location'][0] ) : '';
          $xv_event_btn_url = isset( $values['xv_event_btn_url'] ) ? esc_attr( $values['xv_event_btn_url'][0] ) : '';
          $xv_event_btn_text = isset( $values['xv_event_btn_text'] ) ? esc_attr( $values['xv_event_btn_text'][0] ) : '';

          $xv_event_btn_woo = isset( $values['xv_event_btn_woo'] ) ? esc_attr( $values['xv_event_btn_woo'][0] ) : '';

          $xv_end_time_hh = isset( $values['xv_end_time_hh'] ) ? esc_attr( $values['xv_end_time_hh'][0] ) : '';
          $xv_end_time_mm = isset( $values['xv_end_time_mm'] ) ? esc_attr( $values['xv_end_time_mm'][0] ) : '';
        ?>
       
       
          <div class="curtime misc-pub-curtime">
            <span id="timestamp">
              Event End Time:
               @ <input type="text" autocomplete="off" maxlength="2" size="2"  value="<?php echo $xv_end_time_hh; ?>" name="xv_end_time_hh" id="hh"> : 
                 <input type="text" autocomplete="off" maxlength="2" size="2"  value="<?php echo $xv_end_time_mm; ?>" name="xv_end_time_mm" id="mn">
            </span>
          </div>
          <br>
          <label for="xv_event_location"><div class="dashicons dashicons-location"></div>Location:</label> 
          <input type="text" name="xv_event_location" style="width:94%" id="xv_event_location" value="<?php echo $xv_event_location; ?>" ><br>
           <label for="xv_event_location"><div class="dashicons dashicons-location"></div>Button Text:</label> 
            <input type="text" name="xv_event_btn_text" style="width:94%" id="xv_event_btn_text" placeholder="Buy Tickets (Optional)" value="<?php echo $xv_event_btn_text; ?>" ><br>
           <label for="xv_event_location"><div class="dashicons dashicons-location"></div>Button URL:</label> 
            <input type="text" name="xv_event_btn_url" style="width:94%" id="xv_event_btn_url" value="<?php echo $xv_event_btn_url; ?>" ><br>
          <hr>
          <label for="xv_event_woo"><div class="dashicons dashicons-location"></div>Woocommerce Product ID: (Note: It will replace Buy Tickets Button)</label> 
          <input type="text" name="xv_event_btn_woo" style="width:94%" id="xv_event_btn_woo" value="<?php echo $xv_event_btn_woo; ?>" ><br>

         
         
    


        </div><!-- .misc-pub-section -->
        <?php


    }
}
function save_article_or_box($post_id) {
 
    if (!isset($_POST['post_type']) )
        return $post_id;
 
    // if our nonce isn't there, or we can't verify it, bail
  if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
  
 
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;
 
  // Probably a good idea to make sure your data is set
  if( isset( $_POST['xv_event_location'] ) )
    update_post_meta( $post_id, 'xv_event_location', wp_kses( $_POST['xv_event_location'], $allowed ) ); 
    // Probably a good idea to make sure your data is set
  if( isset( $_POST['xv_event_btn_url'] ) )
    update_post_meta( $post_id, 'xv_event_btn_url', wp_kses( $_POST['xv_event_btn_url'], $allowed ) ); 
    // Probably a good idea to make sure your data is set
  if( isset( $_POST['xv_event_btn_text'] ) )
    update_post_meta( $post_id, 'xv_event_btn_text', wp_kses( $_POST['xv_event_btn_text'], $allowed ) ); 

  if( isset( $_POST['xv_event_btn_woo'] ) )
    update_post_meta( $post_id, 'xv_event_btn_woo', wp_kses( $_POST['xv_event_btn_woo'], $allowed ) );

  // Probably a good idea to make sure your data is set
  if( isset( $_POST['xv_end_time_hh'] ) )
    update_post_meta( $post_id, 'xv_end_time_hh', wp_kses( $_POST['xv_end_time_hh'], $allowed ) ); 
  // Probably a good idea to make sure your data is set
  if( isset( $_POST['xv_end_time_mm'] ) )
    update_post_meta( $post_id, 'xv_end_time_mm', wp_kses( $_POST['xv_end_time_mm'], $allowed ) ); 
}

function onetarek_prevent_future_type( $post_data ) {
if ( $post_data['post_status'] == 'future' && $post_data['post_type'] == 'event' )#Here I am checking post_type='post' , you may use different post type and if you want it for all post type then remove "&& $post_data['post_type'] == 'post'"
{
$post_data['post_status'] = 'publish';
}
return $post_data;
}
add_filter('wp_insert_post_data', 'onetarek_prevent_future_type');
remove_action('future_post', '_future_post_hook');




//Disable IG Page Builder CSS and JS
if( class_exists( 'IG_Pb_Init' ) ) {
  
  update_option('ig_pb_settings_boostrap_css', 'disable' );
  update_option('ig_pb_settings_boostrap_js', 'disable' );
}
if( class_exists( 'easyFancyBox' ) ) {

 update_option('fancybox_enableYoutube','1');
 update_option('fancybox_enableVimeo','1');
 update_option('fancybox_enableDailymotion','1');
}
