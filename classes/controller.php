<?php

abstract class Controller {
    protected static $layout = 'base';
    protected static $template = '';
    protected static $chunks = array(
        'head' => 'head',
        'foot' => 'foot',
        'top' => 'top',
    );



    // Начальная инициализация котроллера (объектов вида еще нет, можно переопределить файлы шаблонов)
    protected static function init() {
        Template::$globals['js_files'] = array();
        Template::$globals['css_files'] = array();

        static::$layout = new Template('layouts/' . static::$layout . '.php'); // Создаем объект вида для всей страницы
    }

    // Инициализация чанка 'head'
    protected static function initHead($template) {
        Template::$globals['js_files'][] = 'http://code.jquery.com/jquery-1.11.1.min.js';
    }

    // Создание объектов вида для всех чанков
    protected static function initChunks() {
        foreach (static::$chunks as $chunk => $file) {
            $template = new Template('chunks/' . $file . '.php');

            // Если в текущен классе контроллера определён метод для инициализации чанка, запускаем его
            $class_name = get_called_class(); // Название текщего класса контроллера
            $method_name = 'init' . $chunk; // Название предполагаемого метода
            if (method_exists($class_name, $method_name)) {
                static::$method_name($template);
            }

            static::$layout->templates[$chunk] = $template;
        }
    }

    protected static function initContent() {
        // Определяем папку шаблонов контроллера
        preg_match_all('/[A-Z][^A-Z]*/', str_replace('Controller', '', get_called_class()), $directory);
        $directory = 'pages/' . strtolower(implode('-', $directory[0])) . '/';

        static::$template = new Template($directory . static::$template . '.php');
        static::$layout->templates['content'] = static::$template;
    }

    public static function run() {
        static::init();
        static::initChunks();
        static::initContent();
        return static::$layout->display();
    }

    //тут у нас с Жекой разный подход!!!11
    protected static function initTop($template)
    {
    	if (empty($_SESSION['id_user'])) {
    		$template->back = $_SERVER['REQUEST_URI'];
    	} else {
    		Application::getModel('User', $_SESSION['id_user']);
    		Template::$globals['user'] = new User($_SESSION['id_user']);
    	}
    }
}
