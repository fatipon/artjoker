<?php

namespace app;

use PDO;

class Database {

	protected $db;
	
	public function __construct()
    {
        $config = require 'config/database.php';
        $this->db = new PDO(
            'mysql:host=' . $config['host'] . ';dbname=' . $config['database'] . '',
            $config['username'],
            $config['password']
        );
        $this->db->query("SET NAMES 'utf8'");
	}

	public function query($sql) {
		$stmt = $this->db->prepare($sql);
		$stmt->execute();
		return $stmt;
	}

	public function row($sql) {
		$result = $this->query($sql);
		return $result->fetchAll(PDO::FETCH_ASSOC);
	}

	public function column($sql) {
		$result = $this->query($sql);
		return $result->fetchColumn();
	}

	public function lastInsertId() {
		return $this->db->lastInsertId();
	}

}