<?php
/**
 * @package werock
 */
?>

        
              <article class="latest-post">
                <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                  <?php if ( has_post_thumbnail() ) {the_post_thumbnail();}?>
                  <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                  <ul class="post-meta">
                      <li><span class="fa fa-clock-o"></span><?php the_time('j F, Y'); ?></li>
                      <li><span class=" fa fa-user"></span><?php _e( 'by ', 'werock' ); ?><span><?php the_author(); ?></span></li>
                      <li><span class="fa fa-comment"></span><?php comments_number( '0 Comments', '1 Comment', '% Commentns' ); ?></li>
                  </ul>
                  <p><?php werock_get_excerpt(220); ?></p>
                </div>
              </article><!--\\latest post-->
                   