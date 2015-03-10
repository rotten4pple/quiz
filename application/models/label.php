<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Label extends CI_Model
{

	public function getAllLabels()
	{
		$this->db->select('*');
		$this->db->from('label');
		$this->db->order_by('Labelname', 'asc');

		$query = $this->db->get();

		return $query->result_array();
	}

}