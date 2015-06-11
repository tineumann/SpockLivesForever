<?php

// Einbinden der Datenbankverbindung
include_once 'includes/db_connect.php';

// Speichere die Formulardaten in Variablen und filtere unnoetige Zeichen raus, z.B. aus 'Hans' wird Hans
$vorname = 	utf8_decode(filter_input ( INPUT_POST, 'vorname' ));
$nachname = 	utf8_decode(filter_input ( INPUT_POST, 'name' ));
$autor = 	utf8_decode(filter_input ( INPUT_POST, 'autor' ));
$titel = 	utf8_decode(filter_input ( INPUT_POST, 'titel' ));
$kapitel = 		    filter_input ( INPUT_POST, 'kapitel' );
$art = 		utf8_decode(filter_input ( INPUT_POST, 'art' ));
$isbn = 		    filter_input ( INPUT_POST, 'isbn' );
$jahr = 		    filter_input ( INPUT_POST, 'jahr' );
$auflage = 		    filter_input ( INPUT_POST, 'auflage' );
$genre = 	utf8_decode(filter_input ( INPUT_POST, 'genre' ));


if (isset ( $_POST["filmfavorit"] )) {
	$favorit = 'JA';
} else {
	$favorit = 'NEIN';
}

$regex = '/^[a-zA-ZäöüÄÖÜß ]+$/';

// Überpruefe den eingebenen Vorname auf korrekte Syntax
if (!preg_match($regex, $vorname) || $vorname=="") {
	$vorname="";
}

// Überpruefe den eingebenen Nachname auf korrekte Syntax
if (!preg_match($regex, $nachname) || $nachname=="") {
	$nachname="";
}

// Überpruefe den eingebenen Autor auf korrekte Syntax
if (!preg_match($regex, $autor) || $autor=="") {
	$autor="";
}


$regex = '/^[0-9]+$/';

// Überpruefe die eingebene ISBN-Nummer auf korrekte Syntax
if (!preg_match($regex, $isbn) || strlen($isbn)!=13 || $isbn=="") {
	$isbn = "";
}
	// Überpruefe das eingebene Jahr auf korrekte Syntax
if (!preg_match($regex, $jahr) || strlen($jahr)!=4 || $jahr<1000 || $jahr > date("Y") || $jahr=="") {
	$jahr="";
}

// Überpruefe die eingebene Auflage auf korrekte Syntax
if (!preg_match($regex, $auflage) || $auflage{0} == 0 || $jahr=="") {
	$auflage="";
}

// Ueberpruefung, ob der Benutzer bereits ein identisches Buch angelegt hat.
// Dies wird anhand der Benutzerinformationen und der ISBN-Nummer ueberprueft.
$prep_stmt = "SELECT ID FROM books WHERE (vorname = ? AND nachname = ? AND isbn = ?) LIMIT 1";
$stmt = $mysqli->prepare ( $prep_stmt );

if ($stmt) {
	$stmt->bind_param ( 'sss', $vorname, $nachname, $isbn );
	$stmt->execute ();
	$stmt->store_result ();
		
	if ($stmt->num_rows == 1) {
		// Der Benutzer hat bereits ein identisches Buch angelegt
		echo ("Der Benutzer hat bereits ein identisches Buch angelegt");
		
		// Aktualisiere den Favoritstatus
		if ($update_stmt = $mysqli->prepare ( "UPDATE books SET favorit = ? WHERE (vorname = ? AND nachname = ? AND isbn = ?)" )) {
			$update_stmt->bind_param ( 'ssss', $favorit, $vorname, $nachname, $isbn );
			// Führe die vorbereitete Anfragen aus.
			if (! $update_stmt->execute ()) {

				// Im Fehlerfalle versuchen alle vorbereiteten Statements zu schließen und die DB-Verbindung zu trennen
				mysqli_close($mysqli);
				$update_stmt->close();
				header ( 'Location: ../error.php?err=UPDATE_STATEMANT_FAIL' );
			}
		}
		$update_stmt->close();
	} else  {
		// Speichere die eingegebenen Buchinformationen in der Datenbank
		if ($insert_stmt = $mysqli->prepare ( "INSERT INTO books (vorname, nachname, autor, titel, kapitel, buchart, isbn, erscheinungsjahr, auflage, genre, favorit) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)" )) {
			$insert_stmt->bind_param ( 'sssssssssss', $vorname, $nachname, $autor, $titel, $kapitel, $art, $isbn, $jahr, $auflage, $genre, $favorit);
			// Führe die vorbereitete Anfragen aus.
			if (! $insert_stmt->execute ()) {
				$insert_stmt->close();
				mysqli_close($mysqli);
				header ( 'Location: ../error.php?err=INSERT_STATEMANT_FAIL' );
			}
		}
		$insert_stmt->close();
	}
}

mysqli_close($mysqli);

?>