<?php
  /* Including all widgets */
  include_once 'xv_slider_widget.php';
  include_once 'xv_playlist_widget.php';
  include_once 'xv_news_widget.php';
  include_once 'xv_videos_widget.php';
  include_once 'xv_shop_widget.php';
  include_once 'xv_carousel_widget.php';
  include_once 'xv_master_widget.php';
  include_once 'xv_gallery_widget.php';
  include_once 'xv_events_widget.php';
  include_once 'xv_ajax_event_widget.php';

  ?>
<?php
  function get_werock_slider_widget(){
  global $xv_data;
?>
    <?php
         if(isset($xv_data['mycustom_field']) && !empty($xv_data['mycustom_field'])){

        
                $slides = $xv_data['mycustom_field'];
                 //get the slides array


           ?>

              <section id="home-slider">
                  <div class="home-inner">
                        <div class="slider-nav">
                        
                            <a id="home-prev" href="#" class="prev fa fa-chevron-left"></a><a id="home-next" href="#" class="next fa fa-chevron-right"> </a>
                            
                        </div>
                        <div id="flex-home" class="flexslider loading">
                            
                      
                              <?php $i=1;?>      
                            <ul class="slides">
                        <?php 
                              
                              foreach ($slides as $slide) { ?>

                                <li> <img src="<?php echo $slide['image'];?>" alt="" >
                                  <div class="flex-caption">
                                        <h2><?php echo $slide['title'];?></h2>
                                    </div>
                                </li>
                                 <?php $i=0; ?>
                                 <?php } ?>
                            </ul>
                            
                        </div>
                   </div> 
            </section>
    
<?php
      }//if slides
   }

function get_werock_player_widget(){

      global $xv_data;
      global $post;

?>
          <section id="audio-player">
                <div class="rock-player">
                      <div class="row">
                        <div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                    <div id="player-instance" class="jp-jplayer"></div>
                                      <div class="controls">
                                          <div class="jp-prev "></div>
                                          <div  class="play-pause jp-play"></div>
                                          <div  class="play-pause jp-pause"></div>
                                          <div class="jp-next "></div>
                                      </div><!--controls-->
                                   </div>   
                                   <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">   
                                      <div class="player-status">
                                          <h5 class="audio-title"></h5>
                                          <div class="audio-timer"><span class="current-time jp-current-time"></span> <span class="total-time jp-duration"></span></div>
                                          <div class="audio-progress">
                                            <div class="jp-seek-bar">
                                              <div class="audio-play-bar jp-play-bar" style=""></div>
                                               </div> <!--jp-seek-bar-->
                                          </div><!--audio-progress-->
                                      </div><!--player-status-->
                                  </div> <!--column-->   
                              </div> <!--inner-row-->     
                          </div><!--column-->  
                          
                          <div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
                            <div class="audio-list">
                                  <div class="audio-list-icon"></div>
                                  <div class="jp-playlist">
                                    <!--Add Songs In mp3 formate here-->
                                        <ul class="hidden playlist-files">
                                            <?php query_posts(array('post_type'=>'playlist','posts_per_page' => -1));  ?>
                                            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                                            <li data-title="<?php the_title(); ?>" 
                                                data-artist="<?php echo get_post_meta($post->ID, 'xv_playlist_artist', true); ?>" 
                                                  data-mp3="<?php echo get_post_meta($post->ID, 'xv_playlist_track_url', true); ?>"></li>
                                               <?php endwhile; endif;   wp_reset_query();   ?>
                                               
                                        </ul>
                                      <!--Playlist ends-->
                                    <h5>Audio Playlist</h5>
                                        <div class="audio-track">
                                              <ul><li></li></ul>
                                          </div>
                                  </div>
                              </div>
                          </div>
                      </div><!--row-->
                </div>
          </section>
<?php }

