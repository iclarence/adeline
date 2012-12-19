<?php

/**
 * Admin home page controller.
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class AdminHomepage extends PageController {

    /**
     * The view name.
     */
    const VIEW = 'admin/homepage';

    /**
     * The page title.
     */
    const TITLE = 'Adeline Fogui Store Admin';

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
        $this->view(
            self::VIEW, 
            'admin/template', 
            $request, 
            $session, 
            self::TITLE,
            '',
            ''
        );
    }

}