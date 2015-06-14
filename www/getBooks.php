<?php
include_once ("includes/db_connect.php");
include_once ("includes/functions.inc.php");

// JSON Header
// header('Content-Type: application/json');


/**
 * Auswertung aller Datenbankeintraege der Tabelle books, je nach uebergebener Genre
 * mit Zuhilfename einer erstellten Funktion getBookJsonStructure().
 *
 */


/* Ueberpruefung, da uebergebene Variable nicht leer sein darf und diese mindestens aus 4 Zeichen (Genre: Doku) bestehen muss.
 * Dadurch koennen Abkuerzungen uebergeben werden und die passenden Eintraege ebenfalls gefunden werden z.B. mit 'Roman' wird
 * ebenfalls 'Romanze' durchsucht. Kein Eintrag wuerde ohne die Mindestzeichenanzahl bzw. die ISSET-Ueberpruefung die gesamte
 * Tabelle auslesbar machen. --> Sicherheitsaspekt */
if (isset ( $_GET["json"] ) AND strlen($_GET["json"])>3) {

	$json=$_GET["json"]."%";

	if ($stmt = $mysqli->prepare("SELECT autor, titel, kapitel, buchart, isbn, erscheinungsjahr, auflage FROM books WHERE genre LIKE ?")) {
 		$stmt->bind_param("s", $json);
        	$stmt->execute();
        	$result = $stmt->get_result();
		$stmt->close(); 	// Statement schließen, da nicht weiter benoetigt
		mysqli_close($mysqli); 	// Datenbankverbindung trennen, da nicht weiter benoetigt

		// Dadurch parsen in bookSwitcher.js moeglich
		echo getBookJsonStructure($result);
    	}


	/* Milestone 5 - ersetzt mit PHP - 06-10-2015

	// Pfad zur JSON Objekt-Datei
	 * $filename = 'scripts/json/'.$json.'_books.json';
	 * $json_test = file_get_contents($filename);
	 * $json_test = utf8_encode($json_test); 
	 * echo $json_test;

	// Daten werden ausgewertet und JSON-Datei wird ausgegeben. Im Fehlerfalle wird ein leerer String ausgeworfen
	 * if (file_exists($filename)) {
	 *	$json_obj = file_get_contents($filename);
	 *	$json_obj = utf8_encode($json_obj); 
	 *	echo $json_obj;
	 * } else {
	 *	echo("");
	}*/
}

?>