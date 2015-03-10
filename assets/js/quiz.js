(function() 
{
	var answers = document.getElementById("answeramount");
	var answerinputs = document.getElementById("answerinputs");
	var question = document.getElementById("question");
	var quizEdit = document.getElementById("quizEdit");
	var questionvalue = question.options[question.selectedIndex].text;
	var ajaxinput = document.getElementById("ajaxpost");

	answers.onchange = function()
	{
		answerinputs.innerHTML = "";
		var answeramount = answers.value;
		var string = "";
		questionvalue = question.options[question.selectedIndex].text;
		for(var i = 1; i <= answeramount; i++) 
		{
			if(i == 1) 
			{
				string += "<label for='answer"+i+"'>Answer "+i+"</label>";
				string += "<input type='text' name='answer"+i+"' class='answers' id='firstanswer' value='"+questionvalue+"' readonly>";
			}
			else
			{
				string += "<label for='answer"+i+"'>Answer "+i+"</label>";
				string += "<input type='text' name='answer"+i+"' class='answers'>";
			}
		}
		answerinputs.innerHTML = string;
		var answerfields = document.getElementsByClassName("answers");
	}

	question.onchange = function()
	{
		var firstanswer = document.getElementById("firstanswer");
		questionvalue = question.options[question.selectedIndex].text;
		firstanswer.value = questionvalue;
	}

	ajaxinput.onclick = function()
	{
		var quizId = document.getElementById("quizId").value;
		questionvalue = question.options[question.selectedIndex].value;
		var answeramount = answers.value;
		var answerfields = document.getElementsByClassName("answers");
		var answerfieldslength = answerfields.length;
		var string2 = "quizId="+quizId+"&question="+questionvalue+"&answeramount="+answeramount;
		var loopcount = 1;
		for(var i = 0; i < answerfieldslength; i++)
		{
			string2 += "&answer"+loopcount+"="+answerfields[i].value;
			loopcount++;
		}

		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() 
		{
			var questionsList = document.getElementById("questionsList");
			if((xhr.readyState == 4) && (xhr.status == 200 || xhr.status == 304))
			{
				var obj = JSON.parse(xhr.responseText);
				console.log(obj);
				printList(obj);

				for(var j = 0; j < answerfieldslength; j++) 
				{
					answerfields[j].value = "";
				}
				question.selectedIndex = "0";
			}
		}
		xhr.open("POST", "/quiz/admin/addQuestion/");
		xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");

		xhr.send(string2);
	}

	function editQuiz()
	{
		var quizName = document.getElementById("quizName");
		var quizNameHeader = document.getElementById("quizNameHeader");
		var quizNameValue = quizNameHeader.innerHTML;
		quizName.innerHTML = "<input type='text' name='quizName' id='quizName2' value='"+quizNameValue+"'>";
		quizName.innerHTML += "<button id='quizUpdate'>Edit</button>";

		var quizUpdate = document.getElementById("quizUpdate");
		quizUpdate.addEventListener("click", updateQuiz);
	} quizEdit.addEventListener("click", editQuiz);
	
	function updateQuiz()
	{
		var quizName = document.getElementById("quizName");
		var quizId = document.getElementById("quizId").value;
		var name = document.getElementById("quizName2").value;
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() 
		{
			if((xhr.readyState == 4) && (xhr.status == 200 || xhr.status == 304))
			{
				quizName.innerHTML = "<h3 id='quizNameHeader'>"+name+"</h3>";
				quizName.innerHTML += "<button id='quizEdit'>Edit</button>";
				quizName.innerHTML += "<a href='http://localhost/quiz/admin/quiz/"+quizId+"/delete'><button>Delete</button></a>";
				var quizEdit = document.getElementById("quizEdit");
				quizEdit.addEventListener("click", editQuiz);
			}
		}
		xhr.open("POST", "/quiz/admin/quiz/"+quizId+"/update");
		xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");

		xhr.send("quizname="+name);	
	}

	function addQuestionDeleteEvent()
	{
		var questionDeleteButtons = document.getElementsByClassName("questionDelete");
		var questionDeleteButtonsLength = questionDeleteButtons.length;
		for(var k = 0; k < questionDeleteButtonsLength; k++) 
		{
			questionDeleteButtons[k].addEventListener("click", deleteQuestion);
		}
	} addQuestionDeleteEvent();

	function deleteQuestion()
	{
		var questionId = this.getAttribute("data-questionid");
		var quizId = document.getElementById("quizId").value;
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() 
		{
			if((xhr.readyState == 4) && (xhr.status == 200 || xhr.status == 304))
			{
				var obj = JSON.parse(xhr.responseText);
				printList(obj);
			}
		}
		xhr.open("POST", "/quiz/admin/question/"+questionId+"/delete");
		xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");

		xhr.send("questionId="+questionId+"&quizId="+quizId);	
	}

	function addAnswerEditEvent()
	{
		var answerEditButtons = document.getElementsByClassName("answerEdit");
		var answerEditButtonsLength = answerEditButtons.length;
		for(var k = 0; k < answerEditButtonsLength; k++) 
		{
			answerEditButtons[k].addEventListener("click", editAnswer);
		}
	} addAnswerEditEvent();

	function editAnswer()
	{
		var answerId = this.getAttribute("data-answerid");
		var answerElement = document.getElementById("answer"+answerId);
		var splitAnswerElement = answerElement.innerHTML.split(": ");
		var buildEditAnswer = "<p class='answer' id='answer"+answerId+"'>"+splitAnswerElement[0]+":</p>";
		buildEditAnswer += "<input type='text' name='answerUpdate' id='answerUpdate"+answerId+"' value='"+splitAnswerElement[1]+"'>";
		buildEditAnswer += "<button class='answerUpdate' data-answerid='"+answerId+"'>Edit</button>";
		answerElement.parentNode.innerHTML = buildEditAnswer;

		addAnswerUpdateEvent();
	}

	function addAnswerUpdateEvent()
	{
		var answerUpdateButtons = document.getElementsByClassName("answerUpdate");
		var answerUpdateButtonsLength = answerUpdateButtons.length;
		for(var k = 0; k < answerUpdateButtonsLength; k++) 
		{
			answerUpdateButtons[k].addEventListener("click", updateAnswer);
		}
	}

	function updateAnswer()
	{
		var quizId = document.getElementById("quizId").value;
		var answerId = this.getAttribute("data-answerid");
		var answerValue = document.getElementById("answerUpdate"+answerId).value;
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() 
		{
			if((xhr.readyState == 4) && (xhr.status == 200 || xhr.status == 304))
			{
				var obj = JSON.parse(xhr.responseText);
				printList(obj);
			}
		}
		xhr.open("POST", "/quiz/admin/answer/"+answerId+"/update");
		xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");

		xhr.send("answerValue="+answerValue+"&quizId="+quizId);
	}

	function addAnswerDeleteEvent()
	{
		var answerDeleteButtons = document.getElementsByClassName("answerDelete");
		var answerDeleteButtonsLength = answerDeleteButtons.length;
		for(var k = 0; k < answerDeleteButtonsLength; k++) 
		{
			answerDeleteButtons[k].addEventListener("click", deleteAnswer);
		}
	} addAnswerDeleteEvent();

	function deleteAnswer()
	{
		var answerId = this.getAttribute("data-answerid");
		var quizId = document.getElementById("quizId").value;
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() 
		{
			if((xhr.readyState == 4) && (xhr.status == 200 || xhr.status == 304))
			{
				var obj = JSON.parse(xhr.responseText);
				printList(obj);
			}
		}
		xhr.open("POST", "/quiz/admin/answer/"+answerId+"/delete");
		xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");

		xhr.send("answerId="+answerId+"&quizId="+quizId);
	}

	function addAnswerAddEvent()
	{
		var answerAddButtons = document.getElementsByClassName("addAnswer");
		var answerAddButtonsLength = answerAddButtons.length;
		for(var k = 0; k < answerAddButtonsLength; k++) 
		{
			answerAddButtons[k].addEventListener("click", addAnswer);
		}
	} addAnswerAddEvent();

	function addAnswer()
	{
		var questionId = this.getAttribute("data-questionid");
		var answerHTML = this.previousElementSibling.innerHTML;
		var buildAddAnswer = "<p class='answer'>"+answerHTML+"</p>";
		buildAddAnswer += "<input type='text' name='submitAnswer' id='answerSubmit"+questionId+"'>";
		buildAddAnswer += "<button class='submitAnswer' data-questionid='"+questionId+"'>Add</button>";
		this.parentNode.innerHTML = buildAddAnswer;

		addAnswerSubmitEvent();
	}

	function addAnswerSubmitEvent()
	{
		var answerSubmitButtons = document.getElementsByClassName("submitAnswer");
		var answerSubmitButtonsLength = answerSubmitButtons.length;
		for(var k = 0; k < answerSubmitButtonsLength; k++) 
		{
			answerSubmitButtons[k].addEventListener("click", submitAnswer);
		}
	}

	function submitAnswer()
	{
		var questionId = this.getAttribute("data-questionid");
		var quizId = document.getElementById("quizId").value;
		var answerValue = document.getElementById("answerSubmit"+questionId).value
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() 
		{
			if((xhr.readyState == 4) && (xhr.status == 200 || xhr.status == 304))
			{
				var obj = JSON.parse(xhr.responseText);
				printList(obj);
			}
		}
		xhr.open("POST", "/quiz/admin/answer/"+questionId+"/submit");
		xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");

		xhr.send("answerValue="+answerValue+"&quizId="+quizId);
	}

	function printList(obj)
	{
		var json = obj;
		var questionsList = document.getElementById("questionsList");
		buildQuestionsList = "";
		console.log(json);
		var questionsLength = json.questions.length;
		var questionCount = 1;
		for(var i = 0; i < questionsLength; i++) 
		{
			buildQuestionsList += "<hr>";
			buildQuestionsList += "<p class='question'>Question "+questionCount+": "+json.questions[i].Groupname+"</p>";
			buildQuestionsList += "<button class='questionDelete' data-questionid="+json.questions[i].idQuestion+">Delete</button>";
			var answersLength = json.answers.length;
			questionCount++;
			var answerCount = 1;
			for(var j = 0; j < answersLength; j++)
			{
				if(json.questions[i].idQuestion == json.answers[j].idQuestion)
				{
					
					if(json.answers[j].Correct == 0)
					{
						buildQuestionsList += "<div class='answers-inline'>";
						buildQuestionsList += "<p class='answer' id='answer"+json.answers[j].idAnswer+"'>Answer "+answerCount+": "+json.answers[j].AnswerValue+"</p>";
						buildQuestionsList += "<button class='answerEdit' data-answerid="+json.answers[j].idAnswer+">Edit</button>";
						buildQuestionsList += "<button class='answerDelete' data-answerid="+json.answers[j].idAnswer+">Delete</button>";
						buildQuestionsList += "</div>";
					}
					else if(json.answers[j].Correct == 1)
					{
						buildQuestionsList += "<div class='answers-inline'>";
						buildQuestionsList += "<p class='answercorrect'>Answer "+answerCount+": "+json.answers[j].AnswerValue+"</p>";
						buildQuestionsList += "</div>";
					}
					answerCount++;
				}
			}
			if(answerCount <= 6)
			{
				buildQuestionsList += "<div class='answers-inline'>";
				buildQuestionsList += "<p class='answer'>Answer "+answerCount+":</p>";
				buildQuestionsList += "<button class='addAnswer' data-questionid='"+json.questions[i].idQuestion+"'>Add</button>";
				buildQuestionsList += "</div>";
			}
		}
		questionsList.innerHTML = buildQuestionsList;
		addQuestionDeleteEvent();
		addAnswerDeleteEvent();
		addAnswerEditEvent();
		addAnswerAddEvent();
	}

})();