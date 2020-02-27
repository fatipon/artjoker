<?php

namespace app;

class Main extends Model {

	public function getRegions($route) {
	    $sql = "SELECT * FROM " . DATA_TABLE . " WHERE ter_level = 1";
		return $this->db->row($sql);
	}

	public function getCities($route, $region) {
	    $sql = "SELECT * FROM " . DATA_TABLE . " WHERE `ter_level`= 2 AND `reg_id`=( SELECT `reg_id` FROM " . DATA_TABLE . " WHERE `ter_id`= $region)";
		return $this->db->row($sql);
	}

	public function getDistricts($route, $city) {
	    $sql = "SELECT * FROM " . DATA_TABLE . " WHERE `ter_level` > 2 AND `ter_pid`= $city";
		return $this->db->row($sql);
	}

    public function hasTable($table) {
        $sql = "SHOW TABLES LIKE '" . $table . "'";
        $result = $this->db->column($sql);
        if (! empty($result)){
            return true;
        }
        return false;
    }

    public function createTable($table) {
        $sql = "CREATE TABLE $table (
            id int NOT NULL AUTO_INCREMENT,
            name varchar(255) NOT NULL,
            email varchar(255) NOT NULL,
            location varchar(255) NOT NULL,
            PRIMARY KEY (id)
        );";
        $result = $this->db->query($sql);
    }

    public function getUserEmail($email) {
        $sql = "SELECT * FROM " . USERS_TABLE . " WHERE `email` = '" . $email . "'";
        return $this->db->row($sql);
	}

    public function addUser($data) {
	    if(!empty($data['district'])) {
            $sql = "SELECT ter_address FROM " . DATA_TABLE . " WHERE `ter_id` = '" . $data['district'] . "'";
        } else {
            $sql = "SELECT ter_address FROM " . DATA_TABLE . " WHERE `ter_id` = '" . $data['city'] . "'";
        }
        $location = $this->db->column($sql);
        $sql = "INSERT INTO " . USERS_TABLE . " (name, email, location)
            VALUES ('" . $data['name'] ."', '" . $data['email'] . "', '" . $location . "');";
        $result = $this->db->query($sql);
    }

}