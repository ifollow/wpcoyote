<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
?>
		
		<?php if(isset($smof_data['blog-layout']) &&  $smof_data['blog-layout']  == 'blog9left'){
			echo '</div>';
			echo '<div class="col-lg-3 col-md-3 col-sm-12">';
			get_sidebar();
			echo '</div>';
		 }elseif(isset($smof_data['blog-layout']) &&  $smof_data['blog-layout']  == 'blog9right'){
		 	echo '</div>';
		 } ?>
        </div> <!--container-->


  	</div>
    
    	<div class="col-lg-3 col-md-3 col-sm-12">
			<?php  dynamic_sidebar( 'shop-footer-widget1' ) ?>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-12">
			<?php  dynamic_sidebar( 'shop-footer-widget2' ) ?>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-12">
			<?php  dynamic_sidebar( 'shop-footer-widget3' ) ?>
		</div>
		<div class="col-lg-3 col-md-3 col-sm-12">
			<?php  dynamic_sidebar( 'shop-footer-widget4' ) ?>
		</div>
	




  </div>
</section>