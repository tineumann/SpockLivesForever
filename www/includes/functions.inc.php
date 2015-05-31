<?php
function istDuplikat ($datei, $inhalt)
{
	$inhalt = preg_replace("/\r|\n/s", "", $inhalt);
	$inhalt = rtrim($inhalt);
	$datei = fopen($datei,"r");

	while(!feof($datei))
  	{
		$aktuelleZeile = fgets($datei);
		$aktuelleZeile = preg_replace("/\r|\n/s", "", $aktuelleZeile);
		$aktuelleZeile = rtrim($aktuelleZeile);


		if (strcmp($aktuelleZeile, $inhalt) == 0) {
			fclose($datei);
			return true;
		}
  	}
	fclose($datei);

	return false;
}
?>