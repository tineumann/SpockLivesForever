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



// Ueberpruefung, ob der Benutzer existiert. Wenn NEIN - neuer Benutzer wird angelegt.
// $user_id von bestehendem oder neuem User wird gespeichert

$prep_stmt = "SELECT ID FROM user WHERE (vorname = ? AND nachname = ?) LIMIT 1";
$stmt = $mysqli->prepare ( $prep_stmt );
$stmt->bind_param ( 'ss', $vorname, $nachname );
$stmt->execute ();
$stmt->store_result ();

if ($stmt->num_rows == 1) {
	$stmt->bind_result($user_id);
	$stmt->fetch();
	$stmt->close();
} else {
	$insert_stmt = $mysqli->prepare ( "INSERT INTO user (vorname, nachname) VALUES (?, ?)" );
	$insert_stmt->bind_param ( 'ss', $vorname, $nachname);
	$insert_stmt->execute ();
	$insert_stmt->close();

	$stmt = $mysqli->prepare ( $prep_stmt );
	$stmt->bind_param ( 'ss', $vorname, $nachname );
	$stmt->execute ();
	$stmt->store_result ();

	if ($stmt->num_rows == 1) {
		$stmt->bind_result($user_id);
		$stmt->fetch();
	}
	$stmt->close();
}



// Ueberpruefung, ob der User dieses Buch bereits angelegt hat.
// Wenn JA - Das einzgie was passiert, dass der Favoritstatus überschrieben wird. --> Somit nachträgliches Ändern des Favoritenstatus möglich
// Wenn NEIN - Zwischentabelle hasbook wird gefüllt.

$prep_stmt = "SELECT book_id FROM hasbook WHERE (user_id = ? AND book_id = ?) LIMIT 1";
$stmt = $mysqli->prepare ( $prep_stmt );
$stmt->bind_param ( 'ss', $user_id, $isbn );
$stmt->execute ();
$stmt->store_result ();

if($stmt->num_rows == 1) {

	$update_stmt = $mysqli->prepare ( "UPDATE hasbook SET favorit = ? WHERE (user_id = ? AND book_id = ?)" );
	$update_stmt->bind_param ( 'sss', $favorit, $user_id, $isbn);
	$update_stmt->execute ();
	$update_stmt->close();

} else {
	
	$insert_stmt = $mysqli->prepare ( "INSERT INTO books (autor, titel, kapitel, buchart, isbn, erscheinungsjahr, auflage, genre) VALUES (?, ?, ?, ?, ?, ?, ?, ?)" );
	$insert_stmt->bind_param ( 'ssssssss', $autor, $titel, $kapitel, $art, $isbn, $jahr, $auflage, $genre);
	$insert_stmt->execute ();

	$insert_stmt = $mysqli->prepare ( "INSERT INTO hasbook (user_id, book_id, favorit) VALUES (?, ?, ?)" );
	$insert_stmt->bind_param ( 'sss', $user_id, $isbn, $favorit);
	$insert_stmt->execute ();
	$insert_stmt->close();
}

mysqli_close($mysqli);

?>