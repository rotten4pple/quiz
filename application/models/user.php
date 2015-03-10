<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Model
{
	public function login($username, $password)
	{
		$this->db->select('idUser, Username, Password');
		$this->db->from('Users');
		$this->db->where('Username', $username);
		$this->db->where('Password', MD5($password));
		$this->db->limit(1);

		$query = $this->db->get();

		if($query -> num_rows() == 1)
		{
			return $query->result();
		}
		else
		{
			return false;
		}
	}
}
