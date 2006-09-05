<?
/* ===========================

  sabros.us monousuario version 1.7
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

require_once('gettext.inc');

$idiomas = array();
$idiomas['es_MX'] = "Español de México";
$idiomas['en'] = "English";

function esIdioma($test) {
	global $idiomas;
	if (isset($idiomas[$test]))
		return true;
	else
		return false;
}

function initIdioma($lang = "es_MX") {
	global $locale;

	if (!esIdioma($locale) && esIdioma($lang)) {
		$locale = $lang;
	}

	// gettext setup
	$encoding = 'UTF-8';
	$domain = 'messages';
	T_setlocale(LC_MESSAGES, $locale);
	T_bindtextdomain($domain, './locale');
	T_bind_textdomain_codeset($domain, $encoding);
	T_textdomain($domain);
}
function get_laguajes() {
	global $idiomas;

	$sabr_langs = array ();
	$sabr_langs_loc = 'locale/';
	$sabr_langs_root = ABSPATH.$sabr_langs_loc;

	// Files in wp-content/plugins directory
	$sabr_langs_dir = @ dir($sabr_langs_root);
	if ($sabr_langs_dir) {
		while (($file = $sabr_langs_dir->read()) !== false) {
			if (preg_match('|^\.+$|', $file))
				continue;
				if (preg_match('|\.php$|', $file))
					$lang_files[] = $file;
		}
	}

	if (!$sabr_langs_dir || !$lang_files) {
		return $idiomas;
	}

	sort($lang_files);
	foreach ($lang_files as $lang_file) {
		include($sabr_langs_root."/".$lang_file);
	}

	return $idiomas;
}
?>
