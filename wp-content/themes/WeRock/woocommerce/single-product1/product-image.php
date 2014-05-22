<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $post, $woocommerce, $product, $smof_data; 

?>
	<?php 
 		$col = '';
            if(isset($smof_data['shop-layout']) &&  $smof_data['shop-layout']  == 'shop9left'){

 				echo '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">';
 		
 		    }elseif(isset($smof_data['shop-layout']) &&  $smof_data['shop-layout']  == 'shop9right'){
 	
		        
				echo '<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">';
 	      	
 	      	}else{
 	      		
 	      		echo '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">';
 	      	} 
 	?>

	<?php
		if ( has_post_thumbnail() ) {

			$image_title 		= esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_link  		= wp_get_attachment_url( get_post_thumbnail_id() );
			$image       		= get_the_post_thumbnail( $post->ID, apply_filters( ), array(
				'title' => $image_title
				) );
			$attachment_count   = count( $product->get_gallery_attachment_ids() );

			if ( $attachment_count > 0 ) {
				$gallery = '[product-gallery]';
			} else {
				$gallery = '';
			}

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s"  rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_title, $image ), $post->ID );

		} else {

			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', woocommerce_placeholder_img_src() ), $post->ID );

		}
	?>

	<?php do_action( 'woocommerce_product_thumbnails' ); ?>

</div>
