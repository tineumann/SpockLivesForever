<?php

/**
 * Die uebergebene Genre wird die passende JSON-Datei im Regelfall bereitstellen und an den Client zuruecksenden.
 */

// JSON Definition
header('Content-Type: application/json');

// json Request
if (isset ( $_GET["json"] )) {
	$json=$_GET["json"];
	// Pfad zur JSON Objekt-Datei
	$filename = 'scripts/json/'.$json.'_books.json';

	// Daten werden ausgewertet und JSON-Datei wird ausgegeben. Im Fehlerfalle wird ein leerer String ausgeworfen
	if (file_exists($filename)) {
		$json_obj = file_get_contents($filename);
		$json_obj = utf8_encode($json_obj); 
		echo $json_obj;

	} else {
		echo("");
	}
}

?>