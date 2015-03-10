<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Model
{

	public function getAllMembers()
	{
		$this->db->select('idol.*, nationality.Nationalityname, bloodtype.Bloodtypename, groups.Groupname');
		$this->db->from('idol');
		$this->db->join('nationality', 'idol.Nationality_idNationality = nationality.idNationality');
		$this->db->join('bloodtype', 'idol.Bloodtype_idBloodtype = bloodtype.idBloodtype');
		$this->db->join('groups_idol', 'idol.idIdol = groups_idol.Idol_idIdol');
		$this->db->join('groups', 'groups_idol.Group_idGroup = groups.idGroup');
		$this->db->order_by('Idolname', 'asc');

		$query = $this->db->get();

		return $query->result_array();
	}

	public function getLastAddedMember()
	{
		$this->db->select('*');
		$this->db->from('idol');
		$this->db->order_by('idIdol', 'desc');
		$this->db->limit(1);

		$query = $this->db->get();

		return $query->result_array();
	}

	public function addMembers()
	{
		$this->db->insert('idol', array(
			'Idolname' => $this->input->post('membername'),
			'Imgname' => $this->input->post('imgname'),
			'Surname' => $this->input->post('surname'),
			'Birthname' => $this->input->post('birthname'),
			'Birthdate' => $this->input->post('birthdate'),
			'Gender' => $this->input->post('gender'),
			'Height' => $this->input->post('height'),
			'Weight' => $this->input->post('weight'),
			'Bloodtype_idBloodtype' => $this->input->post('bloodtype'),
			'Nationality_idNationality' => $this->input->post('nationality')
			));
	}

	public function addMemberToGroup($lastMember)
	{
		$this->db->insert('Groups_Idol', array(
			'Active' => $this->input->post('active'),
			'Group_idGroup' => $this->input->post('group'),
			'Idol_idIdol' => $lastMember[0]['idIdol']
			));
	}

}