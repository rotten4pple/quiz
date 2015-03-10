<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "welcome";
$route['404_override'] = 'errors/page_missing';

$route['login'] = 'LoginController';
$route['logout'] = 'LoginController/logout';
$route['welcome_message'] = 'welcome';

$route['playquiz'] = "quizController/quizList";
$route['playquiz/(:num)'] = "quizController/playQuiz/$1";
$route['playquiz/(:num)/get'] = "quizController/getPlayQuiz/$1";
$route['playquiz/checkAnswers'] = "quizController/checkAnswers";

$route['admin'] = "adminController";
$route['admin/quiz'] = "quizController/admin";
$route['admin/getQuiz/(:any)'] = "quizController/getQuiz/$1";
$route['admin/quiz/(:num)'] = "quizController/quiz/$1";
$route['admin/quiz/(:num)/edit'] = "quizController/editQuiz/$1";
$route['admin/quiz/(:num)/update'] = "quizController/updateQuiz/$1";
$route['admin/quiz/(:num)/delete'] = "quizController/deleteQuiz/$1";
$route['admin/addQuiz'] = "quizController/addQuiz";
$route['admin/addQuestion'] = "quizController/addQuestion";
$route['admin/question/(:num)/delete'] = "quizController/deleteQuestion/$1";
$route['admin/answer/(:num)/delete'] = "quizController/deleteAnswer/$1";
$route['admin/answer/(:num)/update'] = "quizController/updateAnswer/$1";
$route['admin/answer/(:num)/submit'] = "quizController/addAnswer/$1";

$route['group'] = "groupController";
$route['admin/group'] = "groupController/admin";
$route['admin/addGroup'] = "groupController/addGroup";

$route['member'] = "memberController";
$route['member/getMembers'] = "memberController/getAllMembers";
$route['admin/member'] = "memberController/admin";
$route['admin/addMember'] = "memberController/addMember";
