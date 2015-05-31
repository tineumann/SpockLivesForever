function initialize() {
		showJSON('horror');
}

/**
 * Blendet die Tabelle mit den gelisteten Horrorbuechern ein.
 * Blendet die Tabelle mit den gelisteten Romanbuechern aus.
 * Die Tabfarbe des Horror-Tabs wird auf den Standardwert von #3F48CC gesetzt.
 * Die Tabfarbe des Roman-Tabs wird auf den Wert blue gesetzt.
 */
function tab_horror_switcher() {
	document.getElementById('horror').style.backgroundColor="#3F48CC";
	document.getElementById('roman').style.backgroundColor="blue";
	
	showJSON('horror');
}

/**
 * Blendet die Tabelle mit den gelisteten Romanbuechern ein.
 * Blendet die Tabelle mit den gelisteten Horrorbuechern aus.
 * Die Tabfarbe des Roman-Tabs wird auf den Standardwert von #3F48CC gesetzt.
 * Die Tabfarbe des Horror-Tabs wird auf den Wert blue gesetzt.
 */
function tab_roman_switcher() {
	document.getElementById('horror').style.backgroundColor="blue";
	document.getElementById('roman').style.backgroundColor="#3F48CC";
	
	showJSON('roman');
}

/**
 * Die Tabelle mit den JSON-Objekten wird aus dem PHP-Request erzeugt und an die
 * JavaScript Funktion zurueckgegeben und in die div (in book.html) mit der id 'bookInventory' gespeichert.
 * Abhaengig vom uebergebenen JSON book object (aktuell moeglich: Roman, Horror)
 */

function showJSON(data) {
	var url = "getBooks.php";
	var parameter = "json="+data;
	if (data=="") {
		document.getElementById("inventoryTable").innerHTML="";
		return;
	} 
	if (window.XMLHttpRequest) {
		ajax=new XMLHttpRequest();
	} else {  // old browser compatibility (IE5, IE6)
		ajax=new ActiveXObject("Microsoft.XMLHTTP");
	}
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4 && ajax.status==200) {
			document.getElementById("inventoryTable").innerHTML=ajax.responseText;
		}
	}
  

  ajax.open("GET", "getBooks.php?json="+data, true);
  ajax.setRequestHeader('Content-Type', 'application/json');
  ajax.send();
}