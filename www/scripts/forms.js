/** Diese Funktion überprueft die im Formularfeld eingegebenen Werte auf Gueltigkeit,
  * gemaess der Aufgabebeschreibung 2 des 3. Meilensteins */
function createBookForm(form, vorname, name, titel, autor, isbn, kapitel, jahr, auflage) {
	
	/* Bei erneuter Syntax-Pruefung werden "die Karten neu gemischt",
	   d.h. die in einem vorherigen Durchlauf rot markierten Input-Felder
	   werden wieder in den Urzustand zurueckgesetzt */
	document.getElementById(vorname.name).style.borderColor="";
	document.getElementById(name.name).style.borderColor="";
	document.getElementById(titel.name).style.borderColor="";
	document.getElementById(autor.name).style.borderColor="";
	document.getElementById(isbn.name).style.borderColor="";
	document.getElementById(jahr.name).style.borderColor="";
	document.getElementById(auflage.name).style.borderColor="";

	/* Die Variable die bei mindestens einem Fehler auf true gesetzt wird,
	   wird ebenfalls zurueckgesetzt */
	fehlerGefunden = false;

    re = /^[\sa-zßA-ZäöüÄÖÜ]+$/;
    // Überpruefe den eingebenen Vorname auf korrekte Syntax
    if(!re.test(vorname.value)) {
        fehlerGefunden=getInvalidInputMessage(fehlerGefunden, form.vorname);
    }

    // Überpruefe den eingegebenen Namen auf korrekte Syntax
    if(!re.test(name.value)) { 
        fehlerGefunden=getInvalidInputMessage(fehlerGefunden, form.name);
    }

    // Überpruefe den eingegebenen Buchautor auf korrekte Syntax
    if(!re.test(autor.value)) { 
        fehlerGefunden=getInvalidInputMessage(fehlerGefunden, form.autor);
    }

    if (titel.value == '') {
        fehlerGefunden=getInvalidInputMessage(fehlerGefunden, form.titel);
    }

	
    // Überpruefe die eingegebene ISBN-Nummer auf korrekte Syntax
	re = /^[0-9]+$/;
    if(!re.test(form.isbn.value) || form.isbn.value.length!=13) { 
        fehlerGefunden=getInvalidInputMessage(fehlerGefunden, form.isbn);
    }

    // Überpruefe die eingegebene Kapitel-Nummer auf korrekte Syntax	
	if(!re.test(form.kapitel.value)) { 
    fehlerGefunden=getInvalidInputMessage(fehlerGefunden, form.kapitel);
    }
	
	// Überpruefe das eingegebene Erscheinungsjahr auf korrekte Syntax
    if(!re.test(form.jahr.value) || form.jahr.value<1000 || form.jahr.value>new Date().getFullYear()) { 
        fehlerGefunden=getInvalidInputMessage(fehlerGefunden, form.jahr);
    }
	
	// Überpruefe die eingegebene Auflage auf korrekte Syntax
    if(!re.test(form.auflage.value) || form.auflage.value.charAt(0) == 0) {
        fehlerGefunden=getInvalidInputMessage(fehlerGefunden, form.auflage);
    }
	
	//Wenn true zurückgegeben wird, sind alle Felder gültig ausgefüllt worden.
	return !fehlerGefunden;

}

/** Diese Funktion regelt, dass bei mehr als einem falsch ausgefuellten Input-Feld,
  * nur eine Fehlermeldung erscheint, und das erste fehlerhafte Input-Feld mit
  * dem Cursor fokusiert wird.
  * Die Funktion regelt auch, dass ale falsch ausgefuellten Input-Felder rot markiert werden.
  * Der Rueckgabewert ist true, damit die bool'sche Variable fehlerGefunden auf true gesetzt wird.
 */
function getInvalidInputMessage(fehlerGefunden, inputField) {

	 // Fokusiert erste falsche Eingabe und gibt eine Fehlermeldung aus.
	 if( fehlerGefunden==false) {
		inputField.focus();
		
		// unescape, damit Umlaute nicht als Hieroglyphen angezeigt werden.
		alert(unescape("Einige Eingaben sind fehlerhaft. Bitte %FCberpr%FCfen Sie ihre Eingaben"));
		fehlerGefunden=true;
	 }
	 
	 // Faerbt den Rahmen von falsch ausgefuellten Feldern rot.
	 document.getElementById(inputField.name).style.borderColor="red";
	 return true;
}