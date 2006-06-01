<?
/* =============================

	sabrosus paquete de idioma para version 1.7

	Idioma : English

	Paquete de idioma original (es-mx)
	por Pedro Santana
       
	Traducción al Inglés
          Patcito (patcito@gmail.com)

	sabrosus monousuario versión 1.7
	http://sabrosus.sourceforge.net/
	sabrosus is a free software licensed under GPL (General public license)

============================= */
   
    # Nota importante: NO traducir lo que esta enmarcado entre % %, respetar el HTML cuando se encuentre y usar '& acute;' para los acentos.
   
	#Mensajes generales
	$idioma[nombre] = "English"; // Nombre del paquete
	$idioma[codificacion] = "UTF-8"; // Codificación
	$idioma[nombre_estandar] = "en";
	
	#index.php
	$idioma[inicio_sabrosus] = "Home Sa.bros.us";
	$idioma[que_es_sabrosus] = "What is sa.bros.us?";
	$idioma[panel_control] = "Control Panel";
	$idioma[numero_enlaces_index] = "There are <strong>%no_enlaces%</strong> links. Showing from <strong>%desde%</strong> to <strong>%total%</strong>";
	$idioma[no_hay_enlaces] = "<strong>There are not links on this sa.bros.us yet.</strong>";
	$idioma[ordenar_por_etiqueta] = "Sort by tag";
	$idioma[etiquetas_contenidas] = "in";
	$idioma[fecha_agregado] = "at";
	$idioma[exportar_al_mio] = "Export to my Sa.bros.us";
	$idioma[exportar_error] = "The folder <code>tmp</code> is not writable.";
	$idioma[generado_con] = "Powered by";
	$idioma[sabrosus_rss] = "RSS sa.bros.us";
	$idioma[etiqueta_rss] = "RSS tag";
	
	#pagination.php
	$idioma[paginador] = "Go to:&nbsp;";
	$idioma[anterior] = "Back";
	$idioma[siguiente] = "Next";
	
	#tags.php
	$idioma[enlaces_con_etiqueta] = "&nbsp;links with that tag";
	
	#include/functions.php
	$idioma[etiquetas_relacionadas] = "Related tags:";   
	$idioma[etiquetas_relacionadas_buscar] = "Seach links with";
	
	#badge.php
	$idioma[mi_sabrosus] = "My sa.bro.sus";
	$idioma[ver_mas] = "More in&nbsp;";
	$idioma[mis_etiquetas] = "My tags on sa.bro.sus";
	
	#close.php
	$idioma[terminar_sesion] = "close session";
	$idioma[terminando_sesion] = "Closing session...";
	$idioma[ocurrio_error] = "Error.";

	#cpanel.php
	$idioma[panel_control] = "control panel";
	$idioma[desea_eliminar] = "Do you want to delete this link?\\n\\nThere's no undo here !!";
	$idioma[agregar_enlace] = "add link";
	$idioma[generar_badge] = "generate sa.bros.us badge";
	$idioma[cambiar_idioma] = "change languaje";
	$idioma[ir_inicio] = "go to sa.bros.us";
	$idioma[terminar_sesion] = "close session";
	$idioma[buscar] = "Search:";
	$idioma[boton_buscar] = "search";
	$idioma[control_contenidos] = "Content control";
	$idioma[ver_enlace] = "View";
	$idioma[editar] = "Edit";
	$idioma[eliminar] = "Delete";
	$idioma[exportar] = "Export";
	
	#login.php
	$idioma[login] = "log in";
	$idioma[intro_pass] = "Type your password";
	$idioma[pass] = "Password:";
	$idioma[guardar_pass] = "Save password";
	$idioma[ingresar] = "Log in";
	$idioma[log_recordar] = "Forgot your password?";
	
	#opciones.php
	$idioma[op_opciones] = "options";
	$idioma[op_ir_opciones] = "go to options";
	$idioma[op_titulo_opciones] = "Sa.bros.us configuration";
	$idioma[op_nombre] = "Web site's name:";
	$idioma[op_titulo] = "Web site's description:";
	$idioma[op_siteurl] = "Web site's main <acronym title=\"Uniform Resource Locator\">URL</acronym>:";
	$idioma[op_sabrurl] = "<strong>sa.bros.us</strong> <acronym title=\"Uniform Resource Locator\">URL</acronym>:";
	$idioma[op_urlfriend] = "Friendly <acronym title=\"Uniform Resource Locator\">URL</acronym>:";
	$idioma[op_activado] = "Activated";
	$idioma[op_desactivado] = "Deactivated";
	$idioma[op_idioma] = "Language:";	
	$idioma[op_conf_apariencia] ="Look and feel configuration";
	$idioma[op_limite_enlaces] = "Links by page: ";
	$idioma[op_contenidos_multimedia] = "Show multimedia content:";
	$idioma[op_descripciones] = "Show descriptions on the links badge:";
	$idioma[op_color_tags] = "Tags cloud's color: ";
	$idioma[op_color_0] = "Orange";
	$idioma[op_color_1] = "Blue";
	$idioma[op_color_2] = "Green";
	$idioma[op_color_3] = "Red";
	$idioma[op_color_4] = "Gray";
	$idioma[op_color_5] = "Random";
	$idioma[op_compartir] = "Allow links export:";
	$idioma[op_compartir_error] = "You must modify the writing permission of the folder <em>tmp/</em> in order to allow export";
	$idioma[op_conf_usuario] = "Administrator configuration";
	$idioma[op_pass] = "<strong>Control panel's</strong> password:";
	$idioma[op_repite_pass] = "Confirm password:";
	$idioma[op_pass_iguales] = "Passwords have to match";
	$idioma[op_deje_blanco] = "Leave blank for not changing passwords";
	$idioma[op_emailadmin] = "E-mail:";	
	$idioma[op_actualizar] = "update";	
	$idioma[op_exito] = "Changes have been updated";
	$idioma[op_error1] = "An error has occurred";
	$idioma[op_error2] = "The file <code>include/config.ini</code> is not writable";
	
	#editar.php
	$idioma[editar_enlace] = "edit link";
	$idioma[agregar_enlace] = "add link";
	$idioma[titulo_editar] = "Edit data link.";
	$idioma[titulo] = "title:";
	$idioma[enlace] = "link:";
	$idioma[descripcion] = "description:";
	$idioma[etiquetas] = "tags:";
	$idioma[boton_editar] = "edit";
	$idioma[ayuda_editar] = "A space-separated list of tags describing this content (ex: xhtml css php).";
	$idioma[enlaces_privados] = "private link:";
	
	#generarBadge.php
	$idioma[generar_badge] = "generate links badge";
	$idioma[titulo_badge] = "Add to your web the sa.bros.us URL's.";
	$idioma[descripcion_badge] = "If you have a blog or a web, you can show the newest URLs added to your sa.bros.us";
	$idioma[copiar_fuente] = "Copy source code";
	$idioma[descripcion_funcionalidad] = "In order to show the new URLs of your sa.bros.us, you must copy this code anywhere of your blog or in a HTML page.";
	$idioma[preferencias_titulo] = "Add your preferences to the generated code.";
	$idioma[seleccionar_preferencias] = "Choose the preferences to display your sa.bros.us:";
	$idioma[numero_enlaces] = "Number of links:";
	$idioma[filtrar_etiqueta] = "Filter by tag:";
	$idioma[estilo_titulo] = "Style sheet of My sa.bros.us";
	$idioma[personalizar_estilo] = "If you want to personalize the sa.bros.us style, this is the XHTML structure used.";
	
	#generarBadgeTags.php
	$idioma[generar_badge_tags] = "generate tag cloud badge";
	$idioma[titulo_badge_tags] = "Add to your web the sa.bros.us tag cloud.";
	$idioma[descripcion_badge_tags] = "If you have a blog or a web, you can show the sa.bros.us tag cloud.";
	$idioma[descripcion_funcionalidad_tags] = "In order to show your sa.bros.us tag cloud, you must copy this code anywhere of your blog or in a HTML page.";
	$idioma[preferencias_titulo_tags] = "Add your preferences:";
	$idioma[seleccionar_preferencias_tags] = "Choose the preferences to display the sa.bros.us tag cloud:";
	$idioma[min_size_tags] = "Maximun font size:";
	$idioma[max_size_tags] = "Minimun font size:";
	$idioma[ejemplo_tags] = "Nube de ejemplo";
	$idioma[generar_codigo_tags] = "Generate code";
	$idioma[personalizar_estilo_tags] = "If you want to personalize the sa.bros.us style, this is the XHTML structure used.";
	
	#redactar.php
	$idioma[titulo_agregar] = "Write the data link.";
	$idioma[boton_agregar] = "add";
	$idioma[titulo_bookmarklet] = "Install the Bookmarklet.";
	$idioma[descripcion_bookmarklet] = "Drag to \"Bookmarks Toolbar\" the next link:";
	$idioma[agregar_a_sabrosus] = "add to sa.bros.us";	
	$idioma[agregar_etiquetas] = "Add tags";
		
	#rss.php
	$idioma[enlaces_de] = "Links of";
	
	#sabrosus.php
	$idioma[que_es] = "What is sa.bros.us?";
	$idioma[regresar_a] = "Back to sa.bros.us";
	$idioma[sab_descripcion] = "<strong>sa.bros.us</strong> is a system to organize the bookmarks added to your web. Same as de.icio.us, you can manage your bookmars, but with <strong>sa.bros.us</strong> you can do it in your own web page.";
	$idioma[proyecto_sab] = "<strong>sa.bros.us</strong> project is 'Open Source' (you can use and change the original code freely) and runs with PHP and MySQL. The official home page is <a href=\"http://sabros.us/\" title=\"Sa.bros.us\">this</a> and can be downloaded from <a href=\"http://sourceforge.net/projects/sabrosus/\" title=\"sa.bros.us project\">SourceForge.net</a>.";
	$idioma[creadores_sab] = "<a href=\"http://www.stanmx.com/\" title=\"StanMX\">Estanislao Vizcarra</a> and <a href=\"http://www.pecesama.net/\" title=\"Pedro Santana\">Pedro Santana</a> started the sa.bros.us project in 2005, with the collaboration of <a href=\"http://sourceforge.net/project/memberlist.php?group_id=143603\" title=\"Sa.bros.us team\">other members</a>.";
	$idioma[funcionalidades] = "FUNCTIONALITIES:";
	$idioma[func_1] = "Can manage the bookmarks through a control panel.";
	$idioma[func_2] = "Allows to add bookmars quickly through your web browser.";
	$idioma[func_3] = "Allows add tags of each bookmark, and you can use it to find other bookmars with the same category.";
	$idioma[func_4] = "Allows the RSS feed of all your bookmarks or a selected tag.";
	$idioma[func_5] = "Allows to create a 'cloud of tags' of all the tags inserted.";
	$idioma[func_6] = "It's easy and simple to install.";
	$idioma[func_7] = "Have a fashioned desing.";
	$idioma[func_8] = "It's 'Open Source'.";
	$idioma[func_9] = "It's in english.";

	#update.php
	$idioma[up_titulo] = "Update";
	$idioma[up_act_correcta] = "<strong>sa.bros.us</strong>'s update has been completed successfully. You can access the <a href=\"".$sabrUrl."/cpanel.php\">Control Panel</a> and start adding links or  <a href=\"".$sabrUrl."/index.php\">visiting the site.</a>";
	$idioma[up_act_correcta2] = "<strong>sa.bros.us</strong>'s update has been completed successfully. You can access the <a href=\"".$Sabrosus->sabrUrl."/cpanel.php\">Control Panel</a> and start adding links or  <a href=\"".$Sabrosus->sabrUrl."/index.php\">visiting the site.</a>";
	$idioma[up_error_config] = "<strong>Error</strong>: the<code>include/config.php</code> file doesn't have the write permission assigned to it. Please change this file permission settings and restart this update.";
	$idioma[up_error_config2] = "<strong>Warning</strong>: necessary information for this update can't be read. Please check whether the <code>include/config.php</code> file hasn't been replaced and that it doesn't contain data from a previously released version.";
	$idioma[up_form_leyenda] = "Sabrosus Update";
	$idioma[up_form_descr] = "The update is about to take place. Just click on the 'Update' button to get it running automatically.";
	$idioma[up_form_boton] = "Update";
	$idioma[up_act_hecha] = "<strong>Warning</strong>: The update already was made previously. It is not necessary to execute it again.";
	$idioma[up_caracteres_utf] = "If the characters appears to be rather rare, press the button to fix it.";
	
	#insertags.php
	$idioma[click_tag] = "Click to tag this entry with";
	
	#importar.php
	$idioma[imp_titulo] = "import bookmarks";
	$idioma[imp_archivo] = "File:";
	$idioma[imp_privacidad] = "Privacy:";
	$idioma[imp_publico] = "Public";
	$idioma[imp_privado] = "Private";
	$idioma[imp_importar] = "Import";
	$idioma[imp_instrucciones] = "Instructions";
	$idioma[imp_desc] = "Export your bookmarks from your browser to a file";
	$idioma[imp_ie] = "Internet Explorer: <kbd>File &gt; Import and Export... &gt; Export Favorites</kbd>";
	$idioma[imp_fx] = "Mozilla Firefox: <kbd>Bookmarks &gt; Manage Bookmarks... &gt; File &gt; Export...</kbd>";
	$idioma[imp_ns] = "Netscape: <kbd>Bookmarks &gt; Manage Bookmarks... &gt; Tools &gt; Export...</kbd>";
	$idioma[imp_inst] = "Click <kbd>Browse...</kbd> to find the saved bookmark file on your computer. The maximum size the file can be is 1MB";
	$idioma[imp_selecc] = "Select the default privacy setting for your imported bookmarks";
	$idioma[imp_daclic] = "Click <kbd>Import</kbd> to start importing the bookmarks; it may take a minute";
	$idioma[imp_impor_delicious] = "import from del.icio.us";
		
	#eliminar.php
	$idioma[eli_eliminar_enlace] = "delete link";
	$idioma[eli_desea_eliminar1] = "Do you want to delete this link?";
	$idioma[eli_desea_eliminar2] = "There's no undo here!!";

	#recordar.php
	$idioma[rec_titulo] = "remember password";
	$idioma[rec_legend] = "New password";
	$idioma[rec_email] = "E-mail:";
	$idioma[rec_msg_email] = "The new password was automatically generated - you might like to change your password to something easier to remember.<br />Your current login information is now: ";
	$idioma[rec_solicitar] = "get new password";
	$idioma[rec_descrip] = "If you have forgotten your password, we can send you a new password by e-mail, please indicate your e-mail address, your new password will be sent to you.";	$idioma[rec_email] = "E-mail:";
	$idioma[rec_error1] = "Impossible to send your password by email, because did not enter the administrator's e-mail";
	$idioma[rec_error2] = "The e-mail introduced is not the same as in the data base.";
	$idioma[rec_error3] = "An error has occurred. You may attempt to send ii again. If your attempt fails, please contact your System Administrator.";
	$idioma[rec_exito] = "An email containing your new password has been sent to your address. It contains easy instructions to complete this password change.";
	
	#importdelicious.php
	$idioma[deli_titulo] = "import from delicious";
	$idioma[deli_legend] = "Del.icio.us info";
	$idioma[deli_usuario] = "User:";
	$idioma[deli_pass] = "Password:";
	$idioma[deli_boton] = "import";
	$idioma[deli_act_correcta] = "The import process has been completed successfully. Were imported <strong>%no_importados%</strong> links.";
	$idioma[deli_enlaces_repe] = "Were not imported <strong>%no_noimportadosrepetidos%</strong> links because already were included in sa.bros.us.";
	$idioma[deli_volver] = "Back to control panel.";
	$idioma[deli_e401] = "Invalid user or password. Please try again.";
	$idioma[deli_error_desc] = "An error has occurred (Error  <strong>%no_error%</strong>). You may attempt to try it again.";
	$idioma[deli_instruc] = "In order to import the del.icio.us's links, introduce your login information.";
	$idioma[deli_imp_archivo] = "import from a file";
	
	//$idioma[] = "";
?>
