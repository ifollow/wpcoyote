<?php
///////////////////////////////////menu////////////////////////////////
if( class_exists( 'IG_Pb_Init' ) ) {
function my_custom_post_menu() {
    $labels = array(
        'name'               => _x( 'Menu', 'Menu','werock' ),
        'singular_name'      => _x( 'Menu', 'Menu','werock' ),
        'add_new'            => _x( 'Add New', 'Menu','werock' ),
        'add_new_item'       => __( 'Add New Menu Item','werock'),
        'edit_item'          => __( 'Edit Menu','werock' ),
        'new_item'           => __( 'New Menu Item','werock' ),
        'all_items'          => __( 'All Menus','werock' ),
        'view_item'          => __( 'View Menus','werock' ),
        'search_items'       => __( 'Search Menu Member','werock' ),
        'not_found'          => __( 'No Menu found','werock' ),
        'not_found_in_trash' => __( 'No Menu found in the Trash','werock' ), 
        'parent_item_colon'  => '',
        'menu_name'          => 'Mega Menu'
    );
    $args = array(
        'labels'        => $labels,
        'hierarchical' => true,
        'description'   => 'Holds our products and product specific data',
        'public'        => false,
        'menu_position' => 10,
        'supports'      => array( 'title','editor','page-attributes'),
        'has_archive'   => false,
        'menu_icon' =>  get_template_directory_uri() . '/admin/assets/images/cd.png',
        'show_ui' => true,
    );
    register_post_type( 'Menu', $args ); 
}
add_action( 'init', 'my_custom_post_menu' );
}
///////////////////////////////////playlists////////////////////////////////
function my_custom_post_Playlist() {
    $labels = array(
        'name'               => _x( 'Playlist', 'Playlist','werock' ),
        'singular_name'      => _x( 'Playlist', 'Playlist','werock'  ),
        'add_new'            => _x( 'Add New', 'Playlist','werock'  ),
        'add_new_item'       => __( 'Add New Playlist','werock' ),
        'edit_item'          => __( 'Edit Playlist','werock' ),
        'new_item'           => __( 'New Playlist','werock' ),
        'all_items'          => __( 'All Playlist','werock' ),
        'view_item'          => __( 'View Playlist','werock' ),
        'search_items'       => __( 'Search Playlist Member','werock' ),
        'not_found'          => __( 'No Playlist found','werock' ),
        'not_found_in_trash' => __( 'No Playlist found in the Trash','werock' ), 
        'parent_item_colon'  => '',
        'menu_name'          => 'Playlist'
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'Holds our products and product specific data',
        'public'        => true,
        'menu_position' => 11,
        'supports'      => array( 'title'),
       'has_archive'   => false,
        'menu_icon' =>  get_template_directory_uri() . '/admin/assets/images/cd.png',
    );
    register_post_type( 'Playlist', $args ); 
}
add_action( 'init', 'my_custom_post_Playlist' );
///////////////////////////////////newss////////////////////////////////
function my_custom_post_News() {
    $labels = array(
        'name'               => _x( 'News', 'News','werock' ),
        'singular_name'      => _x( 'News', 'News','werock'  ),
        'add_new'            => _x( 'Add New', 'News','werock'  ),
        'add_new_item'       => __( 'Add New News','werock' ),
        'edit_item'          => __( 'Edit News','werock' ),
        'new_item'           => __( 'New News','werock' ),
        'all_items'          => __( 'All News','werock' ),
        'view_item'          => __( 'View News','werock' ),
        'search_items'       => __( 'Search News Member','werock' ),
        'not_found'          => __( 'No News found','werock' ),
        'not_found_in_trash' => __( 'No News found in the Trash','werock' ), 
        'parent_item_colon'  => '',
        'menu_name'          => 'News'
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'Holds our products and product specific data',
        'public'        => true,
        'menu_position' => 11,
        'supports'      => array( 'title','editor','thumbnail','comments' ),
       'has_archive'   => false,
        'menu_icon' =>  get_template_directory_uri() . '/admin/assets/images/cd.png',
    );
    register_post_type( 'News', $args ); 
}
add_action( 'init', 'my_custom_post_News' );

