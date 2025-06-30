<?php

$sql = rex_sql::factory();

// Delete tables
$sql->setQuery('DROP TABLE IF EXISTS ' . \rex::getTablePrefix() . 'd2u_history');
$sql->setQuery('DROP TABLE IF EXISTS ' . \rex::getTablePrefix() . 'd2u_history_lang');

// Delete language replacements
if (!class_exists(\TobiasKrais\D2UHistory\LangHelper::class)) {
    // Load class in case addon is deactivated
    require_once 'lib/LangHelper.php';
}
\TobiasKrais\D2UHistory\LangHelper::factory()->uninstall();
