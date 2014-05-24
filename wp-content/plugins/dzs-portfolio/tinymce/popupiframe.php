<?php
require_once('get_wp.php');
define('DONOTCACHEPAGE', true);
define('DONOTMINIFY', true);
//<script src="<?php echo site_url(); "></script>
wp_enqueue_script('jquery');
$taxonomy_main = 'categoryportfolio';
$terms=get_terms( $taxonomy_main, 'orderby=count&hide_empty=0' );
//print_r($dzsp);
?>
<!doctype html>
<html lang="en">
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
        <meta charset="utf-8" />
        <title>DZS ZoomFolio Shortcode Generator</title>
        
        <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
			<![endif]-->
        <link rel="stylesheet" type="text/css" href="<?php echo $dzsp->thepath; ?>tinymce/popup.css"/>
        <script src="<?php echo $dzsp->thepath; ?>tinymce/popup.js"></script>
        <script>
            /*
             * 
             */
            //console.log(window.tinyMCE)
	if(window.tinyMCE && window.wptinyMCE==undefined){
            window.wptinyMCE = window.tinyMCE;
        }
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
            
            var mainsettings = {
                'sampledata_installed' : <?php if(get_option('dzsp_demo_data')==''){ echo 'false'; }else{ echo 'true'; }; ?>
                ,'sampledata_cats' : "<?php $demo_data = (get_option('dzsp_demo_data')); $i=0; if(isset($demo_data['cats']) && is_array($demo_data['cats'])){  foreach($demo_data['cats'] as $cat){ if($i>0){ echo ","; }  echo $cat; ++$i; } }; ?>"
                ,'categoryportfolio_terms' : "<?php $i=0; foreach($terms as $term){ if($i>0){ echo ','; } echo $term->term_id; ++$i; }; echo ';'; $i=0; foreach($terms as $term){ if($i>0){ echo ','; } echo $term->name; ++$i; }; ?>"
            };
