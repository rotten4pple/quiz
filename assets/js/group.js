(function() 
{
	var searchbar = document.getElementById("searchbar");
	var body = document.getElementsByTagName("body")[0];
	var content2 = document.getElementById("content2");
	var ulList = content2.getElementsByTagName("ul");
	var liList = content2.getElementsByTagName("li");
	var radioGroup = document.getElementById("group");
	var radioMembers = document.getElementById("members");
	var radioLabel = document.getElementById("label");
	var json;

	window.onpageshow = function()
	{
		var xhr = new XMLHttpRequest();

		xhr.onreadystatechange = function() 
		{
			if((xhr.readyState == 4) && (xhr.status == 200 || xhr.status == 304))
			{
				json = JSON.parse(xhr.responseText);
				for(var i = 0; i < json.length - 1; i++)
				{
					var memberTempText = "";
					var exTempText = "";

					for (var j = 0; j < json[i].members.length; j++) 
					{
						memberTempText += json[i].members[j].name + ", ";	
					}
					memberTempText = memberTempText.slice(0, memberTempText.length - 2);
					json[i].members = memberTempText;

					for (var k = 0; k < json[i].ex_members.length; k++) 
					{
						exTempText += json[i].ex_members[k].name + ", ";	
					}
					exTempText = exTempText.slice(0, exTempText.length - 2);
					json[i].ex_members = exTempText;
				}
			}		
		}
		xhr.open("GET", "assets/json/kpopgroups.json");

		xhr.send();
	}

	searchbar.onkeyup = function() 
	{
		deleteList();

		for(var i = 0; i < json.length - 1; i++)
		{
			if(json[i].name.toLowerCase().indexOf(searchbar.value.toLowerCase()) > -1 && 
				searchbar.value != "" &&
				radioGroup.checked)
			{
				printList(i);
			}

			if(json[i].members.toLowerCase().indexOf(searchbar.value.toLowerCase()) > -1 && 
				searchbar.value != "" &&
				radioMembers.checked)
			{
				printList(i);
			}

			if(json[i].label.toLowerCase().indexOf(searchbar.value.toLowerCase()) > -1 && 
				searchbar.value != "" &&
				radioLabel.checked)
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

	radioLabel.onchange = function()
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
		img.src = "assets/img/Kpop-groups/" + json[i].img_name + ".png";
		var liName = document.createElement("li");
		var liNameText = document.createTextNode("Name: " + json[i].name);			
		var liMembers = document.createElement("li");
		var liMembersText = document.createTextNode("Members: " + json[i].members);
		var liExMembers = document.createElement("li");
		var liExMembersText = document.createTextNode("Ex-members: " + json[i].ex_members);
		var liLabel = document.createElement("li");
		var liLabelText = document.createTextNode("Label: " + json[i].label);
		var liDebut = document.createElement("li");
		var liDebutText = document.createTextNode("Debut: " + json[i].debut);
		var liFanclub = document.createElement("li");
		var liFanclubText = document.createTextNode("Fanclub: " + json[i].fanclub);
		var liColor = document.createElement("li");
		var liColorText = document.createTextNode("Fancolor: " + json[i].color);

		liImg.appendChild(img);
		liName.appendChild(liNameText);
		liMembers.appendChild(liMembersText);
		liExMembers.appendChild(liExMembersText);
		liLabel.appendChild(liLabelText);
		liDebut.appendChild(liDebutText);
		liFanclub.appendChild(liFanclubText);
		liColor.appendChild(liColorText);

		ul.appendChild(liImg);
		ul.appendChild(liName);
		ul.appendChild(liMembers);
		ul.appendChild(liExMembers);
		ul.appendChild(liLabel);
		ul.appendChild(liDebut);
		ul.appendChild(liFanclub);
		ul.appendChild(liColor);

		content2.appendChild(ul);
	}
})();