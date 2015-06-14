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
			jsonString=ajax.responseText;
			jsonHTMLFormat = "<table class='bookInventory'><tr><th>Autor</th><th>Titel</th><th>Kapitel</th><th>Art des Buches</th><th>ISBN</th><th>Erscheinungsjahr</th><th>Auflage</th></tr>";
			if (jsonString != '' && jsonString.search("titel") != -1) {
				jsonObj = JSON.parse(jsonString);
			
				for(i=0;i<jsonObj.bookdata.length;i++) {
					jsonHTMLFormat=jsonHTMLFormat + "<tr><td>" + jsonObj.bookdata[i].autor + "</td><td>" + jsonObj.bookdata[i].titel + "</td><td>" + jsonObj.bookdata[i].kapitel + "</td><td>" + jsonObj.bookdata[i].buchart + "</td><td>" + jsonObj.bookdata[i].isbn + "</td><td>" + jsonObj.bookdata[i].erscheinungsjahr + "</td><td>" + jsonObj.bookdata[i].auflage + "</td></tr>";
				}
			} else {
				jsonHTMLFormat=jsonHTMLFormat + "<tr><td colspan='7'>Zu dieser Genre sind keine B&uuml;cher vorhanden oder die Genre ist ungültig.</td></tr>";
			} 
			
			jsonHTMLFormat=jsonHTMLFormat + "</table>";
			document.getElementById("inventoryTable").innerHTML=jsonHTMLFormat; // jsonHTMLFormat

		}
	}
  

  ajax.open("GET", "getBooks.php?json="+data, true);
  ajax.setRequestHeader('Content-Type', 'application/json');
  ajax.send();
}