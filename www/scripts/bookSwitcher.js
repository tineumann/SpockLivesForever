/**
 * Blendet die Tabelle mit den gelisteten Horrorbuechern ein.
 * Blendet die Tabelle mit den gelisteten Romanbuechern aus.
 * Die Tabfarbe des Horror-Tabs wird auf den Standardwert von #3F48CC gesetzt.
 * Die Tabfarbe des Roman-Tabs wird auf den Wert blue gesetzt.
 */
function tab_horror_switcher() {
    document.getElementById('tab_horror').style.display="";
	document.getElementById('tab_roman').style.display="none";
	document.getElementById('horror').style.backgroundColor="#3F48CC";
	document.getElementById('roman').style.backgroundColor="blue";
}

/**
 * Blendet die Tabelle mit den gelisteten Romanbuechern ein.
 * Blendet die Tabelle mit den gelisteten Horrorbuechern aus.
 * Die Tabfarbe des Roman-Tabs wird auf den Standardwert von #3F48CC gesetzt.
 * Die Tabfarbe des Horror-Tabs wird auf den Wert blue gesetzt.
 */
function tab_roman_switcher() {
    document.getElementById('tab_horror').style.display="none";
	document.getElementById('tab_roman').style.display="";
	document.getElementById('horror').style.backgroundColor="blue";
	document.getElementById('roman').style.backgroundColor="#3F48CC";
}

/**
 * Die Tabelle mit dem jeweiligen JSON Objekt wird angelegt.
 * Abhängig vom uebergebenen JSON book object (aktuell moeglich: Roman, Horror)
 */
function json_load(json_obj) {
	var i = 0;
	document.writeln("<table class='bookInventory'><tr>");
	document.writeln("<th>Autor</th><th>Titel</th><th>Kapitel</th><th>Art des Buches</th><th>ISBN</th><th>Erscheinungsjahr</th><th>Auflage</th></tr>");

	for(i=0;i<json_obj.bookdata.length;i++)
	{	
		document.writeln("<tr><td>"+ json_obj.bookdata[i].autor+"</td><td>"+ json_obj.bookdata[i].titel+"</td>");
		document.writeln("<td>"+ json_obj.bookdata[i].kapitel+"</td><td>"+ json_obj.bookdata[i].buchart+"</td>");
		document.writeln("<td>"+ json_obj.bookdata[i].ISBN+"</td><td>"+ json_obj.bookdata[i].erscheinungsjahr+"</td>");
		document.writeln("<td>"+ json_obj.bookdata[i].auflage+"</td></tr>");
	}
	document.writeln("</table>");
}