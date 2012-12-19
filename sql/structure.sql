--
-- Recreating the database `adelinefoguistore`
--
DROP DATABASE IF EXISTS `adelinefoguistore`;
CREATE DATABASE `adelinefoguistore` CHARACTER SET = utf8 COLLATE = utf8_general_ci;

--
-- Giving the user 'irc3'@'localhost' access to the database `irc3`
--
GRANT ALL on `adelinefoguistore`.* TO 'adeline'@'localhost';

--
-- Using the database `adelinefoguistore`
--
USE `adelinefoguistore`;

--
-- Structure for table `google_product_category`
--
CREATE TABLE `google_product_category` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `xml` VARCHAR(200) NOT NULL,

    PRIMARY KEY (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `brand`
--
CREATE TABLE `brand` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,

    PRIMARY KEY (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `size`
--
CREATE TABLE `size` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,

    PRIMARY KEY (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `colour`
--
CREATE TABLE `colour` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,

    PRIMARY KEY (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `material`
--
CREATE TABLE `material` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,

    PRIMARY KEY (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `pattern`
--
CREATE TABLE `pattern` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,

    PRIMARY KEY (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `age_group`
--
CREATE TABLE `age_group` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,

    PRIMARY KEY (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `category`
--
CREATE TABLE `category` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `url_name` VARCHAR(100) NOT NULL,
    `active` INT(11) NOT NULL,
    `priority` INT(11) NOT NULL,

    PRIMARY KEY (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `subcategory`
--
CREATE TABLE `subcategory` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `url_name` VARCHAR(100) NOT NULL,
    `category` INT(11) NOT NULL,
    `active` INT(11) NOT NULL,
    `priority` INT(11) NOT NULL,

    PRIMARY KEY (`id`),

    INDEX `ind_subcategory_ref_category` (`category`),
    FOREIGN KEY `fk_subcategory_ref_category` (`category`) REFERENCES `category` (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `product`
--
CREATE TABLE `product` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(100) NOT NULL,
    `description` TEXT NOT NULL,
    `google_product_category` INT(11) NULL,
    `subcategory` INT(11) NOT NULL,
    `brand` INT(11) NOT NULL,
    `url_name` VARCHAR(100) NOT NULL,
    `price` FLOAT NOT NULL,
    `gender` VARCHAR(10) NOT NULL,
    `active` INT(11) NOT NULL,
    `priority` INT(11) NOT NULL,

    PRIMARY KEY (`id`),

    INDEX `ind_product_ref_gpc` (`google_product_category`),
    FOREIGN KEY `fk_product_ref_gpc` (`google_product_category`) REFERENCES `google_product_category` (`id`),

    INDEX `ind_product_ref_brand` (`brand`),
    FOREIGN KEY `fk_product_ref_brand` (`brand`) REFERENCES `brand` (`id`),

    INDEX `ind_product_ref_subcategory` (`subcategory`),
    FOREIGN KEY `fk_product_ref_subcategory` (`subcategory`) REFERENCES `subcategory` (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `product_image`
--
CREATE TABLE `product_image` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `filename` VARCHAR(100) NOT NULL,
    `product` INT(11) NOT NULL,
    `active` INT(11) NOT NULL,
    `priority` INT(11) NOT NULL,

    PRIMARY KEY (`id`),

    INDEX `ind_product_image_ref_product` (`product`),
    FOREIGN KEY `fk_product_image_ref_product` (`product`) REFERENCES `product` (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `product_size`
--
CREATE TABLE `product_size` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `size` INT(11) NOT NULL,
    `product` INT(11) NOT NULL,
    `active` INT(11) NOT NULL,
    `priority` INT(11) NOT NULL,

    PRIMARY KEY (`id`),

    INDEX `ind_product_size_ref_size` (`size`),
    FOREIGN KEY `fk_product_size_ref_size` (`size`) REFERENCES `size` (`id`),

    INDEX `ind_product_size_ref_product` (`product`),
    FOREIGN KEY `fk_product_size_ref_product` (`product`) REFERENCES `product` (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `product_colour`
--
CREATE TABLE `product_colour` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `colour` INT(11) NOT NULL,
    `product` INT(11) NOT NULL,
    `active` INT(11) NOT NULL,
    `priority` INT(11) NOT NULL,

    PRIMARY KEY (`id`),

    INDEX `ind_product_colour_ref_colour` (`colour`),
    FOREIGN KEY `fk_product_size_ref_size` (`colour`) REFERENCES `colour` (`id`),

    INDEX `ind_product_colour_ref_product` (`product`),
    FOREIGN KEY `fk_product_colour_ref_product` (`product`) REFERENCES `product` (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `product_material`
--
CREATE TABLE `product_material` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `material` INT(11) NOT NULL,
    `product` INT(11) NOT NULL,
    `active` INT(11) NOT NULL,
    `priority` INT(11) NOT NULL,

    PRIMARY KEY (`id`),

    INDEX `ind_product_material_ref_material` (`material`),
    FOREIGN KEY `fk_product_material_ref_material` (`material`) REFERENCES `material` (`id`),

    INDEX `ind_product_material_ref_product` (`product`),
    FOREIGN KEY `fk_product_material_ref_product` (`product`) REFERENCES `product` (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `product_pattern`
--
CREATE TABLE `product_pattern` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `pattern` INT(11) NOT NULL,
    `product` INT(11) NOT NULL,
    `active` INT(11) NOT NULL,
    `priority` INT(11) NOT NULL,

    PRIMARY KEY (`id`),

    INDEX `ind_product_pattern_ref_pattern` (`pattern`),
    FOREIGN KEY `fk_product_pattern_ref_pattern` (`pattern`) REFERENCES `pattern` (`id`),

    INDEX `ind_product_pattern_ref_product` (`product`),
    FOREIGN KEY `fk_product_pattern_ref_product` (`product`) REFERENCES `product` (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `product_age_group`
--
CREATE TABLE `product_age_group` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `age_group` INT(11) NOT NULL,
    `product` INT(11) NOT NULL,
    `active` INT(11) NOT NULL,
    `priority` INT(11) NOT NULL,

    PRIMARY KEY (`id`),

    INDEX `ind_product_age_group_ref_age_group` (`age_group`),
    FOREIGN KEY `fk_product_age_group_ref_age_group` (`age_group`) REFERENCES `age_group` (`id`),

    INDEX `ind_product_age_group_ref_product` (`product`),
    FOREIGN KEY `fk_product_age_group_ref_product` (`product`) REFERENCES `product` (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `customer`
--
CREATE TABLE `customer` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(10) NOT NULL,
    `first_name` VARCHAR(100) NOT NULL,
    `last_name` VARCHAR(100) NOT NULL,
    `email_address` VARCHAR(100) NOT NULL,
    `telephone` VARCHAR(20) NOT NULL,
    `mobile` VARCHAR(20) NULL,
    `address1` VARCHAR(100) NOT NULL,
    `address2` VARCHAR(100) NULL,
    `city` VARCHAR(100) NOT NULL,
    `county` VARCHAR(100) NULL,
    `postcode` VARCHAR(100) NOT NULL,
    `subscribed` DATETIME NULL,

    PRIMARY KEY (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `order`
--
CREATE TABLE `order` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `customer` INT(11) NOT NULL,
    `ordered` DATETIME NOT NULL,

    PRIMARY KEY (`id`),

    INDEX `ind_order_ref_customer` (`customer`),
    FOREIGN KEY `fk_order_ref_customer` (`customer`) REFERENCES `customer` (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `order_product`
--
CREATE TABLE `order_product` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `order` INT(11) NOT NULL,
    `product` INT(11) NOT NULL,
    `price` FLOAT NOT NULL,
    `quantity` INT(11) DEFAULT 1,

    PRIMARY KEY (`id`),

    INDEX `ind_order_product_ref_order` (`order`),
    FOREIGN KEY `fk_order_product_ref_order` (`order`) REFERENCES `order` (`id`),

    INDEX `ind_order_product_ref_product` (`product`),
    FOREIGN KEY `fk_order_product_ref_product` (`product`) REFERENCES `product` (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `payment`
--
CREATE TABLE `payment` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `order` INT(11) NOT NULL,
    `amount` FLOAT NOT NULL,
    `paid` DATETIME NOT NULL,

    PRIMARY KEY (`id`),

    INDEX `ind_payment_ref_order` (`order`),
    FOREIGN KEY `fk_payment_ref_order` (`order`) REFERENCES `order` (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Structure for table `static_page`
--
CREATE TABLE `static_page` (
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `title` VARCHAR(100) NOT NULL,
    `url_name` VARCHAR(100) NOT NULL,
    `content` TEXT NOT NULL,

    PRIMARY KEY (`id`)
)
ENGINE=InnoDB DEFAULT CHARSET=utf8;