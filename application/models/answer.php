<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Answer extends CI_Model
{
	
	public function addAnswers($lastQuestion, $questionamount)
	{
		for ($i = 1; $i <= $questionamount; $i++) 
		{
			$correct = 0;
			if($lastQuestion[0]['Groupname'] == $this->input->post('answer'.$i))
			{
				$correct = 1;
			}
			$this->db->insert('answer', array(
			'Correct' => $correct, 
			'Question_idQuestion' => $lastQuestion[0]['idQuestion'],
			'AnswerValue' => $this->input->post('answer'.$i)
				));
		}
	}

	public function getAnswers()
	{
		$this->db->select('*');
		$this->db->from('answer');

		$query = $this->db->get();

		return $query->result_array();
	}

	public function getAnswersByQuiz($idQuiz)
	{
		$this->db->select('*');
		$this->db->from('answer');
		$this->db->join('question', 'question.idQuestion = answer.Question_idQuestion');
		$this->db->where('question.Quiz_idQuiz', $idQuiz);
		$this->db->order_by('answer.idAnswer', 'asc');
		// idAnswer, Correct, Groups_idGroup, Question_idQuestion, Quiz_idQuiz, idAnswer, idQuestion

		$query = $this->db->get();

		return $query->result_array();
	}

	public function getAnswersForQuiz($idQuiz)
	{
		$this->db->select('answer.idAnswer, answer.Question_idQuestion, answer.AnswerValue');
		$this->db->from('answer');
		$this->db->join('question', 'question.idQuestion = answer.Question_idQuestion');
		$this->db->where('question.Quiz_idQuiz', $idQuiz);
		//$this->db->order_by('answer.idAnswer', 'asc');
		// idAnswer, Correct, Groups_idGroup, Question_idQuestion, Quiz_idQuiz, idAnswer, idQuestion

		$query = $this->db->get();

		return $query->result_array();
	}

	public function deleteAnswer($idAnswer)
	{
		$this->db->delete('Answer', array('idAnswer' => $idAnswer));
	}

	public function updateAnswer($idAnswer)
	{
		$this->db->where('idAnswer', $idAnswer);
		$this->db->update('Answer', array(
			'AnswerValue' => $_POST['answerValue']
			));
	}

	public function addAnswer($idQuestion)
	{
		$this->db->insert('answer', array(
			'Correct' => 0, 
			'Question_idQuestion' => $idQuestion,
			'AnswerValue' => $_POST['answerValue']
			));
	}

	public function checkAnswers()
	{
		$result['correct'] = 0;
		$result['incorrect'] = 0;
		$quizLength = $this->input->post('quizlength');

		for($i = 0; $i < $quizLength; $i++)
		{ 
			$idAnswer = $this->input->post('answer'.$i);

			if($idAnswer == "timeup")
			{
				$result['incorrect']++;
			}
			else
			{
				$this->db->select('answer.Correct');
				$this->db->from('answer');
				$this->db->where('answer.idAnswer', $idAnswer);
				$query = $this->db->get();
				$correct = $query->result_array();

				if($correct[0]["Correct"] == "1")
				{
					$result['correct']++;
				}
				else
				{
					$result['incorrect']++;
				}
			}
		}

		return $result;
	}
}