///////////////////////////////////videos////////////////////////////////
function my_custom_post_videos() {
    $labels = array(
        'name'               => _x( 'Videos', 'Videos','werock'  ),
        'singular_name'      => _x( 'Videos', 'Videos','werock'  ),
        'add_new'            => _x( 'Add New', 'Videos','werock'  ),
        'add_new_item'       => __( 'Add New Videos','werock' ),
        'edit_item'          => __( 'Edit Videos','werock' ),
        'new_item'           => __( 'New Videos','werock' ),
        'all_items'          => __( 'All Videos','werock' ),
        'view_item'          => __( 'View Videos','werock' ),
        'search_items'       => __( 'Search Videos Member','werock' ),
        'not_found'          => __( 'No Videos found','werock' ),
        'not_found_in_trash' => __( 'No Videos found in the Trash','werock' ), 
        'parent_item_colon'  => '',
        'menu_name'          => 'Videos'
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'Holds our products and product specific data',
        'public'        => true,
        'menu_position' => 12,
        'supports'      => array( 'title','editor','thumbnail'),
        'has_archive'   => false,
        'menu_icon' =>  get_template_directory_uri() . '/admin/assets/images/cd.png',
    );
    register_post_type( 'Videos', $args ); 
}
add_action( 'init', 'my_custom_post_videos' );

/////////////////////////////////////GALLERY CUSTOM POST/////////////////////////////////////
function my_custom_post_gallery() {
    $labels = array(
        'name'               => _x( 'Gallery', 'Items','werock'  ),
        'singular_name'      => _x( 'Gallery', 'Item','werock'  ),
        'add_new'            => _x( 'Add New', 'Item' ,'werock' ),
        'add_new_item'       => __( 'Add New Item','werock' ),
        'edit_item'          => __( 'Edit Item','werock' ),
        'new_item'           => __( 'New Item','werock' ),
        'all_items'          => __( 'All Items','werock' ),
        'view_item'          => __( 'View Item','werock' ),
        'search_items'       => __( 'Search Items','werock' ),
        'not_found'          => __( 'No Items found','werock' ),
        'not_found_in_trash' => __( 'No Items found in the Trash','werock' ), 
        'parent_item_colon'  => '',
        'menu_name'          => 'Gallery'
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'Holds our products and product specific data',
        'public'        => true,
        'menu_position' => 13,
        'supports'      => array( 'title', 'thumbnail'),
        'has_archive'   => false,
         'menu_icon' =>  get_template_directory_uri() . '/admin/assets/images/cd.png',
        // 'taxonomies' => array('post_tag') ,
    );
    register_post_type( 'gallery', $args ); 
         $set = get_option('gallery');
    if ($set !== true){
        flush_rewrite_rules(false);
        update_option('gallery',true);
    }
}
add_action( 'init', 'my_custom_post_gallery' );
function my_taxonomies_gallery_category() {
    $labels = array(
        'name'              => _x( 'Items Categories', 'Categories','werock'  ),
        'singular_name'     => _x( 'Product Type', 'Categories','werock'  ),
        'search_items'      => __( 'Search Gallery Categories','werock' ),
        'all_items'         => __( 'All Gallery Categories','werock' ),
        'parent_item'       => __( 'Parent Gallery Type','werock' ),
        'parent_item_colon' => __( 'Parent Gallery Type:','werock' ),
        'edit_item'         => __( 'Edit Gallery Type','werock' ), 
        'update_item'       => __( 'Update Gallery Type','werock' ),
        'add_new_item'      => __( 'Add New Gallery Type','werock' ),
        'new_item_name'     => __( 'New Gallery Type','werock' ),
        'menu_name'         => __( 'Categories','werock' ),
    );
    $args = array(
        'labels' => $labels,
        'has_archive'   => false,
    );
    register_taxonomy( 'gallery_category', 'gallery', $args );
 
}
add_action( 'init', 'my_taxonomies_gallery_category', 0 );




