<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LoginController extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user', '', true);
	}

	public function index()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required|callback_check_database');

		$data = [];
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['Username'];
		}

		if($this->form_validation->run() == false)
		{	
			$this->load->view('partials/header', $data);
			$this->load->view('welcome_message');
			$this->load->view('partials/footer');
		}
		else
		{
			redirect('http://localhost/quiz/welcome', 'refresh');
		}
	}

	public function check_database($password)
	{
		$username = $this->input->post('username');

		$result = $this->user->login($username, $password);

		if($result)
		{
			$sess_array = array();

			foreach ($result as $row) 
			{
				$sess_array = array(
					'idUser' => $row->idUser,
					'Username' => $row->Username
					);
				$this->session->set_userdata('logged_in', $sess_array);
			}
			return true;
		}
		else
		{
			$this->form_validation->set_message('check_database', 'Invalid username or password');
			return false;
		}
	}

	public function logout()
	{
		$array_items = array('idUser' => '', 'Username' => '', 'logged_in' => '');
		$this->session->unset_userdata($array_items);
		redirect('http://localhost/quiz/welcome', 'refresh');
	}
}