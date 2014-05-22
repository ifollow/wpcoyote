<?php

add_theme_support( 'woocommerce' );

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {


    //DISABLE WOOCOMMERCE PRETTY PHOTO SCRIPTS
    add_action( 'wp_print_scripts', 'my_deregister_javascript', 100 );

    function my_deregister_javascript() {
        wp_deregister_script( 'prettyPhoto' );
        wp_deregister_script( 'prettyPhoto-init' );
    }

    //DISABLE WOOCOMMERCE PRETTY PHOTO STYLE
    add_action( 'wp_print_styles', 'my_deregister_styles', 100 );

    function my_deregister_styles() {
        wp_deregister_style( 'woocommerce_prettyPhoto_css' );
    }

    

//Disable the default stylesheet for woocommerce
add_filter( 'woocommerce_enqueue_styles', '__return_false' );

    function wp_enqueue_woocommerce_style(){
        
        wp_register_style( 'woocommerce', get_template_directory_uri() . '/assets/css/woo.css' );
        
        if ( class_exists( 'woocommerce' ) ) {
            
             wp_enqueue_style( 'woocommerce' );
        
        }
    }
    add_action( 'wp_enqueue_scripts', 'wp_enqueue_woocommerce_style' );


//this line removes the existing Woocommerce codes

/**
 * Woocommerce
 */
add_theme_support( 'woocommerce' );

  
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
    
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20, 0);
remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
 //add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 9 );

// Ensure cart contents update when products are added to the cart via AJAX (place the following in functions.php)



add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

function woocommerce_header_add_to_cart_fragment( $fragments ) {
    global $woocommerce;
    
    ob_start();
    
    ?>
    <a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?> - <?php echo $woocommerce->cart->get_cart_total(); ?></a>
    <?php
    
    $fragments['a.cart-contents'] = ob_get_clean();
    
    return $fragments;   
}
    
     
/**
 * Register widgetized area and update sidebar with default widgets.
 */
function xv_woo_shop_widgets_init() {


    register_sidebar( array(
        'name'          => __( 'Shop Sidebar', 'twentyone' ),
        'id'            => 'sidebar-2',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h1 class="widget-title">',
        'after_title'   => '</h1>',
    ) );


            
}
add_action( 'widgets_init', 'xv_woo_shop_widgets_init' );

}