function get_werock_carousel_widget($title,$post_per_page,$offset){
  global $xv_data;
  global $post;


  ?>
    <section id="albums" class="album_carousel_wrapper">
    	  <div class="album_preload"></div>
          <h1><?php echo $title; ?></h1>
            
            <div class="top-carouselnav">
                <a href="#" class="prev-album"><span class="fa fa-caret-left"></span></a>
                <a href="#" class="next-album"><span class="fa fa-caret-right"></span></a>
            </div>
            
            <div class="albums-carousel">

              <?php query_posts(array('post_type'=>'album','posts_per_page' => $post_per_page,'offset'=>$offset));  ?>
              <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
              <div class="album">
                    <?php if ( has_post_thumbnail() ) {the_post_thumbnail();}?>
                    <div class="hover">
                        <ul>
                          <li><a href="<?php echo get_template_directory_uri(); ?>/assets/img/albums/1.jpg" data-rel="prettyPhoto"><span class="fa fa-search"  ></span></a></li>
                            <li><a href="<?php the_permalink(); ?>"><span class="fa fa-link"></span></a></li>
                        </ul>
                        <h3><?php the_title(); ?></h3>
              <h2>Album</h2>
                    </div>
                </div><!--\\album-->
                <?php endwhile; endif; 
                      wp_reset_query(); 
                  ?>
                </div>
    </section>

<?php }

function get_werock_videos_widget($title,$post_per_page,$offset=0){
  global $xv_data;
  global $post;


  ?>
              <h1><?php echo $title; ?></h1>
              <?php query_posts(array('post_type'=>'videos','posts_per_page' => $post_per_page,'offset'=>$offset));  ?>
              <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="video-feed">
                  <?php 
                      if (  werock_autoset_featured_img() !== false ) { 
                      
                          $image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "full");
                          $image_url = $image_src[0];
                          $thumb = theme_thumb($image_url, 270, 150, 'c');
                      }else{

                           $image_url = get_template_directory_uri() . '/assets/img/blog/noimage.png';
                           $thumb = theme_thumb($image_url, 270, 150, 'c');
                          }
                       ?>
                        <img src="<?php echo $thumb; ?>" alt="<?php  the_title_attribute( 'echo=0' ); ?>" />
                      <?php
                        $saved_data = get_post_meta($post->ID,'xv_video_url',true);
                        if(!empty($saved_data)){
                      ?>
                        <a href="<?php echo $saved_data; ?>"><span class="fa fa-play"></span></a>
                      <?php } ?>
                    <h6><?php the_time('j F, Y'); ?></h6>
                </div><!--\\video-feed-->
                 <?php endwhile; endif;  
                      wp_reset_query(); 
                  ?>


<?php }


function get_werock_gallery_widget($title,$post_per_page,$offset=0){
  global $xv_data;
  global $post;


  ?>
              <h1><?php echo $title; ?></h1>
              <?php query_posts(array('post_type'=>'gallery','posts_per_page' => $post_per_page,'offset'=>$offset));  ?>
              <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                  <?php 
                      if (  werock_autoset_featured_img() !== false ) { 
                      
                          $image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "full");
                          $image_url = $image_src[0];
                          $thumb = theme_thumb($image_url, 270, 150, 'c');
                      }else{

                           $image_url = get_template_directory_uri() . '/assets/img/blog/noimage.png';
                           $thumb = theme_thumb($image_url, 270, 150, 'c');
                          }
                       ?>
        

                <div class="photo-item2">

                  <a class="fancybox bbb" rel="gallery" title="<?php the_title(); ?>" href="<?php echo $image_url ?>">
                    <img src="<?php echo $thumb; ?>" alt=""/>
                  </a>

                        <div class="fig-caption"><?php //the_title(); ?></div>
                 </div>
                 <?php endwhile; endif;  
                      wp_reset_query(); 
                  ?>


<?php }

