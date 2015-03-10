<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class QuizController extends CI_Controller 
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('quiz');
		$this->load->model('question');
		$this->load->model('answer');
	}

	// QUIZ-PAGINA'S

	public function quizList()
	{
		$data['quizzes'] = $this->quiz->getQuizzes();

		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['Username'];
		}

		$this->load->view('partials/header', $data);
		$this->load->view('quiz/quizlist');
		$this->load->view('partials/footer');
	}

	public function playQuiz($quizId)
	{
		$questions = $this->question->getQuestionsForQuiz($quizId);
		$questionsLength = count($questions);
		$answers = $this->answer->getAnswersForQuiz($quizId);
		$answersLength = count($answers);
		$data['quizId'] = $quizId;
		$data['questions'] = $questions;

		for($i = 0; $i < $questionsLength; $i++)
		{
			$data['questions'][$i]['Answers'] = [];
			for($j = 0; $j < $answersLength; $j++)
			{ 
				if($questions[$i]['idQuestion'] == $answers[$j]['Question_idQuestion'])
				{
					array_push($data['questions'][$i]['Answers'], $answers[$j]);
				}
			}
		}

		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['Username'];
		}

		$this->load->view('partials/header', $data);
		$this->load->view('quiz/playquiz');
		$this->load->view('partials/footer');
	}

	public function admin()
	{
		$data['quizzes'] = $this->quiz->getQuizzes();

		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['Username'];
			$this->load->view('partials/header', $data);
			$this->load->view('admin/home');
			$this->load->view('partials/footer');
		}
		else
		{
			redirect('http://localhost/quiz/welcome', 'refresh');
		}	
	}

	public function quiz($quizId)
	{
		$data['quizzes'] = $this->quiz->getQuizById($quizId);
		$data['questions'] = $this->question->getQuestionsByQuiz($quizId);
		$data['answers'] = $this->answer->getAnswers();

		$this->load->model('group');
		$data['groups'] = $this->group->getGroupNames();

		if($this->session->userdata('logged_in'))
		{
			$session_data = $this->session->userdata('logged_in');
			$data['username'] = $session_data['Username'];
			$this->load->view('partials/header', $data);
			$this->load->view('admin/quiz');
			$this->load->view('partials/footer');
		}
		else
		{
			redirect('http://localhost/quiz/welcome', 'refresh');
		}
	}

	// PLAY-QUIZ

	public function getPlayQuiz($quizId)
	{
		$questions = $this->question->getQuestionsForQuiz($quizId);
		$questionsLength = count($questions);
		$answers = $this->answer->getAnswersForQuiz($quizId);
		$answersLength = count($answers);
		$data['quizId'] = $quizId;
		$data['questions'] = $questions;

		for($i = 0; $i < $questionsLength; $i++)
		{
			$data['questions'][$i]['Answers'] = [];
			for($j = 0; $j < $answersLength; $j++)
			{ 
				if($questions[$i]['idQuestion'] == $answers[$j]['Question_idQuestion'])
				{
					array_push($data['questions'][$i]['Answers'], $answers[$j]);
				}
			}
		}

		echo json_encode($data);
	}

	public function checkAnswers()
	{
		$result = $this->answer->checkAnswers();

		echo json_encode($result);
	}

	// QUIZ-ADMIN

	public function updateQuiz($quizId)
	{
		$this->form_validation->set_rules('quizname', 'Quiz name', 'required');

		if($this->form_validation->run() == true)
		{
			$this->quiz->updateQuiz($quizId);
		}
		redirect('http://localhost/quiz/admin/quiz', 'refresh');
	}

	public function addQuiz()
	{
		$this->form_validation->set_rules('quizname', 'Quiz name', 'required');

		if($this->form_validation->run() == true)
		{
			$response = $this->quiz->addQuiz();
			echo json_encode($response);
		}
	}

	public function getQuiz($input)
	{
		$result = $this->quiz->getQuizByName($input);
		echo json_encode($result);
	}

	public function getQuizzes()
	{
		$result = $this->quiz->getQuizzes();
		echo json_encode($result);
	}

	public function deleteQuiz($quizId)
	{
		$this->quiz->deleteQuiz($quizId);
		redirect('http://localhost/quiz/admin/quiz', 'refresh');
	}

	// QUESTION-ADMIN

	public function addQuestion()
	{
		$answeramount = $_POST['answeramount'];
		for ($i = 1; $i <= $answeramount; $i++) 
		{
			$this->form_validation->set_rules('answer'.$i, 'Answer '.$i, 'required');
		}

		if($this->form_validation->run() == true)
		{
			$this->question->addQuestion();
			$lastQuestion = $this->question->getLastAddedQuestion();

			$this->answer->addAnswers($lastQuestion, $answeramount);
			$idQuiz = $_POST['quizId'];
			$result['questions'] = $this->question->getQuestionsByQuiz($idQuiz);
			$result['answers'] = $this->answer->getAnswersByQuiz($idQuiz);

			echo json_encode($result);
		}
	}

	public function deleteQuestion($idQuestion)
	{
		$idQuiz = $_POST['quizId'];
		$this->question->deleteQuestion($idQuestion);
		$result['questions'] = $this->question->getQuestionsByQuiz($idQuiz);
		$result['answers'] = $this->answer->getAnswersByQuiz($idQuiz);


		echo json_encode($result);
	}

	// ANSWER-ADMIN

	public function deleteAnswer($idAnswer)
	{
		$idQuiz = $_POST['quizId'];
		$this->answer->deleteAnswer($idAnswer);
		$result['questions'] = $this->question->getQuestionsByQuiz($idQuiz);
		$result['answers'] = $this->answer->getAnswersByQuiz($idQuiz);

		echo json_encode($result);
	}

	public function updateAnswer($idAnswer)
	{
		$idQuiz = $_POST['quizId'];
		$this->answer->updateAnswer($idAnswer);
		$result['questions'] = $this->question->getQuestionsByQuiz($idQuiz);
		$result['answers'] = $this->answer->getAnswersByQuiz($idQuiz);

		echo json_encode($result);
	}

	public function addAnswer($idQuestion)
	{
		$idQuiz = $_POST['quizId'];
		$this->answer->addAnswer($idQuestion);
		$result['questions'] = $this->question->getQuestionsByQuiz($idQuiz);
		$result['answers'] = $this->answer->getAnswersByQuiz($idQuiz);

		echo json_encode($result);
	}
}