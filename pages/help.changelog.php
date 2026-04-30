<?php

?>
<h2>Changelog</h2>

<p>1.1.1-DEV:</p>
<ul>
	<li>Backend: CSRF-Schutz fuer Speichern-, Loesch- und Statusaktionen der Historienverwaltung ergaenzt.</li>
	<li>Backend: CSRF-Schutz fuer Modul-Installation, -Update und -Deinstallation auf der Setup-Seite ergaenzt.</li>        <li>Security: Die <code>media-is-in-use</code>-Extension-Points in <code>boot.php</code> verwenden jetzt gebundene Parameter statt SQL-String-Konkatenation mit <code>addslashes()</code>.</li>
        <li>Security: Die <code>save()</code>-Methode in <code>lib/History.php</code> verwendet jetzt gebundene Parameter statt SQL-String-Konkatenation mit <code>addslashes()</code>.</li>
        <li>Security: Modul-Ausgaben (<code>modules/21/1/output.php</code>, <code>modules/21/2/output.php</code>) härten Backend-Eingaben gegen XSS via <code>rex_escape()</code> für Event-Titel und Typecast (<code>(int)</code>) für Jahreszahlen.</li></ul>
<p>1.1.0:</p>
<ul>
	<li>Neues Modul 21-2 "D2U History - Timeline (BS5)" hinzugefügt.</li>
	<li>Modul 21-1 als "(BS4, deprecated)" markiert. Die BS4-Variante wird im nächsten Major Release entfernt.</li>
	<li>Benötigt d2u_helper &gt;= 2.1.0.</li>
	<li>Backend-Liste sortierbar gemacht und Standardsortierung von SQL-Query auf <code>rex_list</code>-<code>defaultSort</code> umgestellt.</li>
	<li>Backend-Menü angepasst: Einstellungen und Setup sind jetzt wie im d2u_immo Addon unter einem gemeinsamen Settings-Menü gebündelt.</li>
	<li>BS5-Modul 21-2 kann jetzt Event-Bilder ausgeben und erlaubt die Auswahl eines Media Manager Typs im Modul.</li>
</ul>
<p>1.0.2:</p>
<ul>
	<li>PHP-CS-Fixer Code Verbesserungen.</li>
	<li>rexstan Anpassungen.</li>
	<li>Modul 21-1: D2U History - Timeline: Barrierefreiheit verbessert.</li>
	<li>Anpassungen an D2U Helper >= 2.0.0.</li>
	<li>update.php und install.php vereinheitlicht.
</ul>
<p>1.0.1:</p>
<ul>
	<li>Anpassungen an Publish Github Release to Redaxo.</li>
	<li>Backend: Einstellungen und Setup Tabs rechts eingeordnet um sie vom Inhalt besser zu unterscheiden.</li>
	<li>Konvertierung der Datenbanktabellen zu utf8mb4.</li>
	<li>Sprachdetails werden ausgeblendet, wenn Speicherung der Sprache nicht vorgesehen ist.</li>
	<li>Bugfix: Deaktiviertes Addon zu deinstallieren führte zu fatal error.</li>
	<li>Bugfix: Beim Löschen von Medien die vom Addon verlinkt werden wurde der Name der verlinkenden Quelle in der Warnmeldung nicht immer korrekt angegeben.</li>
	<li>In den Einstellungen gibt es jetzt eine Option, eigene Übersetzungen in SProg dauerhaft zu erhalten.</li>
</ul>
<p>1.0.0:</p>
<ul>
	<li>Initiale Version.</li>
</ul>