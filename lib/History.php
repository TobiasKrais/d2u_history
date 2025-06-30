<?php

namespace TobiasKrais\D2UHistory;

use rex;
use rex_config;
use rex_sql;

/**
 * History Event class.
 */
class History implements \TobiasKrais\D2UHelper\ITranslationHelper
{
    /** @var int History Event database ID */
    public $history_id = 0;

    /** @var int Redaxo Language ID */
    public $clang_id = 0;

    /** @var string Event name */
    public $name = '';

    /** @var int Year */
    public $year = 0;

    /** @var string Picture */
    public $picture = '';

    /** @var string online status, either "online" or "offline" */
    public $online_status = 'offline';

    /** @var string Description text */
    public $description = '';

    /** @var string "yes" if translation needs update */
    public $translation_needs_update = 'delete';

    /**
     * Constructor.
     * @param int $history_id history Event ID
     * @param int $clang_id Redaxo language ID
     */
    public function __construct($history_id, $clang_id)
    {
        $this->clang_id = $clang_id;
        $query = 'SELECT * FROM '. rex::getTablePrefix() .'d2u_history AS history '
                .'LEFT JOIN '. rex::getTablePrefix() .'d2u_history_lang AS lang '
                    .'ON history.history_id = lang.history_id '
                .'WHERE history.history_id = '. $history_id .' '
                    .'AND (clang_id = '. $clang_id .') ';
        $result = rex_sql::factory();
        $result->setQuery($query);
        $num_rows = $result->getRows();

        if ($num_rows > 0) {
            $this->history_id = $result->getValue('history_id');
            $this->name = stripslashes($result->getValue('name'));
            $this->year = $result->getValue('year');
            $this->picture = $result->getValue('picture');
            $this->online_status = $result->getValue('online_status');
            $this->description = stripslashes(htmlspecialchars_decode($result->getValue('description')));
            $this->translation_needs_update = $result->getValue('translation_needs_update');
        }
    }

    /**
     * Changes the online status of this object.
     */
    public function changeStatus(): void
    {
        if ('online' === $this->online_status) {
            if ($this->history_id > 0) {
                $query = 'UPDATE '. rex::getTablePrefix() .'d2u_history '
                    ."SET online_status = 'offline' "
                    .'WHERE history_id = '. $this->history_id;
                $result = rex_sql::factory();
                $result->setQuery($query);
            }
            $this->online_status = 'offline';
        } else {
            if ($this->history_id > 0) {
                $query = 'UPDATE '. rex::getTablePrefix() .'d2u_history '
                    ."SET online_status = 'online' "
                    .'WHERE history_id = '. $this->history_id;
                $result = rex_sql::factory();
                $result->setQuery($query);
            }
            $this->online_status = 'online';
        }
    }

    /**
     * Deletes the object in all languages.
     * @param bool $delete_all If true, all translations and main object are deleted. If
     * false, only this translation will be deleted.
     */
    public function delete($delete_all = true): void
    {
        $query_lang = 'DELETE FROM '. rex::getTablePrefix() .'d2u_history_lang '
            .'WHERE history_id = '. $this->history_id
            . ($delete_all ? '' : ' AND clang_id = '. $this->clang_id);
        $result_lang = rex_sql::factory();
        $result_lang->setQuery($query_lang);

        // If no more lang objects are available, delete
        $query_main = 'SELECT * FROM '. rex::getTablePrefix() .'d2u_history_lang '
            .'WHERE history_id = '. $this->history_id;
        $result_main = rex_sql::factory();
        $result_main->setQuery($query_main);
        if (0 === $result_main->getRows()) {
            $query = 'DELETE FROM '. rex::getTablePrefix() .'d2u_history '
                .'WHERE history_id = '. $this->history_id;
            $result = rex_sql::factory();
            $result->setQuery($query);
        }
    }

