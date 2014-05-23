<?php
/**
*Template Name: Home Page
* @package werock
*/
get_header(); 
global $xv_data;
 ?>

<!--=================================
Home
=================================-->
<div class="container">


<?php get_werock_slider_widget(); ?>

<?php get_werock_player_widget(); ?>

<?php 
            if(isset($xv_data['home-gallery-carousel']) && $xv_data['home-gallery-carousel']==1){ 
              
                $posts  =  $xv_data['home-gallery-num'];
               
                get_werock_carousel_widget('Galeria',$posts,0) ; 
            }
    ?>


        <div class="row">
          
            <div class="col-lg-3 col-md-3 col-sm-3">
            <?php 
                    if(isset($xv_data['home-event-num'])){
                        $posts_event  =  $xv_data['home-event-num'];
                        get_werock_events_widget('Nossa Agenda',$posts_event,0);
                    }
             ?>
                
            </div><!--latest events-->
            
            <div class="col-lg-6 col-md-6 col-sm-6">
                 <?php 
                    if(isset($xv_data['home-news-num'])){
                     
                        $posts_news =  $xv_data['home-news-num'];
                        get_werock_news_widget('Últimas Notícias',$posts_news,0); 
                    }
                 ?>
            
            </div><!--latest news-->


            <div class="col-lg-3 col-md-3 col-sm-3">
                <?php 
                    if(isset($xv_data['home-videos-num'])){
                         $posts_videos  =  $xv_data['home-videos-num'];
                        get_werock_videos_widget('Videos',$posts_videos,0);
                    }
                 ?>
            
            </div><!--latest videos-->
        </div>
 
</div>
 <?php get_footer();?>
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 