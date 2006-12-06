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
