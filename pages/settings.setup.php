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