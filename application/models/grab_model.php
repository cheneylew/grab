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

class Grab_model extends CI_Model {
	// initialized in __construct()
	function __construct() {
		parent::__construct();
	}
	function new_ganji ($yuan=0, $title='', $content='', $date='', $adds='', $url='',$tag='') {
	
		$insert_fields = array(
								'yuan' => intval($yuan),
								'title' => $title,
								'content' => $content,
								'date' => $date,
								'adds' => $adds,
								'url' => $url,
								'insert_time' => date("Y-m-d h:i:s"),
								'tag'=>$tag
							);
							
		$this->db->insert('ganji',$insert_fields);
		
		$link_id = $this->db->insert_id();
		
		return $link_id;
	}
}