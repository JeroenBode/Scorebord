function getHTTPObject() {
	var xhr = false;//set to false, so if it fails, do nothing
	if(window.XMLHttpRequest) {//detect to see if browser allows this method
		var xhr = new XMLHttpRequest();//set var the new request
	} else if(window.ActiveXObject) {//detect to see if browser allows this method
		try {
			var xhr = new ActiveXObject("Msxml2.XMLHTTP");//try this method first
		} catch(e) {//if it fails move onto the next
			try {
				var xhr = new ActiveXObject("Microsoft.XMLHTTP");//try this method next
			} catch(e) {//if that also fails return false.
				xhr = false;
			}
		}
	}
	return xhr;//return the value of xhr
}

function loadingDiv(div) {
	document.getElementById(div).style.display = "block";
	document.getElementById(div).innerHTML = "<br><center><img src='ajax-loader-small.gif' border=0></center><br>";
}

function tweet() {
	httpObject = getHTTPObject();
	if (httpObject != null) {
		var tekst = document.getElementById("tekst").value;//+" (via: http://scorebord.nnfan.nl)";
		var url = "tweet.php?tekst="+tekst+"&pid="+Math.random();
		httpObject.open("GET", url, true);
		httpObject.send(null); 
		httpObject.onreadystatechange = sendTweet;
	}
}

function sendTweet() {
	if(httpObject.readyState == 4){
		//document.getElementById("laatstetweet").innerHTML = httpObject.responseText;
		if (httpObject.responseText=="") setTweet();
		else document.getElementById("tekst").value = httpObject.responseText;
		laatsteDrie();
	}
}

function laatsteDrie() {
	httpObject = getHTTPObject();
	if (httpObject != null) {
		loadingDiv("laatstedrie");
		var url = "laatstedrie.php?pid="+Math.random();
		httpObject.open("GET", url, true);
		httpObject.send(null); 
		httpObject.onreadystatechange = setLaatsteDrie;
	}
}

function setLaatsteDrie() {
	if(httpObject.readyState == 4){
		document.getElementById("laatstedrie").innerHTML = httpObject.responseText;
	}
}

function score(plusmin, thuisuit) {
	var score = parseInt(document.getElementById("score"+thuisuit).innerHTML);
	if (plusmin == "plus") score = score + 1;
	if (plusmin == "min") score = score - 1;
	document.getElementById("score"+thuisuit).innerHTML = score;
	//sessie bijwerken
	httpObject = getHTTPObject();
	if (httpObject != null) {
		var url = "scorebijwerken.php?s="+thuisuit+"&score="+score+"&pid="+Math.random();
		httpObject.open("GET", url, true);
		httpObject.send(null); 
		//httpObject.onreadystatechange = ;
	}
	setTweet();
}

function setTweet() {
	//document.getElementById("tekst").focus();
	document.getElementById("tekst").value = thuis+" "+parseInt(document.getElementById("scorethuis").innerHTML)+" - "+parseInt(document.getElementById("scoreuit").innerHTML)+" "+uit+" ";
}

function checkInvoer(e){
	var unicode=e.keyCode? e.keyCode : e.charCode;
	//pijl naar rechts = 39, pijl naar links = 37
	if (unicode==37) plus("thuis");
	if (unicode==39) plus("uit");
}

function getStatus(s) {
	if (s == 6) return "Eindstand";
	else if (s == 1) return "Wedstrijd gestart";
	else if (s == 2) return "Ruststand";
	else if (s == 3) return "Tweede helft";
	else if (s == 4) return "Laatste 5 min. zuivere speeltijd";
	else if (s == 5) return "Laatste minuut";
	else return "Nog niet begonnen";
}

function setStatus(s){
	document.getElementById("status").innerHTML = "status: "+getStatus(parseInt(s));
	setTweet();
	document.getElementById('tekst').value += getStatus(parseInt(s));
	httpObject = getHTTPObject();
	if (httpObject != null) {
		var url = "status.php?status="+s+"&pid="+Math.random();
		httpObject.open("GET", url, true);
		httpObject.send(null); 
		//httpObject.onreadystatechange = resetStatus;
	}
}

var httpObject = null;