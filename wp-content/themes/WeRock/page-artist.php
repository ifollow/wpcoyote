<?php

/**
*Template Name: Artist
* @package werock
*/
get_header(); 
global $smof_data;
 ?>

<?php get_template_part( 'content', 'top' ); ?>



<!--=================================
Artists
=================================-->

<section id="artists">
  <div class="container">
        <div class="artist-list">
          <div class="row">
                <?php query_posts(array('post_type'=>'artist'));  ?>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="col-lg-3 col-md-3 col-sm-4 xs-12">
                    <div class="artist">
                        <?php if ( has_post_thumbnail() ) {the_post_thumbnail();}?>
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </div><!--\\artist-->
                </div>
                <?php  endwhile; endif;   ?>
            </div><!--//artist list-->
        </div><!--row-->
    </div><!--//container-->  
</section>



<?php get_footer(); ?>



