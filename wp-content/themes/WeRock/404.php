<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package werock
 */
get_header();

global $xv_data; //fetch options stored in $xv_data 
?>
<!--=================================
 Page header
 =================================--> 

  <section class="breadcrumb">
      
       <div class="container">
          <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6">
                  <h1>
                      <?php 
                            if(isset($xv_data['top_404_title'])){
                                    echo  $xv_data['top_404_title']; 
                              }else{ 
                                    echo '404 Error!';
                                  }
                      ?>
                  </h1>
                    <h5><?php if(isset($xv_data['top_404_subtitle'])){echo $xv_data['top_404_subtitle']; }else{ echo 'Page Not Found!'; } ?></h5>
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-6">
              <?php if (function_exists('werock_breadcrumbs')) { werock_breadcrumbs();} ?>
          </div>
       </div>
  </section>
<div class="clearfix"></div>

 <!--=================================
  Blog Posts
  ==========================================-->
 <section class="blog">
	<div class="container">
     	 <div class="row">     
        	<div class="col-lg-12 col-md-12 col-sm-12">
            	<div class="text-center xv_page_404">
                	<figure>
                     <?php  if(!empty($xv_data['erro-img']['thumbnail'])) {?>
                    	     <img src="<?php echo $xv_data['erro-img']['url']; ?>" alt="404" />
                      <?php }else{ ?>
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/basic/xv_404.png" alt="404" />
                       <?php } ?> 
                    </figure>
                     <p>
        			           <?php if(isset($xv_data['msg_404'])){
                            
                            echo  $xv_data['msg_404'];
                          }else{ ?>
                     
                          <?php _e( 'The page you are looking for might have been removed, had its name changed,<br> 
					                 Searching the site might help.', 'werock' ); ?>
                     
                        <?php } ?> 
                    </p>  
				</div>
            
        <?php 
            if(isset($xv_data['switch_404_search']) && $xv_data['switch_404_search']==1){ 
				    
              get_search_form(); 
              
            } 
        ?>


  
  			</div>
		</div><!--\\row-->
  	</div>  
</section>

<?php get_footer(); ?>
