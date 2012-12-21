<?php

/**
 * Admin categories page controller.
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class Categories extends PageController {

    /**
     * The view name.
     */
    const VIEW = 'admin/categories';

    /**
     * The template.
     */
    const TEMPLATE = 'admin/template';

    /**
     * The page title.
     */
    const TITLE = 'Manage Categories';

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
        $data = Category::getList();
        $this->view(
            self::VIEW, 
            self::TEMPLATE,
            $data,
            $request, 
            $session, 
            self::TITLE
        );
    }
    
    /**
     * Adding a new category.
     * 
     * @param array $request 
     */
    public function add($request) {
        
    }
    
    /**
     * Editing a category.
     * 
     * @param array $request 
     */
    public function edit($request) {
        
    }

}