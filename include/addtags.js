function addTag(tagText) {
	var repetida = false;
	var tags = new Array();
	var etiquetas = new String();
	var allTags = new Array();
	var multi = (tagText.indexOf(' ') != -1);
	
	etiquetas = document.getElementById('etiquetas');
	tags = etiquetas.value.split('"');
	var cant = tags.length;
	for (var i=1; i<cant; i+=2) {
		var tt = tags[i];
		if(tt != ' ' && tt != ''){
			if(tt != tagText){	allTags.push('"'+tt+'"');	
			}else{	repetida = true;	}
		}
	}
	for (i=0; i<cant; i+=2) {
		var eachTag = tags[i].split(' ');
		for (var o=0; o<eachTag.length; o++){
			if(eachTag[o] != ' ' && eachTag[o] != ''){
				if(eachTag[o] != tagText){	allTags.push(eachTag[o]);
				}else{	repetida = true;	}
			}
		}
	}
	if(repetida == false) {
		if(multi){
			allTags.push('"'+tagText+'"');
		}else{
			allTags.push(tagText);
		}
	}
	etiquetas.value = allTags.join(' ');
	return true;
}

function addToSearch(tag){		
	var temp = new String();
	var s  = document.getElementById('busqueda');
	temp = "::"+tag;
	if (s.value.indexOf(temp)==-1) {
		s.value = s.value+temp;
	} else {
		s.value = removeSubstring(s.value, temp);
		s.value = trimAll(s.value.replace('  ', ' '));
	}
	return false;
}

function removeSubstring(s, t) {
  i = s.indexOf(t);
  r = "";
  if (i == -1) return s;
  r += s.substring(0,i) + removeSubstring(s.substring(i + t.length), t);
  return r;
}

function trimAll(sString) {
	while (sString.substring(0,1) == ' ') {
		sString = sString.substring(1, sString.length);
	}
	while (sString.substring(sString.length-1, sString.length) == ' ') {
		sString = sString.substring(0,sString.length-1);
	}
	return sString;
}
