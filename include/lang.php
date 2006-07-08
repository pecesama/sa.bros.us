<?php

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
?>
