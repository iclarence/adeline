<!DOCTYPE html>
<html>
    <head>
        <meta name="description" content="<?php echo $description; ?>">
        <meta name="keywords" content="<?php echo $keywords; ?>">
        <meta name="author" content="Ian Clarence">
        <meta charset="UTF-8">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/jquery-ui.min.js"></script>
        <link type = "text/css" rel = "stylesheet" href = "<?php echo $this->getLink('admin/css/style.css'); ?>" />
        <title><?php echo $title; ?></title>
    </head>
    <body>
        <div class="container">
            <div class="header">
            </div>
            <div class="content">
                <div class="left-column">
                    <ul>
                        <li><a href="<?php echo $this->getLink('admin/index.php'); ?>">Admin Home</a></li>
                        <li><a href="<?php echo $this->getLink('admin/index.php?page=categories'); ?>">Categories</a></li>
                        <li><a href="<?php echo $this->getLink('admin/index.php?page=subcategories'); ?>">Subcategories</a></li>
                        <li><a href="<?php echo $this->getLink('admin/index.php?page=brands'); ?>">Brands</a></li>
                        <li><a href="<?php echo $this->getLink('admin/index.php?page=products'); ?>">Products</a></li>
                        <li><a href="<?php echo $this->getLink('admin/index.php?page=static_pages'); ?>">Static Pages</a></li>
                        <li><a href="<?php echo $this->getLink('admin/index.php?page=customers'); ?>">Customers</a></li>
                        <li><a href="<?php echo $this->getLink('admin/index.php?page=orders'); ?>">Orders</a></li>
                    </ul>
                    
                </div>
                <div class="page-content">
                <?php require $this->getViewFile($page); ?>
                </div>
            </div>
            <div class="footer">
            </div>
        </div>
    </body>
</html>