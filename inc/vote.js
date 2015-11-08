function voteRP(item) {
	var rank= document.forms['voteForm']['changeRank2'].value;
	var req=document.forms['voteForm']['req'].value;
	// alert("voting item:"+item+" rank:"+rank);

	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else {  // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("action").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","voting.php?"+req+"&o="+item+"&r="+rank,true);
	xmlhttp.send();
}

function electing(who,state) {
	var req=document.forms['voteForm']['req'].value;

	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	} else {  // code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange=function() {
		if (xmlhttp.readyState==4 && xmlhttp.status==200) {
			document.getElementById("action").innerHTML=xmlhttp.responseText;
		}
	}
	xmlhttp.open("GET","voting.php?"+req+"&e="+who+"&s="+state,true);
	xmlhttp.send();

}

function move2TargetDiv() {
  //alert('starting move');
	debugger;
  var x=document.getElementById("actionHiddenId");
	x=x.contentDocument;
	if(!x) return;
	x=x.getElementById("answer");
	if(!x) return;
	x=x.innerHTML;
	if(x){
  document.getElementById("targetDiv").innerHTML=x;
	} else{
	}
}
