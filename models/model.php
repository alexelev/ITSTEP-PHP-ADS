<?php

	class Model{

		private const $table = '';
		private $id;
		private $fields = array();

        //для заполнения массива данными из базы по id
		public function __construct($id = null)
		{
			if ($id) {
				$query = "SELECT * FROM '{$this->table}' WHERE `id` = {$id}";
				$row = Database::getRow($query);
				foreach ($row as $field => $value) {
					if ($field == 'id') {
						$this->id = $value;
					} else {
						$this->fields[$field] = $value;
					}
				}
			}
		}

        //для извлечения значения по ключу из массива
		private function __get($field)
		{
			if (array_key_exists($field, $this->fields)) {
				return $this->fields[$field];
			}
			return null;
		}

        //для записи значения по ключу
		private function __set($field, $value)
		{
			$this->fields[$field] = $value;
		}

        //служебная, для обновления записи по всем полям
		private function update()
		{
			$query = "UPDATE '{$this->table}' SET ";
			foreach ($this->fields as $field => $value) {
				$query .= "`{$field}` = '{$value}', ";
			}
			//убираем запятую с пробелом в последней записи
			rtrim($query, ', ');
			$query .= " WHERE `id` = {$this->id}";
			Database::query($query);
		}

        //служебная, для вставки записи по всем полям
		private function insert()
		{
			$query = "INSERT INTO '{$this->table}' (";
			$query .= '`'.implode('`, `', array_keys($this->fields)).'`';
			$query .= ") VALUES (";
			$query .= "'".implode("', '", $this->fields)."')'";
			Database::query($query);
		}

        //для внесения записи в БД
		public function save()
		{
			if ($this->id) {
				$this->update();
			} else {
				$this->insert();
				$this->id = Database::getInsertId();
			}
		}

		public function getId()
		{
			return $this->id;
		}

	}