<?php


class Page {
    private $title, $stylesheets=array(), $javascripts=array(), $body;

    function Page() {
        $this->addCSS('../assets/css/all.css');
        $this->addCSS('../assets/css/sample_pages/buttons-icons.css');
       // $this->addJavascript('../assets/js/resize.js');
        $this->addJavascript('../assets/js/all.js');
    }

    function setTitle($title) {
        $this->title = $title;
    }

    function addCSS($path) {
        $this->stylesheets[] = $path;
    }

    function addJavascript($path) {
        $this->javascripts[] = $path;
    }

    function startBody() {
        ob_start();
    }

    function endBody() {
        $this->body = ob_get_clean();
    }

    function render($path) {
        ob_start();
        include($path);
        return ob_get_clean();
    }

}
