<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nationality extends CI_Model
{

	public function getAllNationalitys()
	{
		$this->db->select('*');
		$this->db->from('nationality');
		$this->db->order_by('Nationalityname', 'asc');

		$query = $this->db->get();

		return $query->result_array();
	}

}