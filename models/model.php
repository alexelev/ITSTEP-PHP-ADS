<?php

	class Model{

		private const $table = '';
		private $id;
		private $fields = array();

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

		private function __get($field)
		{
			if (array_key_exists($field, $this->fields)) {
				return $this->fields[$field];
			}
			return null;
		}

		private function __set($field, $value)
		{
			$this->fields[$field] = $value;
		}

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

		private function insert()
		{
			$query = "INSERT INTO '{$this->table}' (";
			$query .= '`'.implode('`, `', array_keys($this->fields)).'`';
			$query .= ") VALUES (";
			$query .= "'".implode("', '", $this->fields)."')'";
			Database::query($query);
		}

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