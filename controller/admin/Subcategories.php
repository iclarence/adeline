<?php

/**
 * Admin subcategories page controller.
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class Subcategories extends PageController {

    /**
     * The view name.
     */
    const VIEW = 'admin/subcategories';

    /**
     * The template.
     */
    const TEMPLATE = 'admin/template';

    /**
     * The page title.
     */
    const TITLE = 'Manage Subcategories';

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