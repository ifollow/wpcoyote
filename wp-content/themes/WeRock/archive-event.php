<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package werock
 */

get_header(); ?>

  <section id="blog" class="whiteBG">
 	<div class="container">
    	<div id="xv_ajax_events">
    		<h3>events on <span><?php the_time('M'); ?>, <?php the_time('Y'); ?></span></h3>
			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>

				<?php
					/* Include the Post-Format-specific template for the content.
					 * If you want to override this in a child theme, then include a file
					 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
					 */
					//get_template_part( 'content', get_post_format() );
				?>
				<div class="event-feed">
        
            	<?php if ( has_post_thumbnail() ) {the_post_thumbnail();}?>
                        <div class="event-detail">
                            <div class="date">
                                <span class="day"><?php the_time('j'); ?></span>
                                <span class="month"><?php the_time('M'); ?></span>
                            </div>
                            <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                            <p><?php echo get_post_meta( $post->ID, 'xv_event_location', true ); ?></p>
                            <?php
                              $xv_event_btn_woo = get_post_meta( $post->ID, 'xv_event_btn_woo', true );
                            if( !empty($xv_event_btn_woo)){

                                echo do_shortcode('[add_to_cart id="'.$xv_event_btn_woo.'"]'); 
                            }else{

                                    $postDate = strtotime( $post->post_date );
                                    $todaysDate = time() - (time() % 86400);
                                    if ( $postDate >= $todaysDate) {
                                        $xv_event_btn_text = get_post_meta( $post->ID, 'xv_event_btn_text', true );
                                        if(!empty($xv_event_btn_text)){
                                            $buy_tickets_btn = '';
                                            $buy_tickets_btn = get_post_meta( $post->ID, 'xv_event_btn_text', true );
                                          }else{
                                            $buy_tickets_btn = "Buy Tickets";
                                    }
                                      $xv_event_btn_url =   get_post_meta( $post->ID, 'xv_event_btn_url', true );
                                      if($xv_event_btn_url){ 
                                          echo '<a class="btn" href="'.$xv_event_btn_url.'">'.$buy_tickets_btn.'</a>';
                                        }
                                      }else{
                                        echo '<a class="btn" href="'.$xv_event_btn_url.'">Event Expired</a>';
                                      }
                           }

                          ?>
                        </div>    
                    </div>


			<?php endwhile; ?>
            </div>
		</div>
	</section>

		
<?php  get_footer(); ?>






