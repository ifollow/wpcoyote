<?php

/**
*Template Name: Gallery
* @package werock
*/
get_header(); 
global $xv_data;
 ?>

  <section class="breadcrumb">
      
       <div class="container">
          <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6">
                  <h1>Galeria</h1>
                    <h5> 
                    Confira nossas últimas fotos adicionadas!
                    </h5>
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-6">
              <?php if (function_exists('werock_breadcrumbs')) { werock_breadcrumbs();} ?>
          </div>
       </div>
  </section>
<div class="clearfix"></div>


<section id="gallery">
  <div class="container">
        <div class="row">
          
          <?php
            $terms = get_terms("gallery_category");
            $count = count($terms);
          ?>    
              

            <div class="photo-filter">
                <div class="container">
                    <h5>Filtro:</h5>
                    <ul>
                        <li class="active"><a href="#" data-filter="*">Todos</a></li>
                         <?php  foreach ( $terms as $term ) { ?>
                        <li><a href="#" data-filter=".<?php echo $term->slug; ?>"><?php echo $term->name; ?></a></li>
                        <?php } ?>  
                     </ul>
                </div>
            </div><!--//photo filter-->
                
            <div class="container">
              <div class=" photo-gallery">
                 <?php
                      $terms = get_terms("gallery_category");
                        $count = count($terms);
                        foreach ( $terms as $term ) { 
                        $adcount = 1; 
                        $g = 1;
                        query_posts(array('post_type'=>'gallery','gallery_category'=> $term->name,'orderby' => 'date','order' => 'ASC' )); 
                        if (have_posts()) : while (have_posts()) : the_post(); 
                      
                         if ( werock_autoset_featured_img() !== false ) { 
                             $image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "full");
                             $image_url = $image_src[0];
                             $thumb = theme_thumb($image_url, 370, 250, 'c');
                        }
                   ?>

                  <div class="photo-item <?php echo $term->slug; ?>">

                      <a class="fancybox bbb" rel="gallery<?php echo $g; ?>" title="<?php the_title(); ?>" href="<?php echo $image_url ?>">
                        <img src="<?php echo $thumb; ?>" alt=""/>
                      </a>



                                        
                                    



                    
 

                        <div class="fig-caption"><?php the_title(); ?></div>
                    </div>
                    <?php $g++;
                          endwhile; endif; } ?>          
         
                  
                   
      
                    
                </div>

                      <?php if (function_exists("werock_get_pagination")) {werock_get_pagination();} ?>
            
            </div><!--//photo gallery-->
        </div><!--row-->
    </div><!--//container-->  
</section>


<script>
$(".fancybox").fancybox({
    padding : 0
});
</script>


<?php get_footer(); ?>
