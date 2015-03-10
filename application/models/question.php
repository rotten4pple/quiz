<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Question extends CI_Model
{

	public function addQuestion()
	{
		$this->db->insert('question', array(
			'Quiz_idQuiz' => $_POST['quizId'], 
			'Groups_idGroup' => $_POST['question']
			));
	}

	public function getQuestions()
	{
		$this->db->select('question.idQuestion, question.Quiz_idQuiz, question.Groups_idGroup, groups.Groupname, quiz.Quizname');
		$this->db->from('question');
		$this->db->join('groups', 'groups.idGroup = question.Groups_idGroup');
		$this->db->join('quiz', 'quiz.idQuiz = question.Quiz_idQuiz');

		$query = $this->db->get();

		return $query->result_array();
	}

	public function getLastAddedQuestion()
	{
		$this->db->select('*, groups.Groupname');
		$this->db->from('question');
		$this->db->join('groups', 'groups.idGroup = question.Groups_idGroup');
		$this->db->order_by('idQuestion', 'desc');
		$this->db->limit(1);

		$query = $this->db->get();

		return $query->result_array();
	}

	public function getQuestionsByQuiz($idQuiz)
	{
		$this->db->select('question.idQuestion, question.Quiz_idQuiz, question.Groups_idGroup, groups.Groupname');
		$this->db->from('question');
		$this->db->where('Quiz_idQuiz', $idQuiz); 
		$this->db->join('groups', 'groups.idGroup = question.Groups_idGroup');

		$query = $this->db->get();

		return $query->result_array();
	}

	public function getQuestionsForQuiz($idQuiz)
	{
		$this->db->select('question.idQuestion, groups.Imgname');
		$this->db->from('question');
		$this->db->where('Quiz_idQuiz', $idQuiz); 
		$this->db->join('groups', 'groups.idGroup = question.Groups_idGroup');

		$query = $this->db->get();

		return $query->result_array();
	}

	public function deleteQuestion($idQuestion)
	{
		$this->db->delete('Question', array('idQuestion' => $idQuestion));
	}
}