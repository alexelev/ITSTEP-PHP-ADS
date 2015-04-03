<?php

class ControllerUser extends Controller {
    
    private static $ads_count = 5;

    protected static function init() {        
		Application::loadModelClass('User');
        if (isset($_GET['action'])) {
            self::$template = $_GET['action'];
        } else {
            self::$template = 'cabinet';
        }

        if ($_GET['action'] == 'ads') {
            static::$layout = 'list';
            self::$chunks['pagination'] = 'pagination';            
        }

        parent::init();
    }

    protected static function initPagination($template)
    {
        $template->page = isset($_GET['page']) ? $_GET['page'] : 1;
        $template->count = Db::getValue("SELECT COUNT(*) FROM `Ads` WHERE `id_user` = ".$_SESSION['id_user']);
        // echo '<pre>'; var_dump($template->count); echo '</pre>';
        $template->limit = self::$ads_count;
        $template->controller = 'User';
        $template->action = $_GET['action'];
    }

    protected static function initContent() {
        parent::initContent();
        //echo '<pre>'; var_dump(self::$template); echo '</pre>'; die();

        $errors = array();

        switch ($_GET['action']) {
            case 'login' :
                if (!empty($_POST)) {
                    if (empty($_POST['login'])) $errors[] = 'Введите логин';
                    if (empty($_POST['password'])) $errors[] = 'Введите пароль';

                    if (empty($errors)) {                        

                        if ($user = User::getByLoginPassword($_POST['login'], $_POST['password'])) {
                            $_SESSION['id_user'] = $user->getId();
                            //echo '<pre>'; var_dump($_POST['back']); echo '</pre>'; die();
                            header('Location: '.$_POST['back']);
                        } else {
                            $errors[] = 'Неверный логин или пароль';
                        }
                    }

                    self::$template->login = $_POST['login'];
                    self::$template->back = $_POST['back'];
                    //header('Location: /');
                } else {
                	self::$template->back = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
                }
                break;
            case 'register':
	            if (!empty($_POST)){
	            	if (empty($_POST['login'])) {
	                	$errors[] = "Введите логин";
	                }
	                if (empty($_POST['email'])) {
	                	$errors[] = "Введите email";
	                }
	                if (empty($_POST['pass'])) {
                		$errors[] = "Введите пароль";
                	} elseif ($_POST['pass'] != $_POST['confirm']) {
                		$errors[] = "Введите потверждение пароля";
                	}
                	if (empty($errors)){
                		$user = new User();
                		$user->login = $_POST['login'];
                		$user->email = $_POST['email'];
                		$user->password = md5($_POST['pass']);
                		$user->save();
                		$_SESSION['id_user'] = $user->getId();
                		header('Location: /');
                	}
	            }
            	break;
            case 'ads':
                $page = isset($_GET['page']) ? $_GET['page'] : 1;
                $offset = ($page - 1) * self::$ads_count;
                $query = "SELECT * FROM `ads` WHERE `id_user` = ".$_SESSION['id_user']." LIMIT $offset, ".self::$ads_count;
                // echo '<pre>'; var_dump($query); echo '</pre>';
                self::$template->list = Db::getTable($query);
                break;
            case 'logout':
                unset($_SESSION['id_user']);
                header('Location: '.Application::getLink('User', array('action' => 'login')));
                break;
        }

        self::$template->errors = $errors;
    }
}