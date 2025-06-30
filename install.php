<?php

\rex_sql_table::get(\rex::getTable('d2u_history'))
    ->ensureColumn(new rex_sql_column('history_id', 'INT(11) unsigned', false, null, 'auto_increment'))
    ->setPrimaryKey('history_id')
    ->ensureColumn(new \rex_sql_column('name', 'varchar(255)'))
    ->ensureColumn(new \rex_sql_column('year', 'INT(4)'))
    ->ensureColumn(new \rex_sql_column('picture', 'varchar(255)', false))
    ->ensureColumn(new \rex_sql_column('online_status', 'varchar(10)', true))
    ->ensure();
\rex_sql_table::get(\rex::getTable('d2u_history_lang'))
	->ensureColumn(new rex_sql_column('history_id', 'INT(10)', false))
	->ensureColumn(new rex_sql_column('clang_id', 'INT(10)', false))
	->ensureColumn(new rex_sql_column('description', 'text', true))
	->ensureColumn(new rex_sql_column('translation_needs_update', 'varchar(6)', true))
	->setPrimaryKey(['history_id', 'clang_id'])
	->ensure();

// Insert frontend translations
if (!class_exists(\TobiasKrais\D2UHistory\LangHelper::class)) {
    // Load class in case addon is deactivated
    require_once 'lib/LangHelper.php';
}
\TobiasKrais\D2UHistory\LangHelper::factory()->install();

// Update modules
include __DIR__ . DIRECTORY_SEPARATOR .'lib'. DIRECTORY_SEPARATOR .'Module.php';
$d2u_module_manager = new \TobiasKrais\D2UHelper\ModuleManager(\TobiasKrais\D2UHistory\Module::getModules(), '', 'd2u_history');
$d2u_module_manager->autoupdate();