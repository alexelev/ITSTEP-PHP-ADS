<?php
class Ad extends Model {
	const TABLE = 'ads';

    // Описание связей этой модели с другими. Для автоматической подстновки JOIN в запросы.
    protected static $links_description = array(
        'user' => array( // Название связи: user
            'model' => 'User', // Класс модели связанных объектов
            'type' => DbLinkType::FOREIGN_KEY,
            'field' => 'id_user',            
        ),
        'category' => array(
            'model' => 'Category',
            'type' => DbLinkType::FOREIGN_KEY,
            'field' => 'id_category',            
        )
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
        'desc' => array('type' => DbFieldType::TEXT, 'length' => null, 'required' => false, 'default' => ''),
        'id_user' => array('type' => DbFieldType::INT, 'length' => null, 'required' => true, 'default' => null),
        'id_category' => array('type' => DbFieldType::INT, 'length' => null, 'required' => true, 'default' => null),
    );
}