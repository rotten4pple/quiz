(function() 
{
	var ajaxinput = document.getElementById("ajaxpost");
	var quizdetails = document.getElementById("quizdetails");
	var search = document.getElementById("search");

	ajaxinput.onclick = function()
	{
		var quiznameinput = document.getElementById("quizname");
		var quizname = quiznameinput.value;
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() 
		{
			if((xhr.readyState == 4) && (xhr.status == 200 || xhr.status == 304))
			{
				var obj = JSON.parse(xhr.responseText);
				var listLength = obj.length;
				var buildQuizList = "";
				for(var i = 0; i < listLength; i++)
				{
					buildQuizList += "<h3>Quizname: <a href='http://localhost/quiz/admin/quiz/"+obj[i]['idQuiz']+"'>"+obj[i]['Quizname']+"</a></h3>";
				}
				quizdetails.innerHTML = buildQuizList;
				quiznameinput.value = "";
				search.value = "";
			}
		}
		xhr.open("POST", "/quiz/admin/addQuiz/");
		xhr.setRequestHeader("Content-type","application/x-www-form-urlencoded");

		xhr.send("quizname="+quizname);

		return false;
	}

	search.onkeyup = function()
	{
		var input = search.value;
		var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() 
		{
			if((xhr.readyState == 4) && (xhr.status == 200 || xhr.status == 304))
			{
				var obj = JSON.parse(xhr.responseText);
				var listLength = obj.length;
				var buildQuizList = "";
				for(var i = 0; i < listLength; i++)
				{
					buildQuizList += "<h3>Quizname: <a href='http://localhost/quiz/admin/quiz/"+obj[i]['idQuiz']+"'>"+obj[i]['Quizname']+"</a></h3>";
				}
				quizdetails.innerHTML = buildQuizList;
			}
		}
		if(input == "")
		{
			xhr.open("GET", "/quiz/admin/getQuizzes");
		}
		else
		{
			xhr.open("GET", "/quiz/admin/getQuiz/"+input);
		}

		xhr.send();
	}

})();