<?php

	class Database{
		
		static public function connect($hostname, $login, $password,$db_name){
			mysql_connect($hostname, $login, $password) or mysql_error();
			mysql_select_db($db_name) or mysql_error();
		}

		//выполнение запросов INSERT, UPDATE, DELETE
		static public function query($query)
		{
			return ((mysql_query($query) != false) ? true : false);
		}

        //для получения значения по ключу
		static public function getValue($query)
		{
			$result = mysql_query($query);
			if($result){
				return current(mysql_fetch_array($result));
			}
		}

        //для получения записи из БД
		static public function getRow($query)
		{
			$result = mysql_query($query);
			return mysql_fetch_assoc($result);
		}

        //для получения выборки из БД
		static public function getTable($query, $index = null)
		{
			$result = mysql_query($query);
			$array = array();
			while($row = mysql_fetch_assoc($result)){
				if($index){
					$array[$row[$index]] = $row;
				} else {
					$array[] = $row;
				}
			}
			return $array;
		}

		static public function getInsertId()
		{
			return mysql_insert_id();
		}
	}