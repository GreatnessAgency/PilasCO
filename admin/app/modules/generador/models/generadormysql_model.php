<?php

class Generadormysql_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}	

	public function createTable($tb){
		//
		$table = $this->db->dbprefix($tb);
		$this->db->query("CREATE TABLE `$table` (
				  `id` int(11) NOT NULL,
				  `shared` int(11) DEFAULT NULL,
				  `lang_id` int(11) DEFAULT NULL,
				  `position` int(11) DEFAULT NULL,
				  `father_id` int(11) DEFAULT NULL,
				  `created` datetime DEFAULT NULL,
				  `modify` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				  `status_id` varchar(10) DEFAULT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
				
			$this->setPrimaryKey($table);
	}
	
	public function setPrimaryKey($table){
		$this->db->query("ALTER TABLE `$table` ADD PRIMARY KEY (`id`);");
		$this->db->query("ALTER TABLE `$table` MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;");
	}
	
	public function columExist($tb, $colum){
		$table = $this->db->dbprefix($tb);
		return $this->db->query("SHOW columns FROM $table like '$colum';")->num_rows();
	}
	
	public function createTableDuplicator($tb){
		//
		$table = $this->db->dbprefix($tb);
		$this->db->query("CREATE TABLE `$table` (
				  `id` int(11) NOT NULL,
				  `content_id` int(11) DEFAULT NULL,
				  `position` int(11) DEFAULT NULL,
				  `created` datetime DEFAULT NULL,
				  `modify` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
				  `status_id` varchar(10) DEFAULT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
				
		$this->setPrimaryKey($table);
	}
	
	public function createTableRelation($tb){
		//
		$table = $this->db->dbprefix($tb);
		$this->db->query("CREATE TABLE `$table` (
				  `id` int(11) NOT NULL,
				  `position` int(11) DEFAULT NULL,
				  `created` datetime DEFAULT NULL
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
				
		$this->setPrimaryKey($table);
	}
	
	public function createField($tb, $name, $after){
		$table = $this->db->dbprefix($tb);
		return $this->db->query("ALTER TABLE `$table` ADD `$name` VARCHAR(255) NULL AFTER `$after`;");
	}
	
	public function createDateField($tb, $name, $after){
		$table = $this->db->dbprefix($tb);
		return $this->db->query("ALTER TABLE `$table` ADD `$name` datetime DEFAULT NULL AFTER `$after`;");
	}
	
	public function createDoubleField($tb, $name, $after){
		$table = $this->db->dbprefix($tb);
		return $this->db->query("ALTER TABLE `$table` ADD `$name` DOUBLE DEFAULT NULL AFTER `$after`;");
	}
	
	public function createIntField($tb, $name, $after){
		$table = $this->db->dbprefix($tb);
		return $this->db->query("ALTER TABLE `$table` ADD `$name` int(11) DEFAULT NULL AFTER `$after`;");
	}
}