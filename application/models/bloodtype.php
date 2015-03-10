<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bloodtype extends CI_Model
{

	public function getAllBloodtypes()
	{
		$this->db->select('*');
		$this->db->from('bloodtype');
		$this->db->order_by('Bloodtypename', 'asc');

		$query = $this->db->get();

		return $query->result_array();
	}

}