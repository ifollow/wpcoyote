<?php
require_once('get_wp.php');
//<script src="<?php echo site_url(); "></script>
?>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>The title</title>
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_url'); ?>" media="all" />
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo $dzstr->the_path; ?>tinymce/preview.css"/>

        <?php wp_head(); ?>
    </head>
    <body>
        <?php
                echo do_shortcode('[success]' . $_GET['opt2'] . '[/success]');
        ?>

    </body>
</html> 