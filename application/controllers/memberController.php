<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MemberController extends CI_Controller 
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
		$this->load->view('member/home');
		$this->load->view('partials/footer');
	}

	public function admin()
	{
		$this->load->model('member');
		$data['members'] = $this->member->getAllMembers();
		$this->load->model('bloodtype');
		$data['bloodtypes'] = $this->bloodtype->getAllBloodtypes();
		$this->load->model('nationality');
		$data['nationalitys'] = $this->nationality->getAllNationalitys();
		$this->load->model('group');
		$data['groups'] = $this->group->getGroupNames();

		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['Username'];
			$this->load->view('partials/header', $data);
			$this->load->view('admin/member');
			$this->load->view('partials/footer');
		}
		else
		{
			redirect('http://localhost/quiz/welcome', 'refresh');
		}
	}

	public function addMember()
	{
		$this->form_validation->set_rules('membername', 'Member name', 'required');

		if($this->form_validation->run() == true)
		{
			$this->load->model('member');
			$this->member->addMembers();
			$lastMember = $this->member->getLastAddedMember();
			$this->member->addMemberToGroup($lastMember);
		}
		redirect('http://localhost/quiz/admin/member', 'refresh');
	}

	public function getAllMembers()
	{
		$this->load->model('member');
		$result = $this->member->getAllMembers();

		echo json_encode($result);
	}
}
