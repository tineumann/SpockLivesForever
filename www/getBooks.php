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
 
	$data = json_decode($json_obj, TRUE);

	echo("<table class='bookInventory'><tr>");
	echo("<th>Autor</th><th>Titel</th><th>Kapitel</th><th>Art des Buches</th><th>ISBN</th><th>Erscheinungsjahr</th><th>Auflage</th></tr>");

	for($i=0; $i<count($data['bookdata']); $i++) {
		echo("<tr><td>".$data['bookdata'][$i]["autor"]."</td><td>".$data['bookdata'][$i]["titel"]."</td>");
		echo("<td>".$data['bookdata'][$i]["kapitel"]."</td><td>".$data['bookdata'][$i]["buchart"]."</td>");
		echo("<td>".$data['bookdata'][$i]["ISBN"]."</td><td>".$data['bookdata'][$i]["erscheinungsjahr"]."</td>");
		echo("<td>".$data['bookdata'][$i]["auflage"]."</td><tr/>");
	}

	echo("</table>");
} else {
	echo("<table class='bookInventory'><tr>");
	echo ("<tr><td>Es ist irgendetwas schief gelaufen. Falls das Problem noch einmal auftreten sollte, schreiben Sie uns eine E-Mail!</td></tr>");
	echo ("<tr><td><b>info@nixgehtmehr.de</b></td></tr>");
	echo("</table>");
}
?>