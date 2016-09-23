<?php

/* database core class */

class database {

	public $db;

	public function __construct() {
		try {
			$this->db = new PDO("mysql:host=localhost;dbname=tpltcms","root","");
			//$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERROR_MODE);
		} catch (PDOException $e) {
			echo $e->getMessage();
			die();exit();
		}
	}

}
