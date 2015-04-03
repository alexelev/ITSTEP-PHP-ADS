<?php

	class Phone extends Model{
		const TABLE = 'phones';
		protected static $fields_description = array(
		    'user_id' => array('type' => DbFieldType::INT, 'required' => true, 'default' => null),		    
		    'phone' => array('type' => DbFieldType::TEXT, 'required' => true, 'default' => null),
		);
		protected static $links_description = array(
	        'user' => array( // Название связи: user
	            'model' => 'User', // Класс модели связанных объектов
	            'type' => DbLinkType::FOREIGN_KEY,
	            'field' => 'user_id',
	        ),
	    );
	}