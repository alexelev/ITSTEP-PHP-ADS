<?php

	class Category extends Model{
		const TABLE = 'categories';

	    // Описание связей этой модели с другими. Для автоматической подстновки JOIN в запросы.
	    protected static $links_description = array(

	    );

	    /*
	    // Связь через промежуточные таблицы.

	    protected static $links_description = array(
	        'user' => array( // Название связи: user
	            'model' => 'User', // Класс модели связанных объектов
	            'type' => DbLinkType::TABLE,
	            'table' => array( // Таблица через которую проходит связь
	                'name' => 'ads_user', // Название промежуточной таблицы
	                'field1' => 'id_ad', // id текущей модели
	                'field2' => 'id_user' // id связанной модели
	            )
	        )
	    );
	    /**/

	    // Описание полей модели
	    protected static $fields_description = array(
	        'title' => array('type' => DbFieldType::VARCHAR, 'length' => '255', 'required' => true, 'default' => null),
	    );
	}