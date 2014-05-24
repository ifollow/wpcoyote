<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package werock
 */
global $xv_data;
?>

<!--=================================
  Latest blog
  =================================-->
<?php if(isset($xv_data['switch_footer_blog_post']) && $xv_data['switch_footer_blog_post']==1){ ?>
<section id="latest-blog">
  <div class="container">
      <div class="row">
          <h1><?php if(isset($xv_data['footer_blog_post_title'])){echo  $xv_data['footer_blog_post_title']; }?></h1>
          
          <?php 
          wp_reset_query(); 
          query_posts(array('posts_per_page' => 3));  ?>
          <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
          <div class="col-lg-4 col-md-4 col-sm-4">
              <article class="blog-post">
                   <?php 
                      if (  werock_autoset_featured_img() !== false ) { 
                      
                          $image_src = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), "full");
                          $image_url = $image_src[0];
                          $thumb = theme_thumb($image_url, 370, 200, 'c');
                      }else{

                           $image_url = get_template_directory_uri() . '/assets/img/blog/noimage.png';
                           $thumb = theme_thumb($image_url, 370, 200, 'c');
                          }
                       ?>
                        <img src="<?php echo $thumb; ?>" alt="<?php  the_title_attribute( 'echo=0' ); ?>" />
                  <div class="hover">
                    <a href="<?php the_permalink(); ?>">
                      <h2><?php the_title(); ?></h2>
                      <p><?php werock_get_excerpt(80,1); ?></p>
                      <ul>
                          <li><?php the_author(); ?></li>
                          <li><?php the_time('j F, Y'); ?></li>
                          <li><?php comments_number( '0 Comentários', '1 Comentário', '% Comentários' ); ?></li>
                      </ul>
                     </a> 
                  </div>
               </article>
          </div><!--\\blog-post-->
          <?php endwhile; endif;   ?>
          
       </div>
    </div>
</section>

<?php } ?>
<!--=================================
  Footer
  =================================-->
<footer>
  <div class="container">
      <div class="row">
          <div class="col-lg-3 col-md-3 col-sm-3">
             
                             <?php if(isset($xv_data['switch_about_widget']) && $xv_data['switch_about_widget']==1){ ?>

                                <h4><span></span><?php if(isset($xv_data['feed_bar_about_title'])){echo  $xv_data['feed_bar_about_title']; }?></h4>
                                  <?php if(isset($xv_data['about_widget'])){echo  $xv_data['about_widget']; }?>

                          <?php }else{ dynamic_sidebar( 'footer-widget1' ); } ?>
            </div><!--\\column-->
            
            <div class="col-lg-3 col-md-3 col-sm-3">
         


     <?php 
     if(isset($xv_data['switch_twitter_widget']) && $xv_data['switch_twitter_widget']==1){ ?>
                        <h4><span class="fa fa-twitter"></span><?php if(isset($xv_data['feed_bar_twitter_title'])){echo  $xv_data['feed_bar_twitter_title']; }?></h4>
                        <div class="tweets">
                          <?php if(isset($xv_data['twitter_widget_id'])){
                            echo '<div data-replies="false" data-limit="2" data-tweetname="'.$xv_data['twitter_widget_id'].'" class="latest-tweet"></div>
                         
                        </div>';
                         }?>

                         <?php }else{ dynamic_sidebar( 'footer-widget2' ); } ?>





            </div><!--\\column-->
            
            <div class="col-lg-3 col-md-3 col-sm-3">
          
                         <?php if(isset($xv_data['switch_flicker_widget']) && $xv_data['switch_flicker_widget']==1){ ?>
                        <h4><span class="fa fa-flickr"></span>Feed Instagram</h4>
                        <div class="flickr">
                         
                          <!-- SnapWidget -->
<iframe src="http://snapwidget.com/in/?u=Y295b3Rlc2hvd2JhcnxpbnwxMDB8M3wzfDAwMDAwMHx5ZXN8NXxmYWRlSW58b25TdGFydHxubw==&v=24514" title="Instagram Widget" allowTransparency="true" frameborder="0" scrolling="no" style="border:none; overflow:hidden; width:300px; height:200px"></iframe>

                        </div>
                        
                         <?php }else{ dynamic_sidebar( 'footer-widget3' ); } ?>


            </div><!--\\column-->
            
            <div class="col-lg-3 col-md-3 col-sm-3">
              <?php if(isset($xv_data['switch_newsletter_widget']) && $xv_data['switch_newsletter_widget']==1){ ?>
              <h4><span class="fa fa-envelope"></span><?php if(isset($xv_data['newsletter_title'])){echo  $xv_data['newsletter_title']; }?></h4>
                  
                  <?php if(isset($xv_data['newsletter_form'])){echo  $xv_data['newsletter_form']; }?>
                     
                          <?php }else{ dynamic_sidebar( 'footer-widget4' ); } ?>


            </div><!--\\column-->
            
        </div><!--\\row-->
    </div><!--\\container-->
</footer>
<!-- Dynamic / Custom Js from theme options panel-->
<script type="text/javascript">
      <?php if ( isset($xv_data['js-code']) ) { echo  $xv_data['js-code']; }?>
</script>

<?php if(isset($xv_data['tracking-code'])){echo $xv_data['tracking-code']; }?>
<?php wp_footer(); ?>

</body>
</html>
