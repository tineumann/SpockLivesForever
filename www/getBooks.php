<?php
// JSON Definition
header('Content-Type: application/json');

// json Request

$json=$_GET["json"];
// Pfad zur JSON Objekt-Datei
$filename = 'scripts/json/'.$json.'_books.json';

// Daten werden ausgewertet und JSON-Datei wird ausgegeben. Im Fehlerfalle Fehlermeldung.
if (file_exists($filename)) {
	$json_obj = file_get_contents($filename);
	$json_obj = utf8_encode($json_obj); 
	echo $json_obj;

} else {
	echo("<table class='bookInventory'><tr>");
	echo ("<tr><td>Es ist irgendetwas schief gelaufen. Falls das Problem noch einmal auftreten sollte, schreiben Sie uns eine E-Mail!</td></tr>");
	echo ("<tr><td><b>info@nixgehtmehr.de</b></td></tr>");
	echo("</table>");
}
?>