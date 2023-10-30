<?php if(!defined('BASEPATH')) exit('No direct script allowed');

class Api_m extends CI_Model{

	function get_user($q) {
		return $this->db->get_where('m_user_api',$q);
	}

	function insert_user($data) {
		return $this->db->insert('m_user_api',$data);
	}
	
}