<?php

/**
 * Description of Payment
 *
 * @author Ian Clarence <ian.clarence@gmail.com>
 */
class PageController {

    /**
     * The constructor.
     */
    public function __construct() {
    }
    
    /**
     * Viewing the page. 
     *  
     * @param string $page 
     * @param string $template
     * @param array $request
     * @param array $session
     * @param string $title
     * @param string $description
     * @param string $keywords
     */
    protected function view(
        $page, 
        $template = 'template', 
        $request = NULL, 
        $session = NULL, 
        $title = NULL, 
        $description = NULL, 
        $keywords = NULL
    ) {
        require $this->getViewFile($template);
    }
    
    /**
     * Returns the filepath of a file in view.
     * 
     * @param string $filename 
     * @return string
     */
    protected function getViewFile($filename) {
        return $_SERVER['DOCUMENT_ROOT'] . '/view/' . $filename . '.php';
    }

}