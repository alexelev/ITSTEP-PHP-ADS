<?php

	class ControllerFavourites extends Controller{
		protected static $template = 'list';
		protected static $layout = 'list';
		private static $ads_count = 2;

		protected static function init()
		{
			if (!isset($_GET['action'])) {
				self::$chunks['pagination'] = 'pagination';
			}
			parent::init();
		}

		protected static function initPagination($template)
		{
			$template->page = isset($_GET['page']) ? $_GET['page'] : 1;
			$template->count = isset($_SESSION['favourites']) ? count($_SESSION['favourites']) : 0;
			$template->limit = self::$ads_count;
			$template->controller = 'Favourites';
		}

		protected static function initContent()
		{
			parent::initContent();
			if (isset($_GET['action'])) {
				switch ($_GET['action']) {
					case 'add':
						if (!isset($_SESSION['favourites'])) {
							$_SESSION['favourites'] = array();
						}
						if (!in_array($_GET['id'], $_SESSION['favourites'])) {
							$_SESSION['favourites'][] = $_GET['id'];
						}
						break;
					
					case 'del':
						array_splice($_SESSION['favourites'], array_search($_GET['id'], $_SESSION['favourites']), 1);
						$_SESSION['favourites'] = array_values($_SESSION['favourites']);
						break;

					default:
						# code...
						break;
				}
				header('Location: '.Application::getLink('Ads', array('id' => $_GET['id'])));
			} else {
				$ides = isset($_SESSION['favourites']) ? implode(',', $_SESSION['favourites']) : 'null';
				$page = isset($_GET['page']) ? $_GET['page'] : 1;
				$ofset = ($page - 1) * self::$ads_count;
				$query = "SELECT * FROM `Ads` WHERE `id` IN ({$ides}) LIMIT {$ofset},".self::$ads_count;
				// echo $query;
				// die();
				$ads = Db::getTable($query, 'id');
				$result = array();
				// echo '<pre>'; var_dump($_SESSION['favourites']); echo '</pre>';
				if (isset($_SESSION['favourites'])) {
					foreach (array_reverse($_SESSION['favourites']) as $id) {
						$result[] = $ads[$id];
					}	
				}
				self::$template->list = $result;
				// echo '<pre>'; var_dump(self::$template->list); echo '</pre>';
				
			}
		}
	}