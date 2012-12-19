<?php

/**
 * Home page controller.
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class Homepage extends PageController {

    /**
     * The view name.
     */
    const VIEW = 'homepage';

    /**
     * The page title.
     */
    const TITLE = 'Adeline Fogui Store';

    /**
     * The page metatag description.
     */
    const DESCRIPTION = 'Buy clothes online.';

    /**
     * The keywords for the metatag.
     */
    const KEYWORDS = 'clothes, mens clothes, womens clothes, childrens clothes';

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
            'template', 
            $request, 
            $session, 
            self::TITLE, 
            self::DESCRIPTION, 
            self::KEYWORDS
        );
    }

}