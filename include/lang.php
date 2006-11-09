<?
/* ===========================

  sabros.us monousuario version 1.8
  http://sabros.us/

  sabros.us is a free software licensed under GPL (General public license)

  =========================== */

require_once('streams.php');
require_once('gettext.php');

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
	global $locale, $l10n;

	if (!esIdioma($locale) && esIdioma($lang)) {
		$locale = $lang;
	}

	// gettext setup
	$input = new FileReader('locale/'. $locale .'/LC_MESSAGES/messages.mo');
	$l10n = new gettext_reader($input);
}

// Standard wrappers for xgettext
function __($text) {
	global $l10n;
	return $l10n->translate($text);
}

function T_ngettext($single, $plural, $number) {
	global $l10n;
	return $l10n->ngettext($single, $plural, $number);
}

function get_laguajes() {
	$lang_files="";
	global $idiomas;
	ob_start();
	$sabr_langs = array ();
	$sabr_langs_loc = 'locale/';
	$sabr_langs_root = ABSPATH.$sabr_langs_loc;

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
