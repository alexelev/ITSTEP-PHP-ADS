<?php
class User extends Model{
	const TABLE = 'users';


    protected static $fields_description = array(
        'login' => array('type' => DbFieldType::VARCHAR, 'length' => 255, 'required' => true, 'default' => null),
        'password' => array('type' => DbFieldType::VARCHAR, 'length' => 255, 'required' => true, 'default' => null),
        'email' => array('type' => DbFieldType::VARCHAR, 'length' => 255, 'required' => true, 'default' => null),
        'name' => array('type' => DbFieldType::VARCHAR, 'length' => 255, 'required' => true, 'default' => null),
    );

    protected static $links_description = array(
        'ads' => array( // Название связи: user
            'model' => 'Ad', // Класс модели связанных объектов
            'type' => DbLinkType::PRIMARY_KEY,
            'field' => 'id_user',
        ),
        'phones' => array(
        	'model' => 'Phone',
        	'type' => DbLinkType::PRIMARY_KEY,
            'field' => 'user_id',
       	),
    );


	public static function getByLoginPassword($login, $password){
		
		$password = md5($password);
		$query = "SELECT * FROM `".self::TABLE."`
				WHERE `login` = '$login' AND `password` = '$password'";
		$row = Db::getRow($query);
		if ($row){
			$user = new self();
			$user->fillFromArray($row);
			return $user;
		}
		return null;
	}

	public function getAds(){
		$query = "SELECT * FROM `ads` AS `a`
		LEFT JOIN `ads_user` AS `au` ON `a`.`id` = `au`.`id_ad`
		WHERE `au`.`id_user` = {$this->id}";
		$array = Db::getTable($query);
		$ads = array();
		foreach ($array as $row) {
			$ad = new Ad();
			$ad->fillFromArray($row);
			$ads[] = $ad;
		}
		return $ads;
	}

}