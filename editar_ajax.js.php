<?php
	header("Content-type: application/x-javascript");
	include("include/functions.php");
	include("include/config.php");
	include("include/conex.php");
?>
function editar_cancelar(id){
		<?php /*Volvemos a mostrar el enlace*/?>
		document.getElementById('enlace'+id).style.visibility="visible";
		document.getElementById('enlace'+id).style.position="relative";

		<?php /*Ocultamos el formulario de edición para el enlace*/?>
		document.getElementById('editar'+id).style.visibility="hidden";
		document.getElementById('editar'+id).style.position="absolute";
	}

function editar_guardar(id){
		title = document.getElementById('_title'+id).value;
		enlace = document.getElementById('_enlace'+id).value;
		descripcion = document.getElementById('_descripcion'+id).value;
		tags = document.getElementById('_tags'+id).value;

		ajax = xmlhttp();
		ajax.onreadystatechange=function(){
				if(ajax.readyState==1){
						document.getElementById('editar'+id).innerHTML='<p class="ajax_msg"><?=__("Guardando...")?></p>';
					}
				if(ajax.readyState==4)
						<?php /*Ocultamos la caja donde estaba el formulario y msg de Guardando... */?>
						document.getElementById('editar'+id).style.position="absolute";
						document.getElementById('editar'+id).style.visibility="hidden";
						
						<?php /*Mostramos enlace*/?>
						ver_enlace(id);
						document.getElementById('enlace'+id).style.position="relative";
						document.getElementById('enlace'+id).style.visibility="visible";
						
			}
		ajax.open("POST","modifica.php",true);
		ajax.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		ajax.send(''+
			'id_enlace='+(id)+
			'&title='+encodeURIComponent(title)+
			'&enlace='+encodeURIComponent(enlace)+
			'&descripcion='+encodeURIComponent(descripcion)+
			'&etiquetas='+encodeURIComponent(tags)+
			'&accion=editar'
		);
	}

function ver_enlace(id){
		_ajax = xmlhttp()
		_ajax.onreadystatechange=function(){
				if(_ajax.readyState==1)
					document.getElementById('enlace'+id).innerHTML='<p class="ajax_msg"><?=__("Cargando...")?></p>';		
				if(_ajax.readyState==4)
					document.getElementById('enlace'+id).innerHTML=_ajax.responseText;
			}
		_ajax.open("GET","editar_ajax.php?id="+id+"&enlace",true);
		_ajax.send(null);
		
	}

function xmlhttp(){
		<?php /* Esta funcion crea el retorna un objeto para manipular xmlhttprequest en los navegadores */?>
		<?php /* Si existe alguna otra función mejor que esta, ya estas aturizado de modificar o sustituir sin ningún problema :D */?>
		var xmlhttp;
		try{xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");}
		catch(e){
			try{xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");}
			catch(e){
				try{xmlhttp = new XMLHttpRequest();}
				catch(e){
					xmlhttp = false;
				}
			}
		}
		if (!xmlhttp) 
				return null;
			else
				return xmlhttp;
	}


function editar_ajax(id){
		<?php /*Ocultamos enlace*/?>
		document.getElementById('enlace'+id).style.visibility="hidden";
		document.getElementById('enlace'+id).style.position="absolute";
		
		<?php /*Mostramos formulario de edición para el enlace*/?>
		A = document.getElementById('editar'+id);
		A.style.position="relative";
		A.style.visibility="visible";
		ajax = xmlhttp();
		ajax.onreadystatechange=function(){
				if(ajax.readyState==1){
						<?php /*Hace falta imagen de loading...*/?>
						A.innerHTML = '<p class="ajax_msg"><?=__("Cargando...")?></p>';
					}
				if(ajax.readyState==4){
						A.innerHTML = ajax.responseText;
						A.innerHTML += '<span class="ajax_opcion"><a href="javascript:editar_guardar('+ id +')"><?=__("Guardar")?></a></span>';
						A.innerHTML += '<span class="ajax_opcion"><a href="javascript:editar_cancelar('+ id +')"><?=__("Cancelar")?></a></span>';
					}
			}
		ajax.open("GET","<?=$Sabrosus->sabrUrl;?>/editar_ajax.php?id="+id,true);
		ajax.send(null);
		return false;
	}
