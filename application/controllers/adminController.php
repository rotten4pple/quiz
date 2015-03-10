<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class AdminController extends CI_Controller 
{
	public function index()
	{
		$this->load->model('quiz');
		$data['quizzes'] = $this->quiz->getQuizzes();
		$this->load->model('question');
		$data['questions'] = $this->question->getQuestions();
		$this->load->model('answer');
		$data['answers'] = $this->answer->getAnswers();

		$this->load->model('group');
		$data['groups'] = $this->group->getGroupNames();

		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['Username'];
			$this->load->view('partials/header', $data);
			$this->load->view('admin/adminpanel');
			$this->load->view('partials/footer');
		}
		else
		{
			redirect('http://localhost/quiz/welcome', 'refresh');
		}
	}
}
