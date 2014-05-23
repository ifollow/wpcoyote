<?php
/**
 * @package werock
 */
 global $smof_data; //fetch options stored in $smof_data
?>


<!--=================================
Blog
=================================-->

          
  <article class="latest-post detail">
                    <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
      
      
      
                            <?php if ( has_post_thumbnail() ) {the_post_thumbnail();}?>
                       <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                  <ul class="post-meta">
                      <li><span class="fa fa-clock-o"></span><?php the_time('j F, Y'); ?></li>
                      <li><span class=" fa fa-user"></span><?php _e( 'por ', 'werock' ); ?><span><?php the_author(); ?></span></li>
                      <li><span class="fa fa-comment"></span><?php comments_number( '0 Comentários', '1 Comentário', '% Comentários' ); ?></li>
                  </ul>
                    <?php the_content(); ?>
                        </div>
                    </article><!--\\latest post-->