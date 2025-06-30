<?php
/*
 * Modules
 */
$d2u_module_manager = new \TobiasKrais\D2UHelper\ModuleManager(\TobiasKrais\D2UHistory\Module::getModules(), 'modules/', 'd2u_history');

// \TobiasKrais\D2UHelper\ModuleManager actions
$d2u_module_id = rex_request('d2u_module_id', 'string');
$paired_module = rex_request('pair_'. $d2u_module_id, 'int');
$function = rex_request('function', 'string');
if ('' !== $d2u_module_id) {
    $d2u_module_manager->doActions($d2u_module_id, $function, $paired_module);
}

// \TobiasKrais\D2UHelper\ModuleManager show list
$d2u_module_manager->showManagerList();

/*
 * Templates
 */
?>
<h2>Beispielseiten</h2>
<ul>
	<li>D2U History Timeline Addon: <a href="https://www.kaltenbach.com/de/unternehmen/#geschichte" target="_blank">
		https://www.kaltenbach.com/de/unternehmen/#geschichte</a>.</li>
	<li>D2U History Timeline Addon: <a href="https://meier-krantechnik.de/unternehmen/" target="_blank">
		https://meier-krantechnik.de/unternehmen/</a>.</li>
</ul>
<h2>Support</h2>
<p>Fehlermeldungen bitte über das Kontaktformular unter
	<a href="https://github.com/TobiasKrais/d2u_history" target="_blank">https://github.com/TobiasKrais/d2u_history</a> melden.</p>
<h2>Changelog</h2>

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