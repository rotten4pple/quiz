(function() 
{
	var searchbar = document.getElementById("searchbar");
	var body = document.getElementsByTagName("body")[0];
	var content2 = document.getElementById("content2");
	var ulList = content2.getElementsByTagName("ul");
	var liList = content2.getElementsByTagName("li");
	var radioGroup = document.getElementById("group");
	var radioMembers = document.getElementById("members");
	var json;

	window.onpageshow = function()
	{
		var xhr = new XMLHttpRequest();

		xhr.onreadystatechange = function() 
		{
			if((xhr.readyState == 4) && (xhr.status == 200 || xhr.status == 304))
			{
				json2 = JSON.parse(xhr.responseText);
			}		
		}
		xhr.open("GET", "assets/json/kpopidols.json");

		xhr.send();
	}

	window.onpageshow = function()
	{
		var xhr = new XMLHttpRequest();

		xhr.onreadystatechange = function() 
		{
			if((xhr.readyState == 4) && (xhr.status == 200 || xhr.status == 304))
			{
				json = JSON.parse(xhr.responseText);
				console.log(json);
			}		
		}
		xhr.open("GET", "member/getMembers");

		xhr.send();
	}

	searchbar.onkeyup = function() 
	{
		deleteList();

		for(var i = 0; i < json.length - 1; i++)
		{
			if(json[i].Groupname.toLowerCase().indexOf(searchbar.value.toLowerCase()) > -1 && 
				searchbar.value != "" &&
				 radioGroup.checked) //||
				// (json[i].sub_unit.toLowerCase().indexOf(searchbar.value.toLowerCase()) > -1 && 
				// searchbar.value != "" &&
				// radioGroup.checked))
			{
				printList(i);
			}

			if((json[i].Idolname.toLowerCase().indexOf(searchbar.value.toLowerCase()) > -1 && 
				searchbar.value != "" &&
				radioMembers.checked) ||
				(((json[i].Surname + " " + json[i].Birthname).toLowerCase()).indexOf(searchbar.value.toLowerCase()) > -1 && 
				searchbar.value != "" &&
				radioMembers.checked))
			{
				printList(i);
			}
		}		
	}

	radioGroup.onchange = function()
	{
		searchbar.value = "";
		deleteList();
	}

	radioMembers.onchange = function()
	{
		searchbar.value = "";
		deleteList();
	}

	function deleteList()
	{
		if(liList.length > 0)
		{
			for(var i = liList.length - 1; i > -1; i--) 
			{
				var liEl = liList[i];
				liEl.parentNode.removeChild(liEl);
			}

			for (var i = ulList.length - 1; i > -1; i--) 
			{
				var ulEl = ulList[i];
				ulEl.parentNode.removeChild(ulEl);
			}
		}
	}

	function printList(i)
	{
		var ul = document.createElement("ul");
		var liImg = document.createElement("li");
		var img = document.createElement("img");
		img.src = "assets/img/Kpop-idols/" + json[i].Imgname + ".png";
		var liName = document.createElement("li");
		var liNameText = document.createTextNode("Stagename: " + json[i].Idolname);			
		var liSurName = document.createElement("li");
		var liSurNameText = document.createTextNode("Surname: " + json[i].Surname);
		var liBirthName = document.createElement("li");
		var liBirthNameText = document.createTextNode("Firstname: " + json[i].Birthname);
		var liBirthDate = document.createElement("li");
		var liBirthDateText = document.createTextNode("Birthdate: " + json[i].Birthdate);
		var liNationality = document.createElement("li");
		var liNationalityText = document.createTextNode("Nationality: " + json[i].Nationalityname);
		var liHeight = document.createElement("li");
		var liHeightText = document.createTextNode("Height: " + json[i].Height + " cm");
		var liWeight = document.createElement("li");
		var liWeightText = document.createTextNode("Weight: " + json[i].Weight + " kg");
		var liBloodType = document.createElement("li");
		var liBloodTypeText = document.createTextNode("Bloodtype: " + json[i].Bloodtypename);
		var liGroup = document.createElement("li");
		var liGroupText = document.createTextNode("Group: " + json[i].Groupname);
		//var liPosition = document.createElement("li");
		//var liPositionText = document.createTextNode("Position: " + json[i].position);
		//var liSubUnit = document.createElement("li");
		//var liSubUnitText = document.createTextNode("Sub-unit: " + json[i].sub_unit);

		liImg.appendChild(img);
		liName.appendChild(liNameText);
		liSurName.appendChild(liSurNameText);
		liBirthName.appendChild(liBirthNameText);
		liBirthDate.appendChild(liBirthDateText);
		liNationality.appendChild(liNationalityText);
		liHeight.appendChild(liHeightText);
		liWeight.appendChild(liWeightText);
		liBloodType.appendChild(liBloodTypeText);
		liGroup.appendChild(liGroupText);
		//liPosition.appendChild(liPositionText);
		//liSubUnit.appendChild(liSubUnitText);
		

		ul.appendChild(liImg);
		ul.appendChild(liName);
		ul.appendChild(liSurName);
		ul.appendChild(liBirthName);
		ul.appendChild(liBirthDate);
		ul.appendChild(liNationality);
		ul.appendChild(liHeight);
		ul.appendChild(liWeight);
		ul.appendChild(liBloodType);
		ul.appendChild(liGroup);
		//ul.appendChild(liPosition);
		//ul.appendChild(liSubUnit);
		

		content2.appendChild(ul);
	}

})();