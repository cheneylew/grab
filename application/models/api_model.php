<?php

/*
* Links Model
*
* Universally, each URL path maps to a module/controller/method through a global
* record in this table.
*
* @author Electric Function, Inc.
* @copyright Electric Function, Inc.
* @package Hero Framework
*
*/

class Api_model extends CI_Model {
	// initialized in __construct()
	function __construct() {
		parent::__construct();
	}
	function getBuyerList() {
		$sql="select * from customer order by id desc";
		$query = $this->db->query($sql);
		$result_array=$query->result_array();
		return $result_array;
	}
	function updateABuyer($phone,$name,$comment,$email,$id) {
		$data = array(
               '$phone' => $phone,
			   '$name' => $name,
			   'comment' => $comment,
			   'email' => $email,
			   'update_time' => date("Y-m-d H:i:s")
            );

		$this->db->where('id', $id);
		$this->db->update('customer', $data); 
		$affect_rows=$this->db->affected_rows();
		if ($affect_rows>0) {
			return true;
		}else return false;
	}
	function addABuyer($phone,$name,$comment,$email) {
		$data = array(
				'$phone' => $phone,
				'$name' => $name,
				'comment' => $comment,
				'email' => $email,
				'insert_time' => date("Y-m-d H:i:s"),
				'update_time' => date("Y-m-d H:i:s")
		);
	
		$this->db->insert('customer',$data);
		
		$link_id = $this->db->insert_id();
		
		return $link_id;
	}
}