<?php

class Application {

    // Вместо файла init.php теперь используем функцию.
    public static function init($config_file) {
        // Подключаем конфиг
        include_once $config_file;

        // Регистрируем функцию автозагрузки классов
        spl_autoload_register('Application::loadClass');

        // Подключаемся к базе
        DB::connect(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);

        // Отправляем заголовок с кодировкой
        header('Content-type: text/html; charset=utf-8');

        // Запуск сессии
        session_start();
    }

    // Функция автозагрузки классов (можно вызывать в коде вручную)
    public static function loadClass($class_name, $dir = 'classes') {
        if (!($class_exists = class_exists($class_name))) {
            $file_name = strtolower($class_name); // Преобразуем название класса в нижний регистр

            if (file_exists(ABSPATH . "/$dir/$file_name.php")) {
                include_once ABSPATH . "/$dir/$file_name.php";
            }

            $class_exists = class_exists($class_name);
        }
        return $class_exists;
    }

    public static function loadControllerClass($controller) {
        $file_name = strtolower(str_replace('Controller', '', $controller));
        $class_name = ((strpos($controller, 'Controller') === false) ? 'Controller' . $controller : $controller);
        if (!($class_exists = class_exists($class_name))) {
            if (file_exists(ABSPATH . "/controllers/$file_name.php")) {
                include_once ABSPATH . "/controllers/$file_name.php";
            }
            $class_exists = class_exists($class_name);
        }
        return $class_exists;
    }

    public static function loadModelClass($class_name) {
        return self::loadClass($class_name, 'models');
    }

    // Функция загружает класс модели и возвращает объект модели если указан id
    public static function getModel($class_name, $id = null) {
        if (!($class_exists = class_exists($class_name))) {
            $class_exists = self::loadModelClass($class_name);
        }

        if ($class_exists) {
            // Имя класса может быть в переменной, так же можно делать с функциями и с переменными.
            return $id ? new $class_name($id) : new $class_name();
        }

        return $class_exists;
    }

    // функция возвращает адрес страницы
    // контроллер можно указывать по имени класса либо в виде my-controller-name
    public static function getLink($controller, $params = array()) {
        if (strpos($controller, '-') === false) {
            preg_match_all('/[A-Z][^A-Z]*/', str_replace('Controller', '', $controller), $result);
            $controller = strtolower(implode('-', $result[0]));
        }
        $link = '/index.php?controller=' . $controller;

        foreach ($params as $key => $value) {
            if (!empty($value))
                $link .= '&' . urlencode($key) . '=' . urlencode($value);
        }
        return $link;
    }

    public static function run() {
        if (isset($_GET['controller'])) {
            $controller = explode('-', $_GET['controller']);
            foreach ($controller as $index => $part) {
                $controller[$index] = ucfirst($part);
            }
            $controller = 'Controller' . implode('', $controller);
        } else {
            $controller = 'ControllerIndex';
        }

        if (self::loadControllerClass($controller, 'controllers')) {
            return $controller::run();
        } else {
            self::loadClass('Controller404', 'controllers');
            return Controller404::run();
        }
    }
}
