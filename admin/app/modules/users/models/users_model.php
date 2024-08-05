<?php
class Users_model extends CI_Model{
	public function __construct(){
		parent::__construct();
		$this->user = $this->db->dbprefix('usuarios');
	}	
	public function getUsersByLimit($start, $show){
		$sql = "SELECT * FROM $this->user
				ORDER BY id DESC 
				LIMIT $start, $show ";
		$query = $this->db->query($sql);		
		return $query->result();
	}
	public function getUserById($id){
		$sql = "SELECT * FROM $this->user
				WHERE id = $id";
		$query = $this->db->query($sql);
		return $query->row();
	}
}
?>