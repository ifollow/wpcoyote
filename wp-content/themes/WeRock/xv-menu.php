
<?php global $xv_data; //fetch options stored in $xv_data ?>
 <nav class="navbar yamm navbar-default">
      <div class="container">
        
        
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <i class="icon-bar"></i>
            <i class="icon-bar"></i>
            <i class="icon-bar"></i>
          </button>

                <a class="navbar-brand" href="<?php echo home_url('/'); ?>" title="<?php echo esc_attr(get_bloginfo('name', 'display')); ?>" rel="home">
                    <?php if(!empty($xv_data['logo']['thumbnail'])) { ?>
                        <img src="<?php echo $xv_data['logo']['url']; ?>" alt="<?php bloginfo('name'); ?>"/>
                   <?php }else{
                          ?>
                         <div class="logo"><?php bloginfo('name'); ?></div>
                          <div class="slogan"> <?php bloginfo('description'); ?> </div>
                    <?php } ?>
                 </a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
          
              <?php 
                  $xv_menu_url = '';
                  $xv_menu_query = new WP_Query(array('post_type'=>'menu','order'=>'ASC','posts_per_page'=>-1));
                    while ($xv_menu_query->have_posts()) : $xv_menu_query->the_post();
                      
                      $children = wp_list_pages('title_li=&child_of='.get_the_ID().'&post_type=menu&echo=0'); 
               ?>

                       <?php

                       /*Condiotions:
                          1: Check If parrent
                          2: Check if have content 
                          3: Check if have child elements then ignore content
                       */ 
                          //Check if post is parent
                          if (!$post->post_parent ) {?>

                            <li class="<?php if(!$children) echo 'yamm-fw'; ?> dropdown">
                             
                              <?php  
                                //Check if there is no content then add an external URL
                                if($post->post_content==""){ 
                                   
                                    $xv_menu_url = get_post_meta($post->ID, 'xv_menu_url', true); 
                                    
                                    if(!empty($xv_menu_url)){
                                       
                                        echo '<a href="'. $xv_menu_url .'" >'.get_the_title() . '</a>';
                                    }     

                                }else{ //else if there is content ?>
                                  
                                    <a><?php the_title();?><i class="fa fa-angle-down"></i></a>
                        
                              <?php } ?>  
                              <?php 
                                   //Simple Drop Down If there are child items
                                    if ($children){ 
                                      
                                            echo '<ul class="dropdown-menu">';
                            
                                                    $pages = get_pages('child_of='.$post->ID.'&post_type=menu');
                                                    $count = 0;
                                              
                                                   foreach($pages as $page){ 
                                                         $xv_menu_url = get_post_meta($page->ID, 'xv_menu_url', true);
                                                     echo '<li><a href="'. $xv_menu_url .'">'.$page->post_title .'</a></li>';              
                                                   }//END foreach

                                            echo '</ul>'; 

                                    }elseif($post->post_content != ""){ ?>

                                            <ul class="dropdown-menu">
                                              <li>
                                                <div class="yamm-content">
                                                <?php the_content() ?>
                                                 </div>
                                              </li>
                                            </ul>
                                    <?php } ?>

                            </li>

                          <?php } ?>

                 <?php  endwhile;  wp_reset_query(); ?> 
          </ul>
        </div><!--/.nav-collapse -->
        <div class="nav-search">
     
                <?php 
                           add_filter( 'get_search_form', 'werock_search_form' );
                           get_search_form();
                           remove_filter( 'get_search_form', 'werock_search_form' );
                       ?>
        </div>
      </div>
    </nav>  