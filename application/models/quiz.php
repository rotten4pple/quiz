<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Quiz extends CI_Model
{
	public function addQuiz()
	{
		$this->db->insert('quiz', array('Quizname' => $_POST['quizname']));

		$this->db->select('*');
		$this->db->from('quiz');
		$this->db->order_by('Quizname', 'asc');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function updateQuiz($quizId)
	{
		$this->db->where('idQuiz', $quizId);
		$this->db->update('Quiz', array(
			'Quizname' => $_POST['quizname']
			));
	}

	public function deleteQuiz($quizId)
	{
		$this->db->delete('Quiz', array('idQuiz' => $quizId)); 
	}

	public function getQuizzes()
	{
		$this->db->select('*');
		$this->db->from('quiz');
		$this->db->order_by('Quizname', 'asc');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function getQuizByName($input)
	{
		$this->db->select('*');
		$this->db->from('quiz');
		$this->db->like('Quizname', $input);
		$this->db->order_by('Quizname', 'asc');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function getQuizById($quizId)
	{
		$this->db->select('*');
		$this->db->from('quiz');
		$this->db->where('idQuiz', $quizId);

		$query = $this->db->get();
		return $query->result_array();
	}

	public function getQuizWithDetails($quizId)
	{
		$this->db->select('quiz.*, question.*, answer.*, groups.Groupname');
		$this->db->from('quiz');
		$this->db->where('idQuiz', $quizId);
		$this->db->join('question', 'quiz.idQuiz = question.Quiz_idQuiz');
		$this->db->join('answer', 'question.idQuestion = answer.Question_idQuestion');
		$this->db->join('groups', 'question.Groups_idGroup = groups.idGroup');

		$query = $this->db->get();
		return $query->result_array();
	}
}
