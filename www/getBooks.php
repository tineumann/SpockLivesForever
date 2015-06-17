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
}

?>