<?php

/**
 * Diese Funktion erstellt eine json-parsingfaehige Buchdatei
 *
 * @param String $content    Das SQL-Ergebnis der Buechersammlung einer Genre
 *
 * @return String $json;
 */

function getBookJsonStructure($content)
{
	$jsonString = '{ "bookdata": [ ';
        while ($row = $content->fetch_assoc()) {
		$jsonString=$jsonString.'{ "autor": "'.$row["autor"].'", "titel": "'.$row["titel"].'", "kapitel": '.$row["kapitel"].', "buchart": "'.$row["buchart"].'", "isbn": '.$row["isbn"].', "erscheinungsjahr": '.$row["erscheinungsjahr"].', "auflage": '.$row["auflage"].' }, ';
        }

	$jsonString = substr($jsonString, 0, -2);
	$jsonString = $jsonString.' ] }';

	return $jsonString;
}

?>