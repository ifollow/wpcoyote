<?php
/**
 * Content wrappers
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly?>
<?php global $xv_data; //fetch options stored in $xv_data ?>

 
  <section id="shop-holder">
    <div class="container">
     
      <div class="row">     



 	<?php 
 
      if(isset($xv_data['shop-layout']) &&  $xv_data['shop-layout']  == 'shop9left'){

 			echo '<div class="col-lg-9 col-md-9 col-sm-12">';
 		
 		     }elseif(isset($xv_data['shop-layout']) &&  $xv_data['shop-layout']  == 'shop9right'){
 		
 			    echo '<div class="col-lg-3 col-md-3 col-sm-12">';
		      	   get_sidebar('shop');
		          echo '</div>';
		          echo '<div class="col-lg-9 col-md-9 col-sm-12">';
 	      }else{
            echo '<div class="col-lg-12 col-md-12 col-sm-12">';
          } 
 	?>