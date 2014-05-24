<?php

require_once('get_wp.php');
//echo 'ceva';echo $_GET['wpqargs'];
$ajax_wpqargs = json_decode(stripslashes($_GET['wpqargs']));
$ajax_args = json_decode(stripslashes($_GET['args']));

if (isset($_GET['paged'])) {
    $ajax_wpqargs->paged = $_GET['paged'];
}

//print_r($dzsp);

function objectToArray($d) {
    if (is_object($d)) {
        // Gets the properties of the given object
        // with get_object_vars function
        $d = get_object_vars($d);
    }

    if (is_array($d)) {
        /*
         * Return array converted to object
         * Using __FUNCTION__ (Magic constant)
         * for recursive call
         */
        return array_map(__FUNCTION__, $d);
    } else {
        // Return array
        return $d;
    }
}

//print_r($ajax_wpqargs);
//===sanitize vals
//print_r($ajax_wpqargs);

$ajax_wpqargs = objectToArray($ajax_wpqargs);
$ajax_args = objectToArray($ajax_args);

$ajax_query = new WP_Query($ajax_wpqargs);
$ajax_its = $ajax_query->posts;
//print_r($ajax_its); print_r($ajax_args); print_r($ajax_wpqargs);
$aux = $dzsp->parse_items($ajax_its, $ajax_args, $ajax_wpqargs);
echo $aux;
die();