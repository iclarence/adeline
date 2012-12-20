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
                        <li><a href="<?php echo $this->getLink('admin/index.php?page=Categories'); ?>">Categories</a></li>
                        <li><a href="<?php echo $this->getLink('admin/index.php?page=Subcategories'); ?>">Subcategories</a></li>
                        <li><a href="<?php echo $this->getLink('admin/index.php?page=Brands'); ?>">Brands</a></li>
                        <li><a href="<?php echo $this->getLink('admin/index.php?page=Products'); ?>">Products</a></li>
                        <li><a href="<?php echo $this->getLink('admin/index.php?page=StaticPages'); ?>">Static Pages</a></li>
                        <li><a href="<?php echo $this->getLink('admin/index.php?page=Customers'); ?>">Customers</a></li>
                        <li><a href="<?php echo $this->getLink('admin/index.php?page=Orders'); ?>">Orders</a></li>
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