var wordCountL10n = {"type":"w"};
var thickboxL10n = {"next":"Next >","prev":"< Prev","image":"Image","of":"of","close":"Close","noiframes":"This feature requires inline frames. You have iframes disabled or your browser does not support them.","loadingAnimation":"http:\/\/localhost\/wpmu\/eos\/wp-includes\/js\/thickbox\/loadingAnimation.gif","closeImage":"http:\/\/localhost\/wpmu\/eos\/wp-includes\/js\/thickbox\/tb-close.png"};
</script>
        <script src="<?php echo $dzsp->thepath; ?>tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo $dzsp->thepath; ?>plugins/dzs-pagebuilder/front-pagebuilder.css"/>
        <?php //wp_head(); ?>
        <script src="<?php echo site_url(); ?>/wp-admin/load-scripts.php?c=1&amp;load=jquery-ui-core,jquery-ui-widget,jquery-ui-mouse,jquery-ui-sortable"></script>
    
    </head>
    <body class="dzsp-admin">
        <div class="maincon">
            <div class='switcher-simple-example'>
                <a class="active" href='#'>Generate Custom</a>
                <a class="" href='#'>Generate Example</a>
            </div>
            <div class='con-generate-custom'>
            <form class="settings" id="mainsettings" method="POST">
                <h3 class="maintitle"><?php echo __('Portfolio Settings','dzsp'); ?></h3>
                
                <button class="ui-button insert_tests"><?php echo __('Insert Portfolio','dzsp'); ?></button>
                <div class="dzspb_lay_con" style="margin:0;">
                <div class="dzspb_layb_one_half" style="border-right: 1px dashed rgba(0,0,0,0.1);">
                <!--
    <div class="setting">
        <div class="setting-label">Width</div>
        <div class="setting-input type-input">
        <input type="text" name="settings_width" value="300"/>
        </div>
    </div>  
    <div class="setting">
        <div class="setting-label">Height</div>
        <div class="setting-input type-input">
        <input type="text" name="settings_height" value=""/>
        </div>
    </div>-->
                <div class="settings-auxcon">
        <h4><?php echo __('General Options', 'dzsp'); ?></h4>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Mode','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="settings_mode">
                <option>masonry</option>
                <option>advancedscroller</option>
                <option>simple</option>
                <option>wall</option>
            </select>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Skin','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="skin">
                <option>skin-default</option>
                <option>skin-clean</option>
                <option>skin-blog</option>
                <option>skin-accordion</option>
                <option>skin-boxed</option>
                <option>skin-corporate</option>
                <option>skin-timeline</option>
                <option>skin-nebula</option>
                <option>skin-aura</option>
                <option>skin-vintage</option>
                <option>skin-choice</option>
                <option>skin-zero</option>
            </select>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Layout','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="settings_specialgrid">
                <option>none</option>
                <option>special-grid-1</option>
                <option>special-grid-2</option>
                <option>special-grid-3</option>
                <option>special-grid-4</option>
                <option>special-grid-5</option>
                <option>special-grid-6</option>
                <option>special-grid-one-third-with-margin</option>
                <option>special-grid-one-half-with-margin</option>
                <option>special-grid-one-full-with-margin</option>
                <option>special-grid-one-fifth-no-margin</option>
            </select>
            <div class="sidenote"><?php echo __('select a special grid like special-grid-1 where elments are always justified no matter screen size','dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Post Type','dzsp'); ?></div>
            <select class="setting-input type-select styleme changer-posttype" name="settings_posttype">
                <option>default</option>
                <option>post</option>
            </select>
            <div class="sidenote"><?php echo __('select a post type - leave default for the default "Portfolio Items" custom post type - or if you want to parse posts select post for example','dzsp'); ?></div>
        </div>
                </div>
                <div class="settings-auxcon dzslayb_expanded">
        <h4><?php echo __('Sizing Options', 'dzsp'); ?></h4>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Item Width','dzsp'); ?></div>
            <input class="setting-input type-input" type="text" name="design_item_width" value="280"/>
            <div class="sidenote"><?php echo __('percent width is acceptable','dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Item Height','dzsp'); ?></div>
            <input class="setting-input type-input" type="text" name="design_item_height" value=""/>
            <div class="sidenote"><?php echo __('leave blank for auto width','dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Thumb Width','dzsp'); ?></div>
            <input class="setting-input type-input" type="text" name="design_thumbw" value=""/>
            <div class="sidenote"><?php echo __('leave blank for default - 100% of the item width','dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Thumb Height','dzsp'); ?></div>
            <input class="setting-input type-input" type="text" name="design_thumbh" value=""/>
            <div class="sidenote"><?php echo __('leave blank for default - will cover the size of the image ( or the size of the item on some skins ) - values like "2/3" ( of width )  are accepted or "proportional" to just calculate for each item individually','dzsp'); ?></div>
        </div>
                </div>
                <div class="settings-auxcon">
        <h4><?php echo __('Misc Options', 'dzsp'); ?></h4>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Order By','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="settings_orderby">
                <option>date</option>
                <option>title</option>
                <option>rand</option>
                <option>meta order</option>
            </select>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Sort','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="sort_order">
                <option>ASC</option>
                <option>DESC</option>
            </select>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Preload All Elements','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="settings_preloadall">
                <option>off</option>
                <option>on</option>
            </select>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Background','dzsp'); ?></div>
            <input class="setting-input type-input" type="text" name="bgcolor" value="transparent"/>
            <div class="sidenote"><?php echo __('you can have a color for background ','dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Hide Categories','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="settings_disablecats">
                <option>off</option>
                <option>on</option>
            </select>
            <div class="sidenote"><?php echo __('categories only work in <strong>masonry</strong> mode','dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Categories Display','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="design_categories_style">
                <option>normal</option>
                <option>dropdown</option>
            </select>
            <div class="sidenote"><?php echo __('categories display as normal or a dropown','dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Disable Item Meta','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="disable_itemmeta">
                <option>off</option>
                <option>on</option>
            </select>
            <div class="sidenote"><?php echo __('disable title and description ( for a category mode for example ) ','dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Show Layout Chooser','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="settings_specialgrid_chooser_enabled">
                <option>off</option>
                <option>on</option>
            </select>
            <div class="sidenote"><?php echo __('display 2 boxes for changing the layout ','dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Make All Big Media Part of the Same Gallery ?','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="settings_biggalleryall">
                <option>off</option>
                <option>on</option>
            </select>
            <div class="sidenote"><?php echo __('you can set a gallery on each Portfolio Item individually, but if you want all the items
                to be part of the same gallery, you can choose this to ON','dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Categories Position','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="design_categories_pos">
                <option>top</option>
                <option>bottom</option>
            </select>
            <div class="sidenote"><?php echo __('categories only work in <strong>masonry</strong> mode','dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Page Content Position','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="design_pageContent_pos">
                <option>top</option>
                <option>bottom</option>
            </select>
            <div class="sidenote"><?php echo __('page content only works in <strong>skin-clean</strong> mode','dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Items to show','dzsp'); ?></div>
            <input class="setting-input type-input" type="text" name="posts_per_page" value=""/>
            <div class="sidenote"><?php echo __('Leave blank to show all items. ','dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Endless Scrolling','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="settings_ajax">
                <option>off</option>
                <option>on</option>
            </select>
            <div class="sidenote"><?php echo __('if you want endless scrollins, you must set how many items would you like to show on every user load in the <strong>Items to show</strong> field','dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Place Preloader Bottom','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="design_preloader_bottom">
                <option>off</option>
                <option>on</option>
            </select>
            <div class="sidenote"><?php echo __('place the preloader at the absolute bottom. useful for endless scrolling because default is that the preloder is centered...','dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Hide <strong>All</strong> Category Button','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="settings_hide_category_all">
                <option>off</option>
                <option>on</option>
            </select>
            <div class="sidenote"><?php echo __('hide the button that triggers all the items from all the categories','dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Categories as Links','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="settings_uselinksforcategories">
                <option>off</option>
                <option>on</option>
            </select>
            <div class="sidenote"><?php echo __('categories will show as links ','dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Categories as Links - enable HTML5 History API','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="settings_uselinksforcategories_enablehistoryapi">
                <option>off</option>
                <option>on</option>
            </select>
            <div class="sidenote"><?php echo __('clicking a category changes the link to point to that category ','dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Endless Scrolling Method','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="settings_ajax_loadmoremethod">
                <option>button</option>
                <option>scroll</option>
                <option>pages</option>
            </select>
            <div class="sidenote"><?php echo __('choose wheter or not the items should load on scroll or on the press of a bottom button','dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Fullscreen','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="fullscreen">
                <option>off</option>
                <option>on</option>
            </select>
            <div class="sidenote"><?php echo __('the portfolio can appear fullscreen with a close button','dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Lightbox Library','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="settings_lightboxlibrary">
                <option>zoombox</option>
                <option>prettyphoto</option>
            </select>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Categories', 'dzsp'); ?></div>
            <div class='categoryportfolio-con'>
                    <?php 
foreach ($terms as $term ) {
    //print_r($term);
  echo '<input type="checkbox" name="categoryportfolio" value="'.$term->term_id.'" /> '. $term->name. '<br/>';
}
?>
            </div>
            <div class="sidenote"><?php echo __('categories only work in <strong>masonry</strong> or <strong>simple</strong> mode; these are categories for the portfolio and wall mode, for the normal post type you have to input the categories id yourself ( see docs in readme/ folder )', 'dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Default Category', 'dzsp'); ?></div>
            <div class='defaultcategory-con'>
                    <?php 
$terms=get_terms( $taxonomy_main, 'orderby=count&hide_empty=0' );
foreach ($terms as $term ) {
    //print_r($term);
  echo '<input type="radio" name="defaultcategory" value="'.$term->term_id.'" /> '. $term->name. '<br/>';
}
?>
        </div>
            <div class="sidenote"><?php echo __('You can choose a default category at start', 'dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Extra Classes', 'dzsp'); ?></div>
            <input class="setting-input type-input" name="settings_extraclasses"/>
            <div class="sidenote"><?php echo __('some extra classes to be added to the portfolio container - ie. <strong>delay-effects</strong> <strong>filter-grayscale</strong>', 'dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Custom WPQuery Arguments', 'dzsp'); ?></div>
            <input class="setting-input type-input" name="settings_wpqargs"/>
            <div class="sidenote"><?php echo __('advanced arguments to the query - like post_type=post or posts_per_page=4 or combine them post_type=post&amp;posts_per_age=4', 'dzsp'); ?></div>
        </div>
                <h3><?php echo __('Wall Settings', 'dzsp'); ?></h3>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Wall Items Per Row', 'dzsp'); ?></div>
            <input class="setting-input type-input" name="wall_settings_thumbs_per_row"/>
            <div class="sidenote"><?php echo __('only for the wall mode', 'dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Wall Items Spacing', 'dzsp'); ?></div>
            <input class="setting-input type-input" name="wall_thumb_space"/>
            <div class="sidenote"><?php echo __('the spacing between wall elements', 'dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Masonry Mode','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="settings_mode_masonry_layout">
                <option>masonry</option>
                <option>fitRows</option>
                <option>straightAcross</option>
            </select>
            <div class="sidenote"><?php echo __('only when mode is set to <strong>masonry</strong>','dzsp'); ?></div>
        
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Cover Full Window Height','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="design_total_height_full">
                <option>off</option>
                <option>on</option>
            </select>
            <div class="sidenote"><?php echo __('set the height of the portfolio to cover full height','dzsp'); ?></div>
        </div>
        <div class="setting type_any">
            <div class="setting-label"><?php echo __('Set Items on Center','dzsp'); ?></div>
            <select class="setting-input type-select styleme" name="settings_mode_masonry_layout_straightacross_setitemsoncenter">
                <option>off</option>
                <option>on</option>
            </select>
            <div class="sidenote"><?php echo __('only when mode is set to <strong>masonry</strong> and <strong>Masonry Mode</strong> is set to <strong>straightacross</strong> / the items will be vertically centered if set to <strong>on</strong>','dzsp'); ?></div>
        </div>
                </div>
                <button class="ui-button insert_tests"><?php echo __('Insert Portfolio', 'dzsp'); ?></button>
                <br/><br/>
            
            </div>
                    <div class="dzspb_layb_one_half">
                        <div class="preview-con">
                            <h4>Preview <span style="opacity:0.5; font-size: 10px;">/ <span class="btn-refresh-preview">Refresh</span></span></h4>
                            <div class="preview-inner"></div>
                        </div>
                        
                    </div>
            <div class="clear"></div>
                </div>
            </div>
            
            <div class="con-generate-example" style="display: none;">
                
                <h3><?php echo __('Generate Example', 'dzsp'); ?></h3>
                <button class='button-secondary btn-install-demo-data'><?php echo __('Install Sample Data', 'dzsp'); ?></button>
                <div class="sidenote"><?php echo __('examples work best with sample data, but you can use your own portfolio items too','dzsp'); ?></div>
                <div class="dzspb_layb_layout">
                    <div class="dzspb_layb_one_half">
                        <img id='example-fig1' title="setup a demo ZoomFolio to show the default skin with some portfolio items - if sample data is installed, then it will show those " class="fig-img fullwidth" src='img/e1.png'/>
                    </div>
                    <div class="dzspb_layb_one_half">
                        <img id='example-fig2' title="setup a demo ZoomFolio to show your latest blog posts " class="fig-img fullwidth" src='img/e2.png'/>
                    </div>
                    <div class="dzspb_layb_one_half">
                        <img id='example-fig3' title="setup a demo ZoomFolio for skin aura " class="fig-img fullwidth" src='img/e3.png'/>
                    </div>
                    <div class="dzspb_layb_one_half">
                        <img id='example-fig_exampletestimonials' title="setup a demo ZoomFolio for testimonials " class="fig-img fullwidth" src='img/e4.png'/>
                    </div>
                </div>
            <div class="clear"></div>
            </div>
        </div>
        <div class="testoutput"></div>
        <script>
        
        </script>
        <!--
        <script src="<?php echo site_url(); ?>/wp-admin/js/word-count.js"></script>
        <script src="<?php echo site_url(); ?>/wp-admin/js/utils.js"></script>
        <script src="<?php echo site_url(); ?>/wp-admin/js/editor.js"></script>
<script type='text/javascript' src='<?php echo site_url(); ?>/wp-includes/js/thickbox/thickbox.js?ver=3.1-20111117'></script>
<script type='text/javascript' src='<?php echo site_url(); ?>/wp-admin/js/media-upload.js?ver=3.4.1'></script>
        -->
        
<script type='text/javascript' src='<?php echo $dzsp->thepath; ?>/dzsportfolio/jquery.isotope.min.js'></script>
<script type='text/javascript' src='<?php echo $dzsp->thepath; ?>/dzsportfolio/dzsportfolio.js'></script>
<link rel="stylesheet" href='<?php echo $dzsp->thepath; ?>/dzsportfolio/dzsportfolio.css'>
<script type='text/javascript' src='<?php echo $dzsp->thepath; ?>/advancedscroller/plugin.js'></script>
<link rel="stylesheet" href='<?php echo $dzsp->thepath; ?>/advancedscroller/plugin.css'>
        </body>
</html>