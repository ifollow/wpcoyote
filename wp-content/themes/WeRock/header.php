<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package werock
 */
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!-->
<html <?php language_attributes(); ?> class="no-js">
<!--<![endif]-->
<?php global $xv_data; //fetch options stored in $xv_data ?>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta content="yes" name="apple-mobile-web-app-capable" />
<meta name="viewport" content="minimum-scale=1.0, width=device-width, maximum-scale=1, user-scalable=no" />
<link rel="shortcut icon" href="<?php if(!empty($xv_data['fav-icon']['url'])){ echo $xv_data['fav-icon']['url'];}else{ echo get_template_directory_uri() .  '/assets/img/favicon.png'; }?>" type="image/x-icon" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> data-spy="scroll" data-target="#sticktop" data-offset="70">

<!--=================================
  Header
  =================================-->
<header> 
    <div class="social-links">
      <div class="container">
            <ul class="social">
              <?php 

                   if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
                    global $woocommerce;
               ?>

                 <li class="xv_cart_icon"><a class="cart-contents" href="<?php echo $woocommerce->cart->get_cart_url(); ?>" title="<?php _e('View your shopping cart', 'woothemes'); ?>"><?php echo sprintf(_n('%d item', '%d items', $woocommerce->cart->cart_contents_count, 'woothemes'), $woocommerce->cart->cart_contents_count);?></a></li>
              <?php } ?>
              <?php 
                if(!empty($xv_data['social-icons']['facebook'])){ 
                  echo '<li><a href="'. $xv_data['social-icons']['facebook'].'"><span class="fa fa-facebook"></span></a></li>';
                }
                if(!empty($xv_data['social-icons']['twitter'])){ 
                  echo '<li><a href="'. $xv_data['social-icons']['twitter'] .'"><span class="fa fa-twitter"></span></a></li>';
                }
                if(!empty($xv_data['social-icons']['pinterest'])){ 
                  echo '<li><a href="'. $xv_data['social-icons']['pinterest'] .'"><span class="fa fa-pinterest"></span></a></li>';
                }
                if(!empty($xv_data['social-icons']['linkedin'])){ 
                  echo '<li><a href="'. $xv_data['social-icons']['linkedin'] .'"><span class="fa fa-linkedin"></span></a></li>';
                }
                if(!empty($xv_data['social-icons']['flickr'])){ 
                  echo '<li><a href="'. $xv_data['social-icons']['flickr'] .'"><span class="fa fa-flickr"></span></a></li>';
                }
                if(!empty($xv_data['social-icons']['youtube'])){ 
                  echo '<li><a href="'. $xv_data['social-icons']['youtube'] .'"><span class="fa fa-youtube"></span></a></li>';
                }
                 if(!empty($xv_data['social-icons']['instagram'])){ 
                  echo '<li><a href="'. $xv_data['social-icons']['instagram'] .'"><span class="fa fa-instagram"></span></a></li>';
                }
              ?>
             </ul> 
         
         </div>
    </div>
    
  <?php  
        
        if(isset($xv_data['switch-menu']) && $xv_data['switch-menu']==1){

            if($xv_data['respnisve-menu']==0){

          ?>
                  <div class="visible-lg">
                    <?php get_template_part( 'xv', 'menu' ); ?>
                  </div>  
                   
        
                  <div class="hidden-lg">
                     <?php get_template_part( 'content', 'menu' ); ?>
                  </div>     

      <?php 
            }else{  //responsiv-menu
                  get_template_part( 'xv', 'menu' );
              }
          
         }else{
          
              get_template_part( 'content', 'menu' ); 
        }


  ?>

</header>
<?php  get_template_part( 'xv', 'slider' ); ?>