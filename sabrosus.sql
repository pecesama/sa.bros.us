#
# Estructura de la tabla 'sab_sabrosus'
#

DROP TABLE IF EXISTS sab_sabrosus;
CREATE TABLE `sab_sabrosus` (
  `id_enlace` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL default '',
  `enlace` varchar(100) NOT NULL default '',
  `descripcion` text NOT NULL,
  `tags` varchar(75) NOT NULL default '',
  `fecha` datetime default NULL,
  PRIMARY KEY  (`id_enlace`)
) TYPE=MyISAM;



#
# Datos de la tabla 'sab_sabrosus'
#
INSERT INTO sab_sabrosus (id_enlace, title, enlace, descripcion, tags, fecha) VALUES("1", "Stanmx.com - Buscando la accesibilidad", "http://www.stanmx.com", "Página de Estanislao Vizcarra, autor de sa.bro.sus.", "css xhtml diseño web estandares cine php javascript", "2005-07-10 00:41:06");
INSERT INTO sab_sabrosus (id_enlace, title, enlace, descripcion, tags, fecha) VALUES("2", "Pecesama.Net [developing the future]", "http://www.pecesama.net", "Página de Pedro Santana, co-autor de sa.bros.us", "php programación web java javascript", "2005-07-10 00:42:04");

# 
# Estructura de tabla para la tabla 'sab_config'
#

CREATE TABLE `sab_config` (
  `site_name` varchar(250) NOT NULL default '',
  `site_title` varchar(250) NOT NULL default '',
  `site_url` varchar(250) NOT NULL default '',
  `sabrosus_url` varchar(250) NOT NULL default '',
  `url_friendly` tinyint(1) NOT NULL default '0',
  `idioma` varchar(10) NOT NULL default '',
  `limite_enlaces` int(3) NOT NULL default '0',
  `admin_email` varchar(250) NOT NULL default '',
  `admin_pass` varchar(250) NOT NULL default '',
  PRIMARY KEY  (`sabrosus_url`)
) TYPE=MyISAM;

# 
# Volcar la base de datos para la tabla 'sab_config'
# La contraseña asignada es '123' sin las comillas, luego desde el panel de opciones, puede cambiarla.
#

INSERT INTO `sab_config` VALUES ('Sitio Principal', 'Descripcion', 'http://www.tudominio.com', 'http://www.tudominio.com/sabrosus', 0, 'es-mx.php', 10, 'email@tudominio.com', '2648cf048094ece32947ae451db29a86');