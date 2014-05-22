<?php

/**
*Template Name: YouTube Channel
* @package werock
*/
get_header(); 
global $smof_data;
 ?>

<?php get_template_part( 'content', 'top' ); ?>



<!--=================================
videos
=================================-->

<section id="videos">
  <div class="container">
        <div class="row">
           
         
      <div class="col-lg-9 col-md-9 col-sm-9">

         <?php echo do_shortcode('[Vimeo_Channel_Gallery user="MaxonC4D" maxitems="12" thumbwidth="300" thumbcolumns="3" theme="dark" videowidth="100%"]'); ?>
      </div>
           <div class="col-lg-3 col-md-3 col-sm-9">
               <?php  get_sidebar(); ?>
             </div>
            </div>

            
            

        </div>
    </div>    
</section>



<?php get_footer(); ?>
