<?php

/**

*Template Name: Gallery

* @package WeRock

*/
get_header(); ?>



<!--=================================
bread crums
=================================-->
  <section class="breadcrumb">
      
       <div class="container">
          <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6">
                  <h1>Galeria</h1>
                    <h5>
                      Confira nossas fotos!
                  </h5>
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-6">
                  <ul>
                      <li><a href="#">Home</a></li>
                        <li><a href="#">blog</a></li>
                    </ul>
                </div>
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
                    <h5>filter:</h5>
                    <ul>
                        <li class="active"><a href="#" data-filter="*">All</a></li>
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
                        query_posts(array('post_type'=>'gallery','gallery_category'=> $term->name,'orderby' => 'date','order' => 'ASC' )); 
                        if (have_posts()) : while (have_posts()) : the_post(); 
                   ?>

                  <div class="photo-item <?php echo $term->slug; ?>">
                        <figure>
                            <?php if ( has_post_thumbnail() ) {the_post_thumbnail();}?>
                        </figure>
                        <div class="fig-caption"><a href="assets/img/gallery/1.jpg" data-rel="prettyPhoto"><?php the_title(); ?></a></div>
                    </div>
                    <?php endwhile; endif; } ?>          
         
                  
                   
      
                    
                </div>

                      <?php if (function_exists("werock_get_pagination")) {werock_get_pagination();} ?>
            
            </div><!--//photo gallery-->
        </div><!--row-->
    </div><!--//container-->  
</section>



<?php get_footer(); ?>
