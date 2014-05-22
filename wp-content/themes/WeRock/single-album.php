<?php
/**
 * The Template for displaying all single posts.
 *
 * @package werock
 */

get_header(); ?>



<!--=================================
bread crums
=================================-->
  <section class="breadcrumb">
  		
       <div class="container">
       		<div class="row">
            	<div class="col-lg-6 col-md-6 col-sm-6">
                	 <h1><?php 
                              $saved_data = get_post_meta($post->ID,'xv_post-top-title',true);
                              if(!empty($saved_data)){
                                
                                 echo $saved_data;
                                }else{
                                  _e( 'Album', 'werock' );
                                }
                            ?>
                    </h1>
                    <h5><?php 
                              $saved_data = get_post_meta($post->ID,'xv_post-subtitle',true);
                              echo $saved_data;

                            ?>
                   </h5>
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-6">
                     <?php if (function_exists('werock_breadcrumbs')) { werock_breadcrumbs();} ?>
                </div>
       		</div>
       </div>
  </section>
<div class="clearfix"></div>
<!--=================================
Album
=================================-->
<section id="albums">
  <div class="container">
        <div class="row">
          <div class="album-detail">
            <?php while ( have_posts() ) : the_post(); ?>
              <div class="col-lg-3 col-md-3 col-sm-3">
                    <div class="album-purchase">
                         <?php if ( has_post_thumbnail() ) {the_post_thumbnail();}?>
                         <?php 
                              $saved_data = get_post_meta($post->ID,'xv_re_album',true);
                              if(!empty($saved_data)){
                                foreach ($saved_data as $arr){
                                  echo '<a href="'. $arr['xv_album_buy_url'].'">'.$arr['xv_album_buy_btn'].'<span>'.$arr['xv_album_price'].'</span></a>';
                                }
                              }
                          ?>
                      
                    </div>
                    </div>
                     <div class="col-lg-9 col-md-9 col-sm-9">
                      <div class="album-detail-content">
                            <h4><?php the_title(); ?></h4>
                           
                             <?php the_content(); ?>
                        </div><!--//artist-detail-content-->
                        
                        <div class="album-tracks">
                          

                                
                                        
                                      <?php
                                      $saved_data = get_post_meta($post->ID,'xv_re',true);
                                      if(!empty($saved_data)){

                                    ?>
                                   

                                            <h1><?php _e( 'tracks', 'werock' ); ?></h1>
                                            <div id="track_player"></div>
                                            <div class="track">
                                          <ul>
                                            <li class="track-head">
                                            <div class="track_title"><?php _e( 'song title', 'werock' ); ?></div>
                                            <div class="track_listen"><?php _e( 'Listen', 'werock' ); ?></div>
                                           
                                            <div class="track_popularity"><?php _e( 'popularity', 'werock' ); ?></div>
                                            <div class="track_buy"><?php _e( 'Buy', 'werock' ); ?></div>
                                            </li>
                                      <?php
                                      foreach ($saved_data as $arr){

                                      ?>
                                            <li>
                                                <div class="track_title"><?php echo $arr['xv_album_track_title']; ?></div>
                                                <div class="track_listen">
                                                  <a href="<?php echo $arr['xv_track_url']; ?>"> <i class="fa fa-play"></i></a>
                                                </div>
                                                
                                                 <div class="track_popularity">
                                                 <ul>
                                                   <li class="active"></li>
                                                 <li class="active"></li>
                                            
                                                        
                                                        <?php 
                                                        $bars = '';

                                                        $bars = $arr['xv_track_popularity'];
                                              
                                                        for($i=1; $i<=$bars; $i++){
                                                        
                                                          echo ' <li class="active"></li>';
                                                        }
                                                        for($i=1; $i<=13-$bars; $i++){
                                                        
                                                          echo '<li></li>';
                                                        }
                                                        ?>
                                                    
                                                        
                                                    </ul>
                                                 </div>
                                                <div class="track_buy"><a href="<?php echo $arr['xv_track_buy_url']; ?>"><i class="fa fa-shopping-cart"></i><?php echo $arr['xv_track_buy_btn']; ?></a></div>
                                            </li>

                                    <?php }
                                    echo '</ul>
                                             </div>';
                                      }
                                     ?>
   


                                  
                              
                            <div class="clearfix"></div>
                            
                        </div><!--artist tracks-->
                </div><!--\\artist-->
              <?php endwhile; // end of the loop. ?>
            </div>
        </div><!--row-->      
    </div><!--container-->
</section>
<div class="clearfix"></div>

<?php get_footer(); ?>
