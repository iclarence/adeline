<?php

/**
 * General constants which will be the same for all subdomains.
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */

/**
 * Basic constants. 
 */
define('YES', 1);
define('NO', 0);
define('ON', 1);
define('OFF', 0);

/**
 * Servers to be running on: dev, test or live:
 * they correspond to id values in table `server_type`.
 */
define('DEVELOPMENT_SERVER', 0);
define('TEST_SERVER', 1);
define('LIVE_SERVER', 2);

/**
 * Is this server dev, test or live?
 */
define('SERVER', DEVELOPMENT_SERVER);

/**
 * Running mode: normal or debugging.
 * When set ON, the page data is displayed, instead of the page.
 */
define('DEBUGGING_MODE', OFF);

/**
 * Use APC for data caching. 
 */
define('USE_DATA_CACHING', NO);

/**
 * Caches output from database calls.
 */
define('STORED_AS_CACHE', USE_DATA_CACHING);

/**
 * Cachess all the data required for the rendering of a page. 
 */
define('STORE_PAGE_DATA_AS_CACHE', USE_DATA_CACHING);

/**
 * Shows all the template variables underneath the footer.
 * Very useful when in development. 
 */
define('SHOW_TEMPLATE_VARIABLES', YES);

/**
 * Show stats in the view fields. 
 */
define('SHOW_STATS', NO);

/**
 * How to render each page: use standard HTML using the view fields in an associative array, OR
 * use the view fields as XML with an XSL stylesheet. 
 */
define('USE_XSLT', NO);

/**
 * Whether to use the $object property of the Component class, or $fields the associative array. 
 */
define('USE_COMPONENT_OBJECT', FALSE);

/**
 * Character set.
 */
define('CHARSET', 'UTF-8');

/**
 * Database connectivity.
 */
switch (SERVER) {
    case DEVELOPMENT_SERVER:
        define('DB_SERVER', 'localhost');
        define('DB_USER', 'adeline');
        define('DB_PASSWORD', 'adeline');
        define('DB', 'adeline');
        break;
    case TEST_SERVER:
        define('DB_SERVER', 'localhost:/tmp/mysql5.sock');
        define('DB_USER', 'adeline');
        define('DB_PASSWORD', 'adeline');
        define('DB', 'adelinefoguistore_iclarence_com');
        break;
    case LIVE_SERVER:
        define('DB_SERVER', 'localhost');
        define('DB_USER', 'adeline');
        define('DB_PASSWORD', 'adeline');
        define('DB', 'adelinefoguistore_com');
        break;
}

/**
 * jQuery and jQuery UI versions.
 */
define('JQUERY_VERSION', '1.7.1');
define('JQUERY_UI_VERSION', '1.8.18');

/**
 * Panel and article types relating to page content. 
 */
define('CONTENT_PANEL_TYPE', 5);
define('CONTENT_ARTICLE_TYPE', 5);

/**
 * Is this a multilingual site? 
 */
define('IS_MULTILINGUAL_SITE', YES);

/**
 * Is this an affiliate site? 
 */
define('HAS_AFFILIATE_PROGRAM', YES);

/**
 * Image size. 
 */
define('IMAGE_SIZE', 450);

/**
 * Body font size. 
 */
define('BODY_FONT_SIZE', 10);

/**
 * Standard colours. 
 */
define('GREY1', '#E0E0E0');
define('GREY2', '#C0C0C0');
define('GREY3', '#A0A0A0');
define('GREY4', '#808080');

define('BLUE1', '#D0E0FF');
define('BLUE2', '#B0C0DD');
define('BLUE3', '#90A0BB');
define('BLUE4', '#708099');

define('GREEN1', '#D0FFD0');
define('GREEN2', '#B0DDB0');
define('GREEN3', '#90BB90');
define('GREEN4', '#709970');

define('RED1', '#FF4000');

define('WHITE1', '#FFFFFF');
define('WHITE2', '#F0F0F0');

define('BLACK1', '#000000');
define('BLACK2', '#101010');

/**
 * Prefixes to article pages and pagination. 
 */
define('PAGINATION_PREFIX', 'page_');
define('ARTICLE_PREFIX', 'article_');
define('AFFILIATE_ID_PREFIX', 'affid_');

/**
 * Pseudo-file and resource file names. 
 */
define('DEFAULT_FILENAME', 'default.html');
define('HTML_FILENAME', 'page.html');
define('XML_PAGE_FILENAME', 'page.xml');
define('XML_DATA_FILENAME', 'data.xml');
define('CSS_FILENAME', 'style.css');
define('JAVASCRIPT_FILENAME', 'script.js');
define('FEED_FILENAME', 'feed.xml');
define('XSL_FILENAME', 'style.xsl');
define('AJAX_FILENAME', 'ajax.php');
define('PROCESS_FILENAME', 'process.php');

define('AJAX_FILE_EXTENSION', 'php');
define('CSS_FOLDER', 'styles');
define('JAVASCRIPT_FOLDER', 'scripts');