function addTag(tagText)
{
	var repetida=false;
	etiquetas = document.getElementById('etiquetas');
	tags=etiquetas.value.split(' ');
	for (var i=0; i<=tags.length; i++) {
		if (tags[i] == tagText) {
			//return false;
			repetida=true;
		}
	}
	if (!etiquetas.value) {
		etiquetas.value = tagText;
	}
	else if (etiquetas.value && !repetida) {
		etiquetas.value += ' ' + tagText;
	} else {
		etiquetas.value = removeSubstring(etiquetas.value, tagText);
		etiquetas.value = trimAll(etiquetas.value.replace('  ', ' '));
	}
	return true;
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