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
     * @param array $data
     * @param string $title
     * @param string $description
     * @param string $keywords
     */
    protected function view(
        $page = 'Homepage', 
        $template = 'template',
        $data = NULL,
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
     * @param string $extension
     * @return string
     */
    protected function getViewFile($filename, $extension = 'php') {
        return $_SERVER['DOCUMENT_ROOT'] . '/view/' . $filename . '.' . $extension;
    }
    
    /**
     * Returns a link to a file.
     * 
     * @param string $filename
     * @return string
     */
    protected function getLink($filename) {
        return 'http://' . $_SERVER['HTTP_HOST'] . '/' . $filename;
    }

}