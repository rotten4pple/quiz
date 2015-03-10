(function() 
{
	var playbutton = document.getElementById("playbutton");
	var playquiz = document.getElementById("playquiz");
	var cover = document.getElementById("cover");
	var currentQuestion = 0;
	var coverLevel = 0;
	var fadeSpeed = 1;
	var fadeTime = 2000;
	var chosenAnswers = [];
	var answer = {};
	var questionList = [];
	var quizId;
	var quizLength;
	var timer;
	var displayTimer;
	
	playbutton.onclick = function()
	{
		quizId = this.getAttribute("data-quizid");

		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function()
		{
			if((xhr.readyState == 4) && (xhr.status == 200 || xhr.status == 304))
			{
				var tempList = JSON.parse(xhr.responseText);
				questionList['questions'] = shuffleArray(tempList.questions);
				console.log(questionList);
				quizLength = questionList.questions.length;
				nextQuestion(fadeSpeed, fadeTime);
			}
		}
		xhr.open("GET", "/quiz/playquiz/"+quizId+"/get");
		xhr.send();

		return false;
	}

	function loadQuestion()
	{
		var answers = shuffleArray(questionList.questions[currentQuestion].Answers);
		var answersLength = answers.length;
		var displayCurrentQuestion = currentQuestion + 1;
		var buildQuestion = "<div id='playquizleft'>";
		buildQuestion += "<img src='/quiz/assets/img/Kpop-groups/"+questionList.questions[currentQuestion].Imgname+".png'>";
		buildQuestion += "</div><div id='playquizright'>";
		buildQuestion += "<p>Q"+displayCurrentQuestion+"/"+quizLength+"</p>";
		buildQuestion += "<p id='timer'>12</p>";
		
		for(var i = 0; i < answersLength; i++)
		{
			buildQuestion += "<button class='answers' data-questionid='"+answers[i].Question_idQuestion+"' data-answerid='"+answers[i].idAnswer+"'>"+answers[i].AnswerValue+"</button>";
		}

		buildQuestion += "</div>";
		playquiz.innerHTML = buildQuestion;
		addAnswerEvent();
		currentQuestion++;
		clearInterval(timer);
		startTimer();
	}

	function submitAnswer()
	{
		answer = this.getAttribute("data-answerid");
		chosenAnswers.push(answer);
		if(currentQuestion < quizLength)
		{
			nextQuestion(fadeSpeed, fadeTime);
		}
		else if(currentQuestion == quizLength)
		{
			checkAnswers(chosenAnswers);
			currentQuestion = 0;
			clearInterval(timer);
		}
	}

	function addAnswerEvent()
	{
		var answers = document.getElementsByClassName("answers");
		var answersLength = answers.length;
		for(var k = 0; k < answersLength; k++) 
		{
			answers[k].addEventListener("click", submitAnswer);
		}
	}

	function addReplayEvent()
	{
		var replaybutton = document.getElementById("replaybutton");
		replaybutton.onclick = function() { nextQuestion(1, 2000) };
		questionList['questions'] = shuffleArray(questionList['questions']);
		chosenAnswers = [];
		answer = {};

		return false;
	}

	function checkAnswers(chosenAnswers)
	{
		var answerArray = chosenAnswers;
		var answerArrayLength = answerArray.length;
		var buildAnswers = "quizlength="+quizLength;

		for(var i = 0; i < answerArrayLength; i++)
		{
			buildAnswers += "&answer"+i+"="+answerArray[i];
		}

		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function()
		{
			if((xhr.readyState == 4) && (xhr.status == 200 || xhr.status == 304))
			{
				var obj = JSON.parse(xhr.responseText);
				console.log(obj);
				var percent = Math.round((obj.correct / quizLength) * 100);
				var buildResult = "<p id='result'>"+percent+"% correct</p>";
				buildResult += "<button data-quizid='"+quizId+"' id='replaybutton'>Replay</button>";
				playquiz.innerHTML = buildResult;
				addReplayEvent();
			}
		}
		xhr.open("POST", "/quiz/playquiz/checkAnswers");
		xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xhr.send(buildAnswers);
	}

	function startTimer()
	{
		displayTimer = document.getElementById("timer");
		timer = setInterval(countdown, 1000);
	}

	function countdown()
	{
		displayTimer.innerHTML -= 1;
		
		if(displayTimer.innerHTML == 0)
		{
			answer = "timeup";
			chosenAnswers.push(answer);
			if(currentQuestion < quizLength)
			{
				nextQuestion(fadeSpeed, fadeTime);
			}
			else if(currentQuestion == quizLength)
			{
				checkAnswers(chosenAnswers);
				currentQuestion = 0;
				clearInterval(timer);
			}
		}
	}

	function nextQuestion(fadespeed, fadetime)
	{
		cover.style.zIndex = 1000;
		var intervalDelayOut = setInterval(function()
        {
            cover.style.opacity = (coverLevel += 0.05);
            if(cover.style.opacity >= 1)
            {
                clearInterval(intervalDelayOut);
                loadQuestion();
            }
        }, fadespeed);

        setTimeout(function()
        {
            var intervalDelayIn = setInterval(function()
            {
                cover.style.opacity = (coverLevel -= 0.01);
                if(cover.style.opacity <= 0)
                {
                    cover.style.zIndex = -1000;
                    clearInterval(intervalDelayIn);                
                }
            }, fadespeed);
        }, ((fadespeed * 100) + fadetime));
	}

	function shuffleArray(array) 
	{
    	for(var i = array.length - 1; i > 0; i--)
    	{
	        var j = Math.floor(Math.random() * (i + 1));
	        var temp = array[i];
	        array[i] = array[j];
	        array[j] = temp;
    	}
    	
    	return array;
	}

})();
