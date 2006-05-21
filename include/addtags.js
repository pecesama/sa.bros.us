function addTag(tagText) {
	var repetida = false;
	var tags = new Array();
	var etiquetas = new String();
	var temp = new String();

	etiquetas = document.getElementById('etiquetas');
	tags = etiquetas.value.split(' ');

	for (var i=0; i<tags.length; i++) {
		if (tags[i] == tagText) {
			tags[i] = "";
			repetida = true;
		}
	}
	if (!repetida) {
		tags[tags.length] = tagText;
	}

	temp = "";
	for (var i=0; i<tags.length; i++) {
		if (tags[i] != '') {
			temp = temp + " " + tags[i];
		}
	}
	etiquetas.value = temp.substring(1);
	return true;
}
