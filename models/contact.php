<?php

	class Contact extends Model{
		const TABLE = 'contacts';
		protected static $fields_description = array(
		    'user_id' => array('type' => DbFieldType::INT, 'required' => true, 'default' => null),
		    'type' => array('type' => DbFieldType::INT, 'length' => 1, 'required' => true, 'default' => null),
		    'contact' => array('type' => DbFieldType::TEXT, 'required' => true, 'default' => null),
		);
		protected static $links_description = array(
	        'user' => array( // Название связи: user
	            'model' => 'User', // Класс модели связанных объектов
	            'type' => DbLinkType::FOREIGN_KEY,
	            'field' => 'user_id',
	        ),
	    );
	}