var status=null;
var httpObject = null;

// Get the HTTP Object
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

function getScore() {
	httpObject = getHTTPObject();
	if (httpObject != null) {
		var url = "scoreophalen.php?&pid="+Math.random();
		httpObject.open("GET", url, true);
		httpObject.send(null); 
		httpObject.onreadystatechange = setScorebord;
	}
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

function setScorebord() {
	if(httpObject.readyState == 4){
		var score = httpObject.responseText;
		score = score.split(' ');
		document.getElementById("scorethuis").innerHTML = score[0];
		document.getElementById("scoreuit").innerHTML = score[1];
		document.getElementById("status").innerHTML = getStatus(parseInt(score[2]));
		var currentTime = new Date();
		var hours = currentTime.getHours();
		var minutes = currentTime.getMinutes();
		var seconds = currentTime.getSeconds();

		if (minutes < 10) minutes = "0" + minutes;
		if (seconds < 10) seconds = "0" + seconds;

		document.getElementById("laatsterefresh").innerHTML = "<br>Laatste refresh: "+hours+":"+minutes+":"+seconds;
		document.getElementById("laatsteupdate").innerHTML = "Laatste update: "+score[4];
	}
}

function deleteSessie() {
	httpObject = getHTTPObject();
	if (httpObject != null) {
		var url = "deletesessie.php?&pid="+Math.random();
		httpObject.open("GET", url, true);
		httpObject.send(null); 
	}
}	

function scorebord() {
	getScore();
	var t=5000; //elke 1000 is 1 seconde
	//if (document.getElementById("status").innerHTML == "0") t = 60000;
	setInterval('getScore()',t);
}