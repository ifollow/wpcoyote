<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $product, $woocommerce_loop, $xv_data;;
$attachment_ids = $product->get_gallery_attachment_ids();
// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;

// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 4 );

// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;

// Increase loop count
$woocommerce_loop['loop']++;

// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first store-item';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last store-item';
?>

 	<?php 
 		$classes[] = 'store-item';
 		$col = '';
            if(isset($xv_data['shop-layout']) &&  $xv_data['shop-layout']  == 'shop9left'){

 				$col = "col-lg-4 col-md-4 col-sm-4 col-xs-12";
 		
 		    }elseif(isset($xv_data['shop-layout']) &&  $xv_data['shop-layout']  == 'shop9right'){
 	
		         $col = "col-lg-4 col-md-4 col-sm-4 col-xs-12";
 	      	
 	      	}else{
 	      		
 	      		$col= "col-lg-3 col-md-3 col-sm-4 col-xs-12";
 	      	} 
 	?>
<?php $classes[] = $col; ?>
<div <?php post_class( $classes ); ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	

		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			//do_action( 'woocommerce_before_shop_loop_item_title' );
		?>
      <div class="product-image">
         <div class="front-image">
		 	<?php echo get_the_post_thumbnail( $post->ID, 'shop_catalog') ?>
         </div>
         
          
      </div><!-- end product-image -->


		<a href="<?php the_permalink(); ?>" class="xv_product_title"><h3><?php the_title(); ?></h3></a>

		<?php //echo $product->get_categories( ', '); ?>

		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>

	
	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

</div>