    /**
     * Gets all events.
     * @param int $clang_id Redaxo language ID
     * @param bool $online_only if true, only online events are returned
     * @return array<int,self> array with History Event objects
     */
    public static function getAll($clang_id, $online_only = true)
    {
        $query = 'SELECT lang.history_id FROM '. rex::getTablePrefix() .'d2u_history_lang AS lang '
            .'LEFT JOIN '. rex::getTablePrefix() .'d2u_history AS history '
                .'ON lang.history_id = history.history_id '
            .'WHERE clang_id = '. $clang_id .' ';
        if ($online_only) {
            $query .= 'AND online_status = "online" ';
        }
        $query .= 'ORDER BY year ASC';
        $result = rex_sql::factory();
        $result->setQuery($query);
        $num_rows = $result->getRows();

        $history_events = [];
        for ($i = 0; $i < $num_rows; ++$i) {
            $history_event = new self($result->getValue('history_id'), $clang_id);
            $history_events[$history_event->history_id] = $history_event;
            $result->next();
        }

        return $history_events;
    }

    /**
     * Get objects concerning translation updates.
     * @param int $clang_id Redaxo language ID
     * @param string $type 'update' or 'missing'
     * @return array<int,self> array with history objects
     */
    public static function getTranslationHelperObjects($clang_id, $type)
    {
        $query = 'SELECT lang.history_id FROM '. rex::getTablePrefix() .'d2u_history_lang AS lang '
                .'LEFT JOIN '. rex::getTablePrefix() .'d2u_history AS main '
                    .'ON lang.history_id = main.history_id '
                .'WHERE clang_id = '. $clang_id ." AND translation_needs_update = 'yes' "
                .'ORDER BY name';
        if ('missing' === $type) {
            $query = 'SELECT main.history_id FROM '. rex::getTablePrefix() .'d2u_history AS main '
                    .'LEFT JOIN '. rex::getTablePrefix() .'d2u_history_lang AS target_lang '
                        .'ON main.history_id = target_lang.history_id AND target_lang.clang_id = '. $clang_id .' '
                    .'LEFT JOIN '. rex::getTablePrefix() .'d2u_history_lang AS default_lang '
                        .'ON main.history_id = default_lang.history_id AND default_lang.clang_id = '. rex_config::get('d2u_helper', 'default_lang') .' '
                    .'WHERE target_lang.history_id IS NULL '
                    .'ORDER BY name';
            $clang_id = (int) rex_config::get('d2u_helper', 'default_lang');
        }
        $result = rex_sql::factory();
        $result->setQuery($query);

        $objects = [];
        for ($i = 0; $i < $result->getRows(); ++$i) {
            $objects[] = new self($result->getValue('history_id'), $clang_id);
            $result->next();
        }

        return $objects;
    }

    /**
     * Updates or inserts the object into database.
     * @return bool true if successful
     */
    public function save()
    {
        $error = false;

        // Save the not language specific part
        $pre_save_history = new self($this->history_id, $this->clang_id);

        if (0 === $this->history_id || $pre_save_history !== $this) {
            $query = rex::getTablePrefix() .'d2u_history SET '
                    ."online_status = '". $this->online_status ."', "
                    ."picture = '". $this->picture ."', "
                    ."name = '". addslashes($this->name) ."', "
                    .'year = '. $this->year;

            if (0 === $this->history_id) {
                $query = 'INSERT INTO '. $query;
            } else {
                $query = 'UPDATE '. $query .' WHERE history_id = '. $this->history_id;
            }

            $result = rex_sql::factory();
            $result->setQuery($query);
            if (0 === $this->history_id) {
                $this->history_id = (int) $result->getLastId();
                $error = $result->hasError();
            }
        }

        if (!$error) {
            // Save the language specific part
            $pre_save_history = new self($this->history_id, $this->clang_id);
            if ($pre_save_history !== $this) {
                $query = 'REPLACE INTO '. rex::getTablePrefix() .'d2u_history_lang SET '
                        .'history_id = '. $this->history_id .', '
                        .'clang_id = '. $this->clang_id .', '
                        ."description = '". addslashes(htmlspecialchars($this->description)) ."', "
                        ."translation_needs_update = '". $this->translation_needs_update ."' ";

                $result = rex_sql::factory();
                $result->setQuery($query);
                $error = $result->hasError();
            }
        }

        return $error;
    }
}
