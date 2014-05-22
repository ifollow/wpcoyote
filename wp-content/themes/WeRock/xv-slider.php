<?php global $xv_data; //fetch options stored in $xv_data ?>
<!--=================================
Vegas Slider Images 
(Thses imges are being fetch by javascript in main.js file so that user do not need to change javascript. 
 User can also change/update images in main.js directly and remove the following list items )
=================================-->
<?php
	    if(isset($xv_data['switch-bg']) && $xv_data['switch-bg'] ==1 ){
	    	  
	    	
	        if(isset($xv_data['opt-gallery'])){
	            $slides =  explode(",", $xv_data['opt-gallery']);
	        }  //get the slides array
?>
	     	<ul class="vegas-slides hidden">
	           <?php 
	                
		                    
		                	foreach ($slides as $slide) { 
		        ?>
		                    	<li data-fade="<?php if(isset($xv_data['gallery-speed'])) echo $xv_data['gallery-speed']; ?> "><?php  echo wp_get_attachment_image( $slide ,'full'); ?></li>
	                   
	            <?php 		}
	             		
	             ?>
	        </ul>
<?php 
		}
?>


