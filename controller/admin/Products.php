<?php

/**
 * Admin products page controller.
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class Products extends PageController {

    /**
     * The view name.
     */
    const VIEW = 'admin/products';

    /**
     * The template.
     */
    const TEMPLATE = 'admin/template';

    /**
     * The page title.
     */
    const TITLE = 'Manage Products';

    /**
     * The constructor.
     */
    public function __construct() {
        parent::__construct();
    }
    
    /**
     * Viewing the page.
     * 
     * @param array $request
     * @param array $session
     */
    public function run($request = NULL, $session = NULL) {
        $data = Product::getList();
        $this->view(
            self::VIEW, 
            self::TEMPLATE,
            $data,
            $request, 
            $session, 
            self::TITLE
        );
    }

}