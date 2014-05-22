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
       
         

               <?php

                 wp_nav_menu(
                        array(
                            'theme_location' => 'main',
                            'menu' => 'dropdown-menu',
                            'container_class' => 'navbar-collapse collapse',
                            'menu_class' => 'responsive-dropdown nav navbar-nav',
                            'fallback_cb' => '',
                            'menu_id' => 'home-menu',
                            'walker' => new Bootstrapwp_Walker_Nav_Menu()
                        )
                    ); 
              
               
               ?>
    
            <div class="nav-search">
                <?php 
                     add_filter( 'get_search_form', 'werock_search_form' );
                     get_search_form();
                     remove_filter( 'get_search_form', 'werock_search_form' );
                ?>
        </div>
      </div>
    </nav>