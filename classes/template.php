<?php

class Template {
    public static $globals = array();

    protected $vars = array();
    protected $file = '';

    public $templates = array();

    public function __construct($file) {
        $this->file = $file;
    }

    public function __get($name) {
        if (isset($this->vars[$name])) {
            return $this->vars[$name];
        }

        if (isset(self::$globals[$name])) {
            return self::$globals[$name];
        }

        return null;
    }

    public function __set($name, $value) {
        $this->vars[$name] = $value;
    }

    public function display() {
        ob_start();
        include ABSPATH . '/templates/' . $this->file;
        return ob_get_clean();
    }

    public function displayChild($name) {
        if (array_key_exists($name, $this->templates)) {
            return $this->templates[$name]->display();
        }
    }
}