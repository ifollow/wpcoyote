<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
?>
		<?php global $smof_data; //fetch options stored in $smof_data ?>


    <?php 
            if(isset($smof_data['shop-layout']) &&  $smof_data['shop-layout']  == 'shop9left'){

           echo '</div>';
        
        
             }elseif(isset($smof_data['shop-layout']) &&  $smof_data['shop-layout']  == 'shop9right'){
        
              echo '</div>';
                echo '<div class="col-lg-3 col-md-3 col-sm-12">';
            get_sidebar('shop');
            echo '</div>';
          }else{
            echo '</div>';
            
          } 
    ?>



        </div> <!--container-->


  	</div>
    <div class="shop-widgets-wrapper">    
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <?php  dynamic_sidebar( 'shop-footer-widget1' ) ?>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <?php  dynamic_sidebar( 'shop-footer-widget2' ) ?>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <?php  dynamic_sidebar( 'shop-footer-widget3' ) ?>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <?php  dynamic_sidebar( 'shop-footer-widget4' ) ?>
                </div>
            </div>
        </div>
    </div>


  </div>
</section>