function get_werock_news_widget($title,$post_per_page,$offset=0){
  global $xv_data;
  global $post;


  ?>
              <h1><?php echo $title; ?></h1>
              <?php query_posts(array('post_type'=>'news','posts_per_page' => $post_per_page,'offset'=>$offset));  ?>
      
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <div class="news-feed">
                    <?php 
                      if (  werock_autoset_featured_img() !== false ) { 
                      
                          $image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "full");
                          $image_url = $image_src[0];
                          $thumb = theme_thumb($image_url, 99, 99, 'c');
                      }else{

                           $image_url = get_template_directory_uri() . '/assets/img/blog/noimage.png';
                           $thumb = theme_thumb($image_url, 99, 99, 'c');
                          }
                       ?>
                       <img src="<?php echo $thumb; ?>" alt="<?php  the_title_attribute( 'echo=0' ); ?>" />
                       <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                  <ul>
                      <li><span class="fa fa-clock-o"></span><?php the_time('j F, Y'); ?></li>
                      <li><span class=" fa fa-user"></span><?php _e( 'by ', 'werock' ); ?><span><?php the_author(); ?></span></li>
                  </ul>
                  <p><?php werock_get_excerpt(150,1); ?></p>
                </div><!--\\latest news-->
                 <?php endwhile; endif;  wp_reset_query();   ?>


<?php }



function get_werock_shop_widget($title,$post_per_page,$offset=0){
  global $xv_data;
  global $post;


  ?>
              
                <h1><?php echo $title; ?></h1>
                <?php
                if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
  
                      query_posts(array('post_type'=>'product','posts_per_page' => $post_per_page,'offset'=>$offset));
                      if (have_posts()) : while (have_posts()) : the_post(); 
                ?>
                      <div class="store-item">
                        

                          <?php if ( has_post_thumbnail() ) {the_post_thumbnail();}?>
                          <h3><?php the_title(); ?></h3>
                          <h5>$<?php echo get_post_meta( get_the_ID(), '_regular_price', true); ?></h5>
                          <a href="<?php the_permalink();?>"class="btn"><b class=" fa fa-random"></b>buy now</a>
                      </div><!--store item ends-->
                           <?php endwhile; endif;  
                            wp_reset_query(); 
                            ?>

                <?php }else{ 
                
                        echo 'Woocommerce is not activated';
                      }
                 ?>           
<?php }

function get_werock_events_widget($title,$post_per_page,$offset=0){
  global $xv_data;
  global $post;

  ?>
      
              <h1><?php _e( $title, 'werock' ); ?></h1>
                
                <?php query_posts(array('post_type'=>'event','post_status'=>'future,publish','posts_per_page' => $post_per_page,'offset'=>$offset));  ?>
                <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php  
                            $postDate = strtotime( $post->post_date );
                            $todaysDate = time() - (time() % 86400);
                            if ( $postDate >= $todaysDate) {
                ?>


                <div class="event-feed">
                  <div class="date">
                       <span class="day"><?php the_time('j'); ?></span>
                        <span class="month"><?php the_time('M'); ?></span>
                    </div>
                    <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                    <p><?php echo get_post_meta( $post->ID, 'xv_event_location', true ); ?></p>
                    <?php
                                $xv_event_btn_woo = get_post_meta( $post->ID, 'xv_event_btn_woo', true );
                            if( !empty($xv_event_btn_woo )){

                                echo do_shortcode('[add_to_cart id="'.get_post_meta( $post->ID, 'xv_event_btn_woo', true ).'"]'); 
                            }else{

                                    $postDate = strtotime( $post->post_date );
                                    $todaysDate = time() - (time() % 86400);
                                    if ( $postDate >= $todaysDate) {

                                        $xv_event_btn_text = get_post_meta( $post->ID, 'xv_event_btn_text', true );
                                        if(!empty($xv_event_btn_text)){
                                            $buy_tickets_btn = '';
                                            $buy_tickets_btn = $xv_event_btn_text;
                                          }else{
                                            $buy_tickets_btn = "Buy Tickets";
                                    }
                                        $xv_event_btn_url = get_post_meta( $post->ID, 'xv_event_btn_url', true);
                                      if($xv_event_btn_url){ 
                                          echo '<a class="btn" href="'.$xv_event_btn_url.'">'.$buy_tickets_btn.'</a>';
                                        }
                                      }else{
                                        echo '<a class="btn" href="'.$xv_event_btn_url.'">Event Expired</a>';
                                      }
                           }

                          ?>
                </div><!--\\event-->
                 <?php }  endwhile; endif;  wp_reset_query();   ?>

<?php }