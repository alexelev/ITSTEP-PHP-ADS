<?php

	class ControllerAds extends Controller{
		private static $ads_count = 5;

		protected static function init()
		{
			if (isset($_GET['action'])) {
				switch($_GET['action']){
					case 'new':
						static::$template = 'edit';
						break;
					case 'edit':
						static::$template = 'edit';
						break;
				}
			} else if (isset($_GET['id'])){
				static::$template = 'ad';
			} else {
				static::$layout = 'list';
				static::$template = 'list';
				self::$chunks['pagination'] = 'pagination';
			}
			parent::init();
		}

		protected static function initPagination($template)
		{
			$template->page = isset($_GET['page']) ? $_GET['page'] : 1;
			$template->count = Db::getValue("SELECT COUNT(*) FROM `Ads`");
			$template->limit = self::$ads_count;
			$template->controller = 'Ads';
		}

		protected static function initContent()
		{
			if ($_GET['action'] == 'new' || $_GET['action'] == 'edit') {
				Template::$globals['js_files'][] = 'tinymce/tinymce.min.js';
				Template::$globals['js_files'][] = 'jquery.editable.select.min.js';;
			}
			parent::initContent();
			self::fillFormCategories();
			if (isset($_GET['action'])) {
				switch ($_GET['action']) {
					case 'new':
						self::assignContacts();
						if(!empty($_POST)){
							self::procAdForm();
						} 

						break;
					case 'edit':
						self::assignContacts();
						if(!empty($_POST)){
							// echo '<pre>'; var_dump($_GET['id']); echo '</pre>';
							self::procAdForm($_GET['id']);
						}  else {
							$ad = Application::getModel('Ad', $_GET['id']);
							self::$template->title = $ad->title;
							self::$template->desc = $ad->desc;
							self::$template->id = $_GET['id'];
							self::$template->id_category = $ad->id_category;
						}
						break;				
					default:
						# code...
						break;
				}
			} else if ($_GET['id'])	{
				self::$template->ad = Application::getModel('Ad', $_GET['id']);
			} else {
				$page = isset($_GET['page']) ? $_GET['page'] : 1;
				$offset = ($page - 1) * self::$ads_count;
				$query = "SELECT * FROM `ads` LIMIT $offset, ".self::$ads_count;
				self::$template->list = Db::getTable($query);
				//self::$template->pagination = self::$layout->templates['pagination'];
				// echo '<pre>'; var_dump(self::$template->pagination); echo '</pre>';
				// self::$template->pagination->display();
				// die();
			}
				
		}
		
		private static function assignContacts() {
			$user = Application::getModel('User', $_SESSION['id_user']);
			// $contacts = $user->phones;
			// $emails = array();
			// $phones = array();
			
			// foreach($contacts as $contact) {
			// 	if ($contact->type == 1) {
			// 		$emails[] = $contact;
			// 	} else {
			// 		$phones[] = $contact;
			// 	}
			// }
			
			// self::$template->emails = $emails;
			// self::$template->phones = $phones;
			self::$template->phones = $user->phones;

			// echo '<pre>'; var_dump(self::$template); echo '</pre>';
		}

		private static function procAdForm($id = null)
		{
			$errors = array();
			if (empty($_POST['title'])) {
				$errors['title'] = "Введите заголовок объявления";
			}
			if (empty($_POST['desc'])) {
				$errors['desc'] = "Введите текст объявления";
			}
			if (empty($_POST['email'])) {
				$error['email'] = "Введите email";
			}
			if (isset($_POST['capcha']) && 
				$_POST['capcha'] == $_SESSION['capcha']) {
				$validate = true;
			}
			$phoneExists = false;
			foreach ($_POST['phone'] as $phone) {
				if (!empty($phone)) {
					$phoneExists = true;
					break;
				}
			}
			
			if (!$phoneExists) {
				$errors['phone'] = "Введите телефон";
			}
			
			if(empty($errors)){
				$ad = Application::getModel('Ad', $id);					
				$ad->title = $_POST['title'];
				$ad->desc = mysql_real_escape_string($_POST['desc']);
				$ad->id_user = $_SESSION['id_user'];
				$ad->id_category = $_POST['category'];
				//echo '<pre>'; var_dump($ad); echo '</pre>';	die();		
				$ad->save();				
				
				
				
				foreach($_POST['phone'] as $item) {
					if (!empty($item)) {
						$phone = new Phone();
						$phone->user_id = $_SESSION['id_user'];
						$phone->phone = $item;
						$phone->save();	
					}					
				}				
			} else {
				self::$template->errors = $errors;
				self::$template->title = $_POST['title'];
				self::$template->desc = $_POST['desc'];
				self::$template->id = $_GET['id'];
				self::$template->id_category = $_POST['category'];
			}

		}

		private static function fillFormCategories()
		{
			$query = "SELECT * FROM `categories` ORDER BY `title`";
			self::$template->categories = Db::getTable($query);;
		}

	}