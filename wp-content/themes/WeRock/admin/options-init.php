<?php

/**
  ReduxFramework Sample Config File
  For full documentation, please visit: https://docs.reduxframework.com
 * */

if (!class_exists('Redux_Framework_sample_config')) {

    class Redux_Framework_sample_config {

        public $args        = array();
        public $sections    = array();
        public $theme;
        public $ReduxFramework;

        public function __construct() {

            if (!class_exists('ReduxFramework')) {
                return;
            }

            // This is needed. Bah WordPress bugs.  ;)
            if (  true == Redux_Helpers::isTheme(__FILE__) ) {
                $this->initSettings();
            } else {
                add_action('plugins_loaded', array($this, 'initSettings'), 10);
            }

        }

        public function initSettings() {

            // Just for demo purposes. Not needed per say.
            $this->theme = wp_get_theme();

            // Set the default arguments
            $this->setArguments();

            // Set a few help tabs so you can see how it's done
            $this->setHelpTabs();

            // Create the sections and fields
            $this->setSections();

            if (!isset($this->args['opt_name'])) { // No errors please
                return;
            }

            // If Redux is running as a plugin, this will remove the demo notice and links
            //add_action( 'redux/loaded', array( $this, 'remove_demo' ) );
            
            // Function to test the compiler hook and demo CSS output.
            // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
            add_filter('redux/options/'.$this->args['opt_name'].'/compiler', array( $this, 'compiler_action' ), 10, 2);
            
            // Change the arguments after they've been declared, but before the panel is created
            //add_filter('redux/options/'.$this->args['opt_name'].'/args', array( $this, 'change_arguments' ) );
            
            // Change the default value of a field after it's been set, but before it's been useds
            //add_filter('redux/options/'.$this->args['opt_name'].'/defaults', array( $this,'change_defaults' ) );
            
            // Dynamically add a section. Can be also used to modify sections/fields
            //add_filter('redux/options/' . $this->args['opt_name'] . '/sections', array($this, 'dynamic_section'));

            $this->ReduxFramework = new ReduxFramework($this->sections, $this->args);
        }

        /**

          This is a test function that will let you see when the compiler hook occurs.
          It only runs if a field	set with compiler=>true is changed.

         * */
    
        function compiler_action($options, $css) {

             global $xv_data; 
    

               /** Define some vars **/
    $$xv_data = $options;
    $uploads = wp_upload_dir();
    $css_dir = get_template_directory() . '/admin/assets/css/'; // Shorten code, save 1 call
    /** Save on different directory if on multisite **/
    if(is_multisite()) {
    $aq_uploads_dir =$css_dir;
    } else {
    $aq_uploads_dir = $css_dir;
    }
    /** Capture CSS output **/
    ob_start();
    require($css_dir . 'styles.php');
    $css = ob_get_clean();
    /** Write to options.css file **/
    WP_Filesystem();
    global $wp_filesystem;
    if ( ! $wp_filesystem->put_contents( $aq_uploads_dir . 'options.css', $css, 0644) ) {
    return true;
    }
             


        }
        

        /**

          Custom function for filtering the sections array. Good for child themes to override or add to the sections.
          Simply include this function in the child themes functions.php file.

          NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
          so you must use get_template_directory_uri() if you want to use any of the built in icons

         * */
        function dynamic_section($sections) {
            //$sections = array();
            $sections[] = array(
                'title' => __('Section via hook', 'redux-framework-demo'),
                'desc' => __('<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo'),
                'icon' => 'el-icon-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }

        /**

          Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.

         * */
        function change_arguments($args) {
            //$args['dev_mode'] = true;

            return $args;
        }

        /**

          Filter hook for filtering the default value of any given field. Very useful in development mode.

         * */
        function change_defaults($defaults) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }

        // Remove the demo link and the notice of integrated demo from the redux-framework plugin
        function remove_demo() {

            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if (class_exists('ReduxFrameworkPlugin')) {
                remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::instance(), 'plugin_metalinks'), null, 2);

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action('admin_notices', array(ReduxFrameworkPlugin::instance(), 'admin_notices'));
            }
        }

        public function setSections() {

            /**
              Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
             * */
            // Background Patterns Reader
            $sample_patterns_path   = ReduxFramework::$_dir . '../sample/patterns/';
            $sample_patterns_url    = ReduxFramework::$_url . '../sample/patterns/';
            $sample_patterns        = array();

            if (is_dir($sample_patterns_path)) :

                if ($sample_patterns_dir = opendir($sample_patterns_path)) :
                    $sample_patterns = array();

                    while (( $sample_patterns_file = readdir($sample_patterns_dir) ) !== false) {

                        if (stristr($sample_patterns_file, '.png') !== false || stristr($sample_patterns_file, '.jpg') !== false) {
                            $name = explode('.', $sample_patterns_file);
                            $name = str_replace('.' . end($name), '', $sample_patterns_file);
                            $sample_patterns[]  = array('alt' => $name, 'img' => $sample_patterns_url . $sample_patterns_file);
                        }
                    }
                endif;
            endif;

            ob_start();

            $ct             = wp_get_theme();
            $this->theme    = $ct;
            $item_name      = $this->theme->get('Name');
            $tags           = $this->theme->Tags;
            $screenshot     = $this->theme->get_screenshot();
            $class          = $screenshot ? 'has-screenshot' : '';

            $customize_title = sprintf(__('Customize &#8220;%s&#8221;', 'redux-framework-demo'), $this->theme->display('Name'));
            
            ?>
            <div id="current-theme" class="<?php echo esc_attr($class); ?>">
            <?php if ($screenshot) : ?>
                <?php if (current_user_can('edit_theme_options')) : ?>
                        <a href="<?php echo wp_customize_url(); ?>" class="load-customize hide-if-no-customize" title="<?php echo esc_attr($customize_title); ?>">
                            <img src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                        </a>
                <?php endif; ?>
                    <img class="hide-if-customize" src="<?php echo esc_url($screenshot); ?>" alt="<?php esc_attr_e('Current theme preview'); ?>" />
                <?php endif; ?>

                <h4><?php echo $this->theme->display('Name'); ?></h4>

                <div>
                    <ul class="theme-info">
                        <li><?php printf(__('By %s', 'redux-framework-demo'), $this->theme->display('Author')); ?></li>
                        <li><?php printf(__('Version %s', 'redux-framework-demo'), $this->theme->display('Version')); ?></li>
                        <li><?php echo '<strong>' . __('Tags', 'redux-framework-demo') . ':</strong> '; ?><?php printf($this->theme->display('Tags')); ?></li>
                    </ul>
                    <p class="theme-description"><?php echo $this->theme->display('Description'); ?></p>
            <?php
            if ($this->theme->parent()) {
                printf(' <p class="howto">' . __('This <a href="%1$s">child theme</a> requires its parent theme, %2$s.') . '</p>', __('http://codex.wordpress.org/Child_Themes', 'redux-framework-demo'), $this->theme->parent()->display('Name'));
            }
            ?>

                </div>
            </div>

            <?php
            $item_info = ob_get_contents();

            ob_end_clean();

            $sampleHTML = '';
            if (file_exists(dirname(__FILE__) . '/info-html.html')) {
                /** @global WP_Filesystem_Direct $wp_filesystem  */
                global $wp_filesystem;
                if (empty($wp_filesystem)) {
                    require_once(ABSPATH . '/wp-admin/includes/file.php');
                    WP_Filesystem();
                }
                $sampleHTML = $wp_filesystem->get_contents(dirname(__FILE__) . '/info-html.html');
            }



            // ACTUAL DECLARATION OF SECTIONS
            $this->sections[] = array(
                'title'     => __('Home Settings', 'redux-framework-demo'),
                'icon'      => 'el-icon-home',
                // 'submenu' => false, // Setting submenu to false on a given section will hide it from the WordPress sidebar menu!
                'fields'    => array(

                      
                    array(
                        'id' => 'info_success',
                        'type' => 'info',
                        'style' => 'success',
                        'icon' => 'el-icon-info-sign',
                        'title' => __('Note:', 'redux-framework-demo'),
                        'desc' => __('Slider settings will also effective for slider widget which you can use in page builder.', 'redux-framework-demo')
                    ),



                     array(
                        'id'          => 'mycustom_field',
                        'type'        => 'xv_slides',
                        'title'       => __('Slider', 'redux-framework-demo'),
                        'subtitle'    => __('Add some slider Images.', 'redux-framework-demo'),
                       'placeholder' => array(
                                            'title'       => __('This is a title', 'redux-framework-demo'),
                                            'url'         => __('Give us a link!', 'redux-framework-demo'),
                                        ),
                    ),

                   
/*

                    array(
                        'id'          => 'slides',
                        'type'        => 'slides',
                        'title'       => __('Slides Options', 'redux-framework-demo'),
                        'subtitle'    => __('Unlimited slides with drag and drop sortings.', 'redux-framework-demo'),
                        'placeholder' => array(
                                            'title'       => __('This is a title', 'redux-framework-demo'),
                                            'description' => __('Description Here', 'redux-framework-demo'),
                                            'url'         => __('Give us a link!', 'redux-framework-demo'),
                                        ),
                    ),

*/
                    array(
                        'id' => 'info_warning',
                        'type' => 'info',
                        'style' => 'warning',
                        'title' => __('Note:', 'redux-framework-demo'),
                        'desc' => __('Following Settings will not work if home page is created by using page builder because every widget has its own settings.', 'redux-framework-demo')
                    ),
                    

                     array(
                        'id'        => 'home-post-carousel',
                        'type'      => 'switch',
                        'title'     => __('Latest Albums ', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or disable Carousel', 'redux-framework-demo'),
                        "default"   => 0,
                        'on'        => 'Enabled',
                        'off'       => 'Disabled',
                    ),


                          
                            array(
                                'id'                => 'home-carousel-num',
                                'required'          => array('home-post-carousel', '=', '1'),
                                'type'              => 'spinner',
                                'title'             => __('Number of Carousel Posts', 'redux-framework-demo'),
                                'desc'              => __('Enter the number of carousel posts', 'redux-framework-demo'),
                                "default"           => "8",
                                "min"               => "4",
                                "step"              => "1",
                                "max"               => "20",
                            ),

                            array(
                                'id'                => 'home-event-num',
                                'type'              => 'spinner',
                                'title'             => __('Number of Events', 'redux-framework-demo'),
                                'desc'              => __('Enter the number of upcomming events', 'redux-framework-demo'),
                                "default"           => "4",
                                "min"               => "4",
                                "step"              => "1",
                                "max"               => "20",
                            ),
                            array(
                                'id'                => 'home-news-num',
                                'type'              => 'spinner',
                                'title'             => __('Number of News', 'redux-framework-demo'),
                                'desc'              => __('Enter the number of latest news.', 'redux-framework-demo'),
                                "default"           => "4",
                                "min"               => "4",
                                "step"              => "1",
                                "max"               => "20",
                            ),
                            array(
                                'id'                => 'home-videos-num',
                                'type'              => 'spinner',
                                'title'             => __('Number of Videos', 'redux-framework-demo'),
                                'desc'              => __('Enter the number of latest videos', 'redux-framework-demo'),
                                "default"           => "4",
                                "min"               => "4",
                                "step"              => "1",
                                "max"               => "20",
                            )
                    
                ),
            );






///////////////////////////////////////---General Settings-----//////////////////////////////////////////////////////////////////////////
            $this->sections[] = array(
                'icon' => 'el-icon-cogs',
                'title' => __('General Settings', 'redux-framework-demo'),
                'fields' => array(
                    


               array(
                        'id' => 'logo',
                        'type' => 'media',
                        'url' => true,
                        'title' => __('Media w/ URL', 'redux-framework-demo'),
                        'compiler' => 'true',
                        //'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'desc' => __('Basic media uploader with disabled URL input field.', 'redux-framework-demo'),
                        'subtitle' => __('Upload any media using the WordPress native uploader', 'redux-framework-demo'),
                        'default' => array('url' => 'http://s.wordpress.org/style/images/codeispoetry.png'),
                        'hint' => array(
                            'title'     => 'Hint Title',
                            'content'   => 'This is a <b>hint</b> for the media field with a Title.',
                        )
                    ),


                    array(
                        'id' => 'fav-icon',
                        'type' => 'media',
                        'title' => __('Upload Favicon', 'redux-framework-demo'),
                        'compiler' => 'true',
                        'mode' => false, // Can be set to false to allow any media type, or can also be set to any mime type.
                        'subtitle' => __('Upload your Upload Favicon.', 'redux-framework-demo'),
                    ),

                      array(
                        'id' => 'switch-menu',
                        'type' => 'switch',
                        'title' => __('Enable or disable mega menu.', 'redux-framework-demo'),
                        'subtitle' => __('Please make sure page builder plugin is installed and activated.', 'redux-framework-demo'),
                        "default" => 0,
                        'on' => 'Enable',
                        'off' => 'Disable',
                    ),

                       array(
                        'id' => 'respnisve-menu',
                        'type' => 'switch',
                        'title' => __('Mobile Mega Menu', 'redux-framework-demo'),
                        'subtitle' => __('Enable mega menu on mobile devices by default it use wordpress default menu.', 'redux-framework-demo'),
                        "default" => 0,
                        'on' => 'Enable',
                        'off' => 'Disable',
                    ),





                    array(
                        'id'        =>  'social-icons',
                        'type'      =>  'text',
                        'title'     =>  __('Social Icons', 'redux-framework-demo'),
                        'subtitle'  =>  __('Enter your social links Add a proper URL.', 'redux-framework-demo'),
                        'options'   =>  array(
                                            'facebook'  => 'Facebook',
                                            'twitter'   => 'Twitter',
                                            'pinterest' => 'Pinterest',
                                            'linkedin'  => 'Linkedin',
                                            'flickr'    => 'Flickr',
                                            'youtube'   => 'Youtube',
                                            'instagram' => 'Instagram',
                                        ),
                        'default'   =>  array(
                                        'facebook'  => '',
                                        'twitter'   => '',
                                        'pinterest' => '',
                                        'linkedin'  => '',
                                        'flickr'    => '',
                                        'youtube'   => '',
                                        'instagram' => '',
                                    )

                    ),

           

                    array(
                        'id' => 'tracking-code',
                        'type' => 'textarea',
                        'title' => __('Tracking Code', 'redux-framework-demo'),
                        'subtitle' => __('Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.', 'redux-framework-demo'),
                        'validate' => 'js',
                    ),

                )
            );

///////////////////////////////////////---custom Code Blocks-----//////////////////////////////////////////////////////////////////////////

                $this->sections[] = array(
                    'icon' => 'el-icon-tint',
                    'title' => __('Code Editors', 'redux-framework-demo'),
                    'fields' => array(
                    
                    array(
                        'id' => 'css-code',
                        'type' => 'ace_editor',
                        'title' => __('CSS Code', 'redux-framework-demo'),
                        'subtitle' => __('Paste your CSS code here.', 'redux-framework-demo'),
                        'mode' => 'css',
                        'compiler' =>true,
                        'theme' => 'monokai',
                    ),
                    array(
                        'id' => 'js-code',
                        'type' => 'ace_editor',
                        'title' => __('JS Code', 'redux-framework-demo'),
                        'subtitle' => __('Paste your JS code here. Js will be included in footer.', 'redux-framework-demo'),
                        'mode' => 'javascript',
                        'theme' => 'chrome',
                        'default' => "jQuery(document).ready(function(){\n\n});"
                    ),
                  
                )
            );



///////////////////////////////////////---Styling Options-----//////////////////////////////////////////////////////////////////////////

            $this->sections[] = array(
                'icon' => 'el-icon-magic',
                'title' => __('Styling Options', 'redux-framework-demo'),
                'fields' => array(
       
                    array(
                        'id' => 'theme-skin',
                        'type' => 'color',
                        'compiler' => array('body'),
                        'output' => array('.site-title'),
                        'title' => __('Theme Skin', 'redux-framework-demo'),
                        'default' => '#FF0000',
                        'validate' => 'color',
                    ),
                   
                   
                         array(
                        'id'        => 'switch-bg',
                        'type'      => 'switch',
                        'title'     => __('Background', 'redux-framework-demo'),
                        'subtitle'  => __('Enable or disable backgound image or slider.', 'redux-framework-demo'),
                        "default"   => 0,
                        'on'        => 'Enable',
                        'off'       => 'Disable',
                    ),

                        /*
                            array(
                                'id'        => 'body-background',
                                'title'     => __('Background Image', 'redux-framework-demo'),
                                'type'      => 'background',
                                'required'  => array('switch-bg', '=', '0'),
                                'subtitle'  => __('Body background with image, color, etc.', 'redux-framework-demo'),
                            //'default' => '#FFFFFF',
                            ),
                            */
                         array(
                        'id'       => 'opt-gallery',
                        'type'     => 'gallery',
                         'required'  => array('switch-bg', '=', '1'),
                        'title'    => __('Background Slider Gallery', 'redux-framework-demo'),
                        'subtitle' => __('Create a Gallery by selecting existing or uploading new images.', 'redux-framework-demo'),
                    ),
                         array(
                            'id' => 'gallery-speed',
                            'type' => 'slider',
                            'required'  => array('switch-bg', '=', '1'),
                            'title' => __('Transition Speed', 'redux-framework-demo'),
                            'subtitle' => __('Set Backgroud slider speed.', 'redux-framework-demo'),
                            "default" => 6000,
                            "min" => 500,
                            "step" => 500,
                            "max" => 10000,
                            'display_value' => 'text'
                        ),

                    array(
                        'id'       => 'map-skin',
                        'type'     => 'select',
                        'title'    => __('Map Skin', 'redux-framework-demo'),
                        'subtitle' => __('Select a map skin used in events and contact us pages.', 'redux-framework-demo'),
                        // Must provide key => value pairs for select options
                        'options'   => array(
                            'pink'  => 'Pink',
                            'red'   => 'Red',
                            'blue'  => 'Blue',
                            'yellow'=> 'Yellow',
                            'green' => 'Green'
                        ),
                        'default'  => 'pink',
                    ),

           
                )
            );

 

///////////////////////////////////Contact Page/////////////////////////////////////////
            $this->sections[] = array(
                'icon' => 'el-icon-address-book',
                'title' => __('Contact Page', 'redux-framework-demo'),
                'fields' => array(

                         array(  
                                'title' => __('Google Map', 'redux-framework-demo'),
                                "desc"      => "Enter your location",
                                "id"        => "gmap",
                                "std"       => "",
                                
                                "type"      => "text"
                        ),
                       array(  
                                'title' => __('Contact Form 7 ID', 'redux-framework-demo'),
                                "desc"      => "Enter your contact form 7 Id only e.g(490)",
                                "id"        => "contact_form_id",
                                "std"       => "",
                                
                                "type"      => "text"
                        ),


                )
            );


///////////////////////////////////Shop Page/////////////////////////////////////////
            $this->sections[] = array(
                'icon' => 'el-icon-shopping-cart',
                'title' => __('Shop Settings', 'redux-framework-demo'),
                'fields' => array(

                       
                       
                    array(
                        'id' => 'shop-layout',
                        'type' => 'image_select',
                        'title' => __('Shop Layout', 'redux-framework-demo'),
                        'subtitle' => __('No validation can be done on this field type', 'redux-framework-demo'),
                        'desc' => __('This uses some of the built in images, you can use them for layout options.', 'redux-framework-demo'),
                        'options' => array(
                            '1' => array('alt' => '1 Column', 'img' => ReduxFramework::$_url . 'assets/img/1col.png'),
                            'shop9right' => array('alt' => '2 Column Left', 'img' => ReduxFramework::$_url . 'assets/img/2cl.png'),
                            'shop9left' => array('alt' => '2 Column Right', 'img' => ReduxFramework::$_url . 'assets/img/2cr.png'),
                            
                        ), //Must provide key => value(array:title|img) pairs for radio options
                        'default' => '2'
                    ),
                    
                        array(  
                                'title' => __('Shopt Title', 'redux-framework-demo'),
                                "desc"      => "Enter shop page title",
                                "id"        => "shop_page_top_title",
                                "std"       => "Shop",
                                
                                "type"      => "text"
                        ),
                            array(  
                                'title' => __('Shop Subtitle', 'redux-framework-demo'),
                                "desc"      => "Enter shop page subtitle",
                                "id"        => "shop_page_top_subtitle",
                                "std"       => "",
                                
                                "type"      => "text"
                        ),



                )
            );


///////////////////////////////////404 Page/////////////////////////////////////////
            $this->sections[] = array(
                'icon' => 'el-icon-fire',
                'title' => __('404 Page', 'redux-framework-demo'),
                'fields' => array(

                    array(  
                                'title'     => __('404 Top Title', 'redux-framework-demo'),
                                'subtitle'  => __('Enter a top title.', 'redux-framework-demo'),
                                "id"        => "top_404_title",
                                "std"       => "",
                                "type"      => "text"
                        ),
                    
                    array(  
                                'title'     => __('404 Top Subtitle', 'redux-framework-demo'),
                                'subtitle'  => __('Enter a subtitle', 'redux-framework-demo'),
                                "id"        => "top_404_subtitle",
                                "std"       => "",
                                "type"      => "text"
                        ),
                        
                    array(
                                'id'        => 'erro-img',
                                'type'      => 'media',
                                'url'       => true,
                                'title'     => __('404 Image', 'redux-framework-demo'),
                                'subtitle'  => __('Upload your 404 page Image', 'redux-framework-demo'),
                       
                    ),

                       array(  
                                'title'     => __('404 Message', 'redux-framework-demo'),
                                'subtitle'  => __('Enter a 404 Message', 'redux-framework-demo'),
                                "id"        => "msg_404",
                                "std"       => "",
                                "type"      => "textarea"
                        ),
                    
                    array(      
                                'title'     => __('Search Bar ', 'redux-framework-demo'),
                                'subtitle'  => __('Enable or disable search bar.', 'redux-framework-demo'),
                                "id"        => "switch_404_search",
                                "default"   => 1,
                                "on"        => "Enable",
                                "off"       => "Disable",
                                "type"      => "switch"
                        ),
                    



                )
            );

///////////////////////////////////////---Footer Widgets-----//////////////////////////////////////////////////////////////////////////          


            $this->sections[] = array(
                'icon' => 'el-icon-website',
                'title' => __('Footer Settings', 'redux-framework-demo'),
                'fields' => array(

                        array(      
                                'title' => __('Latest Blog Posts ', 'redux-framework-demo'),
                                "desc"      => "Enable or Disable latest blog posts form footer.",
                                "id"        => "switch_footer_blog_post",
                                "default"       => 1,
                                "on"        => "Enable",
                                "off"       => "Disable",
                                "type"      => "switch"
                        ),
                         array(  
                                'title' => __('Blog Posts Title', 'redux-framework-demo'),
                                'subtitle' => __('Enter a blog post section title.', 'redux-framework-demo'),
                                "id"        => "footer_blog_post_title",
                                "std"       => "Latest from blog",
                                "type"      => "text"
                        ),
                    
                        array(
                        'id' => 'widget_warning',
                        'type' => 'info',
                        'style' => 'warning',
                        'title' => __('Note:', 'redux-framework-demo'),
                        'desc' => __('If you enable any of the follwing widget. Wordpress defaut widget area will be disabled.', 'redux-framework-demo')
                    ),

array(   'title' => __('About  Widget', 'redux-framework-demo'),
                        "id"        => "switch_about_widget",
                        "default"       => 0,
                        "on"        => "Enable",
                        "off"       => "Disable",
                        "type"      => "switch"
                ),


                        array(  
                                                'title' => __('About Widget Tite', 'redux-framework-demo'),                                          
                                                "desc"      => "Change the title for about widget.",
                                                "id"        => "feed_bar_about_title",
                                                "std"       => "",
                                                'required'    => array('switch_about_widget', '=', '1'),
                                                "type"      => "text"
                                        ),

                array(
                        'id'        => 'about_widget',
                        'type'      => 'editor',
                        'title' => __('About Widget Description', 'redux-framework-demo'),
                        'required'    => array('switch_about_widget', '=', '1'),
                        'subtitle'  => __('You can use the following shortcodes: [wp-url] [site-url] [theme-url] [login-url] [logout-url] [site-title] [site-tagline] [current-year]', 'redux-framework-demo'),
                        'default'   => 'Powered by Redux Framework.',
                    ),


        

array(   'title' => __('Twitter Widget', 'redux-framework-demo'),
                        "id"        => "switch_twitter_widget",
                        "default"       => 0,
                        "on"        => "Enable",
                        "off"       => "Disable",
                        "type"      => "switch"
                ),


                        array(  
                                                'title' => __('Twitter Widget Tite', 'redux-framework-demo'),                                             
                                                "id"        => "feed_bar_twitter_title",
                                                "std"       => "",
                                                'required'    => array('switch_twitter_widget', '=', '1'),
                                                "type"      => "text"
                                        ),
                        array(  
                                                'title' => __('Twitter ID', 'redux-framework-demo'),
                                                "id"        => "twitter_widget_id",
                                                "std"       => "",
                                                'required'    => array('switch_twitter_widget', '=', '1'),
                                                "type"      => "text"
                                        ),

                   

                    array( 
                          'title' => __('Flicker Widget', 'redux-framework-demo'),
                        "id"        => "switch_flicker_widget",
                        "default"       => 0,
                        "on"        => "Enable",
                        "off"       => "Disable",
                        "type"      => "switch"
                     ),


                            array( 
                                                'title' => __('Flicker Widget Tite', 'redux-framework-demo'),
                                                "id"        => "feed_bar_flicker_title",
                                                "std"       => "Flick Photostream",
                                                 'required'    => array('switch_flicker_widget', '=', '1'),
                                                "type"      => "text"
                                        ),
                            array( 
                                                 'title' => __('Flicker ID', 'redux-framework-demo'),
                                                "id"        => "flicker_widget_id",
                                                "std"       => "",
                                                   'required'    => array('switch_flicker_widget', '=', '1'),
                                                "type"      => "text"
                                        ),
                            array( 
                                                 'title' => __('Flicker Limit', 'redux-framework-demo'),
                                                "desc"      => "Enter the limit of images",
                                                "id"        => "flicker_widget_limit",
                                                "std"       => "",
                                                  'required'    => array('switch_flicker_widget', '=', '1'),
                                                "type"      => "text"
                                        ),

                        
                    array( 
                        'title' => __('Newsletter Widget', 'redux-framework-demo'),
                        "id"        => "switch_newsletter_widget",
                        "default"       => 0,
                        "on"        => "Enable",
                        "off"       => "Disable",
                        "type"      => "switch"
                     ),


                                        array( 
                                                'title' => __('Newsletter Widget Tite', 'redux-framework-demo'),
                                                "desc"      => "Change the title for newsletter widget.",
                                                "id"        => "newsletter_title",
                                                "std"       => "Flick Photostream",
                                                'required'    => array('switch_newsletter_widget', '=', '1'),
                                                "type"      => "text"
                                        ), 
                                        array(
                                                'id' => 'newsletter_form',
                                                'type' => 'ace_editor',
                                                'title' => __('Newsletter Form Code', 'redux-framework-demo'),
                                                'subtitle' => __('Paste your HTML code here.', 'redux-framework-demo'),
                                                'mode' => 'html',
                                                'required'    => array('switch_newsletter_widget', '=', '1'),
                                                'theme' => 'chrome',
                                                'default' => ""
                                            ),
                             




 
                    )
            );

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////



            $this->sections[] = array(
                'title'     => __('Import / Export', 'redux-framework-demo'),
                'desc'      => __('Import and Export your Redux Framework settings from file, text or URL.', 'redux-framework-demo'),
                'icon'      => 'el-icon-refresh',
                'fields'    => array(
                    array(
                        'id'            => 'opt-import-export',
                        'type'          => 'import_export',
                        'title'         => 'Import Export',
                        'subtitle'      => 'Save and restore your Redux options',
                        'full_width'    => false,
                    ),
                ),
            );                     
                    
            
        }

        public function setHelpTabs() {

            // Custom page help tabs, displayed using the help API. Tabs are shown in order of definition.
            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-1',
                'title'     => __('Theme Information 1', 'redux-framework-demo'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
            );

            $this->args['help_tabs'][] = array(
                'id'        => 'redux-help-tab-2',
                'title'     => __('Theme Information 2', 'redux-framework-demo'),
                'content'   => __('<p>This is the tab content, HTML is allowed.</p>', 'redux-framework-demo')
            );

            // Set the help sidebar
            $this->args['help_sidebar'] = __('<p>This is the sidebar content, HTML is allowed.</p>', 'redux-framework-demo');
        }

        /**

          All the possible arguments for Redux.
          For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments

         * */
        public function setArguments() {

            $theme = wp_get_theme(); // For use with some settings. Not necessary.

            $this->args = array(
                // TYPICAL -> Change these values as you need/desire
                'opt_name'          => 'xv_data',            // This is where your data is stored in the database and also becomes your global variable name.
                'display_name'      => $theme->get('Name'),     // Name that appears at the top of your panel
                'display_version'   => $theme->get('Version'),  // Version that appears at the top of your panel
                'menu_type'         => 'menu',                  //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
                'allow_sub_menu'    => true,                    // Show the sections below the admin menu item or not
                'menu_title'        => __('WeRock Options', 'redux-framework-demo'),
                'page_title'        => __('WeRock Options', 'redux-framework-demo'),
                
                // You will need to generate a Google API key to use this feature.
                // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
                'google_api_key' => '', // Must be defined to add google fonts to the typography module
                
                'async_typography'  => false,                    // Use a asynchronous font on the front end or font string
                'admin_bar'         => true,                    // Show the panel pages on the admin bar
                'global_variable'   => '',                      // Set a different name for your global variable other than the opt_name
                'dev_mode'          => false,                    // Show the time the page took to load, etc
                'customizer'        => true,                    // Enable basic customizer support
                
                // OPTIONAL -> Give you extra features
                'page_priority'     => null,                    // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
                'page_parent'       => 'themes.php',            // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
                'page_permissions'  => 'manage_options',        // Permissions needed to access the options panel.
                'menu_icon'         =>  get_template_directory_uri() . '/admin/assets/images/cd.png',                      // Specify a custom URL to an icon
                'last_tab'          => '',                      // Force your panel to always open to a specific tab (by id)
                'page_icon'         => 'icon-themes',           // Icon displayed in the admin panel next to your menu_title
                'page_slug'         => '_options',              // Page slug used to denote the panel
                'save_defaults'     => true,                    // On load save the defaults to DB before user clicks save or not
                'default_show'      => false,                   // If true, shows the default value next to each field that is not the default value.
                'default_mark'      => '',                      // What to print by the field's title if the value shown is default. Suggested: *
                'show_import_export' => true,                   // Shows the Import/Export panel when not used as a field.
                'update_notice'     => true,
                // CAREFUL -> These options are for advanced use only
                'transient_time'    => 60 * MINUTE_IN_SECONDS,
                'output'            => true,                    // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
                'output_tag'        => true,                    // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
                // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.
                
                // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
                'database'              => '', // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
                'system_info'           => false, // REMOVE

                // HINTS
                'hints' => array(
                    'icon'          => 'icon-question-sign',
                    'icon_position' => 'right',
                    'icon_color'    => 'lightgray',
                    'icon_size'     => 'normal',
                    'tip_style'     => array(
                        'color'         => '#fff',
                        'shadow'        => true,
                        'rounded'       => true,
                        'style'         => 'background:#333C4E',
                    ),
                    'tip_position'  => array(
                        'my' => 'top left',
                        'at' => 'bottom right',
                    ),
                    'tip_effect'    => array(
                        'show'          => array(
                            'effect'        => 'slide',
                            'duration'      => '500',
                            'event'         => 'mouseover',
                        ),
                        'hide'      => array(
                            'effect'    => 'slide',
                            'duration'  => '500',
                            'event'     => 'click mouseleave',
                        ),
                    ),
                )
            );


            // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
            $this->args['share_icons'][] = array(
                'url'   => 'https://www.facebook.com/xvelopers',
                'title' => 'Like us on Facebook',
                'icon'  => 'el-icon-facebook'
            );
            $this->args['share_icons'][] = array(
                'url'    => 'http://twitter.com/xvelopers',
                'title'  => 'Follow us on Twitter',
                'icon'   => 'el-icon-twitter'
            );
           

            // Panel Intro text -> before the form
            if (!isset($this->args['global_variable']) || $this->args['global_variable'] !== false) {
                if (!empty($this->args['global_variable'])) {
                    $v = $this->args['global_variable'];
                } else {
                    $v = str_replace('-', '_', $this->args['opt_name']);
                }
                $this->args['intro_text'] = sprintf(__('<p><strong>For free help and support kindly contact us via our <a href="http://xvelopers.com/support">Support Forums</a> and dont forget to rate our theme at themeforest.</p>', 'redux-framework-demo'), $v);
            } else {
                $this->args['intro_text'] = __('<p>This text is displayed above the options panel. It isn\'t required, but more info is always better! The intro_text field accepts all HTML.</p>', 'redux-framework-demo');
            }

        }

    }
    
    global $reduxConfig;
    $reduxConfig = new Redux_Framework_sample_config();
}

/**
  Custom function for the callback referenced above
 */
if (!function_exists('redux_my_custom_field')):
    function redux_my_custom_field($field, $value) {
        print_r($field);
        echo '<br/>';
        print_r($value);
    }
endif;

/**
  Custom function for the callback validation referenced above
 * */
if (!function_exists('redux_validate_callback_function')):
    function redux_validate_callback_function($field, $value, $existing_value) {
        $error = false;
        $value = 'just testing';

        /*
          do your validation

          if(something) {
            $value = $value;
          } elseif(something else) {
            $error = true;
            $value = $existing_value;
            $field['msg'] = 'your custom error message';
          }
         */

        $return['value'] = $value;
        if ($error == true) {
            $return['error'] = $field;
        }
        return $return;
    }
endif;
