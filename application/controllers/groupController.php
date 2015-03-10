<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class GroupController extends CI_Controller 
{
	public function index()
	{
		$data = [];
		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['Username'];
		}
		$this->load->view('partials/header', $data);
		$this->load->view('group/home');
		$this->load->view('partials/footer');
	}

	public function admin()
	{
		$this->load->model('group');
		$data['groups'] = $this->group->getAllGroups();
		$this->load->model('label');
		$data['labels'] = $this->label->getAllLabels();

		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['Username'];
			$this->load->view('partials/header', $data);
			$this->load->view('admin/group');
			$this->load->view('partials/footer');
		}
		else
		{
			redirect('http://localhost/quiz/welcome', 'refresh');
		}
	}

	public function addGroup()
	{
		$this->form_validation->set_rules('groupname', 'Group name', 'required');

		if($this->form_validation->run() == true)
		{
			$this->load->model('group');
			$this->group->addGroups();
		}
		redirect('http://localhost/quiz/admin/group', 'refresh');
	}
}
