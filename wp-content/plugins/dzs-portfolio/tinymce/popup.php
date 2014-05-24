<?php
require_once('get_wp.php');
define('DONOTCACHEPAGE', true);
define('DONOTMINIFY', true);
?>
<!doctype html>
<html lang="en">
    <body>
    <head>
    <meta charset="UTF-8">
    </head>
        <iframe style="width:640px;  height:700px;overflow:auto; border:0;" src="<?php echo $dzsp->thepath; ?>tinymce/popupiframe.php"/>
    </body>
</html>