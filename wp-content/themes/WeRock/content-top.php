
<?php
global $xv_data;
?>


<!--=================================
bread crums
=================================-->
  <section class="breadcrumb">
      
       <div class="container">
          <div class="row">
              <div class="col-lg-6 col-md-6 col-sm-6">
                  <h1><?php 
                  echo "Teste"
                  ?></h1>
                    <h5> <?php 
                              $saved_data = get_post_meta($post->ID,'xv_page-subtitle',true);
                              echo $saved_data;

                            ?>
                    </h5>
                </div>
                
                <div class="col-lg-6 col-md-6 col-sm-6">
              <?php if (function_exists('werock_breadcrumbs')) { werock_breadcrumbs();} ?>
          </div>
       </div>
  </section>
<div class="clearfix"></div>