/////////////////////////////////////ALBUM CUSTOM POST/////////////////////////////////////
function my_custom_post_album() {
    $labels = array(
        'name'               => _x( 'Album', 'Items','werock'  ),
        'singular_name'      => _x( 'Album', 'Item','werock'  ),
        'add_new'            => _x( 'Add New', 'Item' ,'werock' ),
        'add_new_item'       => __( 'Add New Item','werock' ),
        'edit_item'          => __( 'Edit Item','werock' ),
        'new_item'           => __( 'New Item','werock' ),
        'all_items'          => __( 'All Items','werock' ),
        'view_item'          => __( 'View Item','werock' ),
        'search_items'       => __( 'Search Items','werock' ),
        'not_found'          => __( 'No Items found','werock' ),
        'not_found_in_trash' => __( 'No Items found in the Trash','werock' ), 
        'parent_item_colon'  => '',
        'menu_name'          => 'Album'
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'Holds our products and product specific data',
        'public'        => true,
        'menu_position' => 13,
        'supports'      => array( 'title', 'thumbnail','editor' ),
        'has_archive'   => false,
       
         'menu_icon' =>  get_template_directory_uri() . '/admin/assets/images/cd.png',
        // 'taxonomies' => array('post_tag') ,
    );
    register_post_type( 'album', $args ); 
}
add_action( 'init', 'my_custom_post_album' );



///////////////////ARTIST CUSTOM POST TYPE//////////////////////////////////////////////
function my_custom_post_Artist() {
    $labels = array(
        'name'               => _x( 'Artist', 'Artist','werock' ),
        'singular_name'      => _x( 'Artist', 'Artist','werock'  ),
        'add_new'            => _x( 'Add New', 'Artist','werock'  ),
        'add_new_item'       => __( 'Add New Artist','werock' ),
        'edit_item'          => __( 'Edit Artist','werock' ),
        'new_item'           => __( 'New Artist','werock' ),
        'all_items'          => __( 'All Artist','werock' ),
        'view_item'          => __( 'View Artist','werock' ),
        'search_items'       => __( 'Search Artist Member','werock' ),
        'not_found'          => __( 'No Member found','werock' ),
        'not_found_in_trash' => __( 'No Artist Member found in the Trash','werock' ), 
        'parent_item_colon'  => '',
        'menu_name'          => 'Artist'
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'Holds our products and product specific data',
        'public'        => true,
        'menu_position' => 14,
        'supports'      => array( 'title','editor', 'thumbnail' ),
        'has_archive'   => false,
        'rewrite' => array('slug' => 'artists-posts','with_front' => false),
          'menu_icon' =>  get_template_directory_uri() . '/admin/assets/images/cd.png',
    );
    register_post_type( 'Artist', $args ); 
}
add_action( 'init', 'my_custom_post_Artist' );




///////////////////////////////////Events////////////////////////////////
function my_custom_post_Event() {
    $labels = array(
        'name'               => _x( 'Event', 'Event','werock'  ),
        'singular_name'      => _x( 'Event', 'Event','werock'  ),
        'add_new'            => _x( 'Add New', 'Event','werock'  ),
        'add_new_item'       => __( 'Add New Event','werock' ),
        'edit_item'          => __( 'Edit Event','werock' ),
        'new_item'           => __( 'New Event','werock' ),
        'all_items'          => __( 'All Events','werock' ),
        'view_item'          => __( 'View Events','werock' ),
        'search_items'       => __( 'Search Event Member','werock' ),
        'not_found'          => __( 'No Event found','werock' ),
        'not_found_in_trash' => __( 'No Event found in the Trash','werock' ), 
        'parent_item_colon'  => '',
        'menu_name'          => 'Events'
    );
    $args = array(
        'labels'        => $labels,
        'description'   => 'Holds our products and product specific data',
        'public'        => true,
        'publicly_queryable' => true,
        'menu_position' => 15,

        'supports'      => array( 'title','thumbnail','editor' ),
        'has_archive'   => true,
        'rewrite' => array('slug' => 'event-posts','with_front' => false),
        'menu_icon' =>  get_template_directory_uri() . '/admin/assets/images/cd.png',
    );

    register_post_type( 'event', $args ); 
    $set = get_option('event');
    if ($set !== true){
        flush_rewrite_rules(false);
        update_option('event',true);
    }
}
add_action( 'init', 'my_custom_post_Event' );

?>