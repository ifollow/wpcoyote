<?php

/**
*Template Name: Albums
* @package werock
*/
get_header(); 
global $xv_data;
 ?>

<?php get_template_part( 'content', 'top' ); ?>



<!--=================================
Album
=================================-->

<section id="recent-albums">
  <div class="container">
        <div class="recent-album-list">
         
          <div class="album-wrapper">
            
                <?php query_posts(array('post_type'=>'album'));  ?>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="album ">
                    <?php if ( has_post_thumbnail() ) {the_post_thumbnail();}?>
                    <div class="hover">
                        <ul>
                            <li><a href="<?php the_permalink(); ?>"><span class="fa fa-link"></span></a></li>
                        </ul>
                        <h3><?php the_title(); ?></h3>
                        <h2><?php  _e( 'Album', 'werock' ); ?></h2>
                    </div>
                </div><!--\\album-->
               
              <?php  endwhile; endif;   ?>
                
            </div><!--//row-->
            
        </div><!--artist list-->
    </div><!--//container-->  
</section>
<?php get_footer(); ?>



