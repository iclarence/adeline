<!DOCTYPE html>
<html>
    <head>
        <meta name="description" content="<?php echo $description; ?>">
        <meta name="keywords" content="<?php echo $keywords; ?>">
        <meta name="author" content="Ian Clarence">
        <meta charset="UTF-8">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
        <title><?php echo $title; ?></title>
    </head>
    <body>
        <?php require $this->getViewFile($page); ?>
    </body>
</html>