<?php

	class ControllerOffice extends Controller{

		protected static function init()
		{
			self::$template = 'profile';
			parent::init();
		}

		protected static function initContent()
		{
			if (!empty($_GET['action'])) {
				switch ($_GET['action']) {
					case 'saveProfile':
						$user = Application::getModel('User', $_SESSION['id_user']);
						$user->name = $_POST['name'];
						$user->email = $_POST['email'];
						$user->save();
						break;
					
					case 'saveName':
						$user = Application::getModel('User', $_SESSION['id_user']);
						$response = array(
							'error' => false,
							'message' => ''
						);
						if (empty($_POST['value'])) {
							$response['error'] = true;
							$response['message'] = 'Enter name';
						} else {
							$user->name = $_POST['value'];
							$user->save();
						}
						echo json_encode($response);
						die();
						break;

					case 'saveEmail':
						$user = Application::getModel('User', $_SESSION['id_user']);
						$response = array(
							'error' => false,
							'message' => ''
						);
						if (empty($_POST['value'])) {
							$response['error'] = true;
							$response['message'] = 'Enter email';
						} else {
							$user->email = $_POST['value'];
							$user->save();
						}
						echo json_encode($response);
						die();
						break;

						case 'savePhone':
							$phone = Application::getModel('Phone', $_POST['id']);
							$response = array(
								'error' => false,
								'message' => ''
							);
							if (empty($_POST['value'])) {
								$response['error'] = true;
								$response['message'] = 'Enter phone';
							} else {
								$phone->phone = $_POST['value'];
								$phone->save();
							}
							echo json_encode($response);
							die();
							break;

					default:
						# code...
						break;
				}
			}
			parent::initContent();
			self::$template->user = Application::getModel('User', $_SESSION['id_user']);
			
		}

	}