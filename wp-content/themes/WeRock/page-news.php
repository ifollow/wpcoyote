<?php
/**
*Template Name: News Page
* @package werock
*/
get_header(); 

global $xv_data;
?>


<?php get_template_part( 'content', 'top' ); ?>

<section id="updates">
  <div class="container">
        <div class="row">
          

            <div class="col-lg-9 col-md-9 col-sm-9">
                <div class="news-wrapper">
                    <?php
                    $i =0;
                     query_posts(array('post_type'=>'news'));  ?>
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                    <div class="news-feed <?php if($i== 0){echo 'style-news';}?>">
                         <?php if ( has_post_thumbnail() ) {the_post_thumbnail();}?>
                          <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                        <ul class="post-meta">
                            <li><span class="fa fa-clock-o"></span><?php the_time('j F, Y'); ?></li>
                            <li><span class=" fa fa-user"></span><?php _e( 'por ', 'werock' ); ?><span><?php the_author(); ?></span></li>
                        </ul>
                    <p><?php the_excerpt(); ?></p>
                    </div><!--\\latest news-->
                    
                      <?php $i++; endwhile; endif;   ?>

                      <?php if (function_exists("werock_get_pagination")) {werock_get_pagination();} ?>
                    
                    
                </div><!--\\news wrapper--> 
            </div><!--latest news-->

            <div class="col-lg-3 col-md-3 col-sm-3">
            <?php get_sidebar(); ?>
           </div>
        </div>
    </div>    
</section>





 <?php get_footer();?>
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 