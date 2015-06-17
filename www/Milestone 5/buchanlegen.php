<?php

/**
 * Die gemachten Eintragungen werden in einer Textdatei in Form von
 * Paulo Coelho, Der Alchimist, 35 Kapitel, Taschenbuch, 9783257237276, 1996, 3.Auflage;
 * gespeichert.
 */

if (isset ( $_POST ['autor'], $_POST ['titel'], $_POST ['kapitel'], $_POST ['art'], $_POST ['isbn'], $_POST ['jahr'], $_POST ['auflage'] )) {
	//Gibt die zu ueberschreibene Datei an, in der spaeter die ausgewerteten Formulardaten gespeichert werden
	$datei = 'books.txt';

	// Speichere die Formulardaten in Variablen und filtere unnoetige Zeichen raus, z.B. aus 'Hans' wird Hans
	$autor = 	filter_input ( INPUT_POST, 'autor' );
	$titel = 	filter_input ( INPUT_POST, 'titel' );
	$kapitel = 	filter_input ( INPUT_POST, 'kapitel' );
	$art = 		filter_input ( INPUT_POST, 'art' );
	$isbn = 	filter_input ( INPUT_POST, 'isbn' );
	$jahr = 	filter_input ( INPUT_POST, 'jahr' );
	$auflage = 	filter_input ( INPUT_POST, 'auflage' );

	// Speichere alle Variablen in einer 
	$inhalt = $autor.', '.$titel.', '.$kapitel.' Kapitel, '.$art.', '.$isbn.', '.$jahr.', '.$auflage.'. Auflage';

	$inhalt .= ";\r\n\r\n"; 
	file_put_contents($datei, $inhalt, FILE_APPEND);
	echo "Das Buch wurde erfolgreich hinzugef&uuml;gt. <a href='book_entry.html'>Zur&uuml;ck zur vorherigen Seite.</a>";

}

?>