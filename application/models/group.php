<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Group extends CI_Model
{
	
	public function getGroupNames()
	{
		$this->db->select('idGroup, Groupname');
		$this->db->from('groups');
		$this->db->order_by('Groupname', 'asc');

		$query = $this->db->get();

		return $query->result_array();
	}

	public function getAllGroups()
	{
		$this->db->select('*, label.Labelname');
		$this->db->from('groups');
		$this->db->join('label', 'groups.Label_idLabel = label.idLabel');
		$this->db->order_by('Groupname', 'asc');

		$query = $this->db->get();

		return $query->result_array();
	}

	public function addGroups()
	{
		$this->db->insert('groups', array(
			'Groupname' => $this->input->post('groupname'),
			'Imgname' => $this->input->post('imgname'),
			'Label_idLabel' => $this->input->post('label'),
			'Debut' => $this->input->post('debutdate'),
			'Active' => $this->input->post('active'),
			'Fanclub' => $this->input->post('fanclub'),
			'Color' => $this->input->post('color')
			));
	}

}