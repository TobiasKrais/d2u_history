<?php

$this->includeFile(__DIR__.'/install.php'); /** @phpstan-ignore-line */

$sql = rex_sql::factory();
// Update database to 1.0.1
$sql->setQuery('ALTER TABLE `'. rex::getTablePrefix() .'d2u_history` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;');
$sql->setQuery('ALTER TABLE `'. rex::getTablePrefix() .'d2u_history_lang` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;');
