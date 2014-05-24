<?php
/*
  Plugin Name: DZS ZoomFolio - WordPress Portfolio
  Plugin URI: http://digitalzoomstudio.net/
  Description: Creates cool portfolios.
  Version: 4.00
  Author: Digital Zoom Studio
  Author URI: http://digitalzoomstudio.net/
 */
include_once(dirname(__FILE__).'/dzs_functions.php');
//include_once(dirname(__FILE__) . '/admin/pagebuilder/pagebuilder.php');

if(!class_exists('DZSPortfolio')){
    include_once(dirname(__FILE__).'/class-dzsp.php');
}


$dzsp = new DZSPortfolio();


if (!function_exists('get_post_meta_all')) {
    function get_post_meta_all($post_id) {
        global $wpdb;
        $data = array();
        $wpdb->query("
            SELECT `meta_key`, `meta_value`
            FROM $wpdb->postmeta
            WHERE `post_id` = $post_id
        ");
        foreach ($wpdb->last_result as $k => $v) {
            $data[$v->meta_key] = $v->meta_value;
        };
        return $data;
    }
}


if (!function_exists('filter_handle_038')) {

    function filter_handle_038($content) {
        $content = str_replace(array("&#038;", "&amp;"), "&", $content);
        return $content;
    }

}

add_filter('the_content', 'filter_handle_038', 199, 1);


define("DZSP_VERSION", "4.00");
if (!function_exists('dzs_excerpt_read_more')) {
    function dzs_excerpt_read_more($pid=0){
        
        global $post;
        $fout = '';
        
        if ($pid == 0) {
            $pid = $post->ID;
        } else {
            $pid = $pid;
        }
        
        $fout.='<br><br><a class="dzsp-readmore" href="'.get_permalink($pid).'">'.__('Read More', 'dzsp').'</a>';
        return $fout;

    }
}