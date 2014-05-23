  <?php
  /**
  *Template Name: Contact Page
   * @package visionmax
  */
  get_header(); 
global $xv_data;
  ?>

<?php get_template_part( 'content', 'top' ); ?>



<!--=================================
videos
=================================-->

<section id="contact">
  <div class="container">
        <div class="row">
          <div class="col-lg-9 col-md-9 col-sm-9">
            <?php if(!empty($xv_data['gmap'])){?>
              <div id="google-map" class="contact-map" data-theme="<?php echo $xv_data['map-skin']; ?>" data-address="<?php echo $xv_data['gmap']; ?>" data-zoomlvl="13" data-maptype="HYBRID"></div>
               
            <?php }  ?>

            <?php echo "<br /> <br />" ?>
               <?php  
                    if(!empty($xv_data['contact_form_id'])){
                     echo do_shortcode('[contact-form-7 id="'.$xv_data['contact_form_id'].'"]');  
                       }else{
                         echo '<div class="alert alert-warning"><strong>Warning! </strong> Contact Form 7 ID Missing .</div>';
                    }
               ?>
            </div>
            
            <div class="col-lg-3 col-md-3 col-sm-3">
                <?php  dynamic_sidebar( 'contact-sidebar' ); ?>
            </div>


        </div><!--row-->
    </div><!--//container-->  
</section>

    <?php get_footer(); ?>

            