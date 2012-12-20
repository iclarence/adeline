<?php

/**
 * Admin brands page controller.
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class Brands extends PageController {

    /**
     * The view name.
     */
    const VIEW = 'admin/brands';

    /**
     * The template.
     */
    const TEMPLATE = 'admin/template';

    /**
     * The page title.
     */
    const TITLE = 'Manage Brands';

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
        $data = array();
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