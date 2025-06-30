<?php

if (\rex::isBackend() && is_object(\rex::getUser())) {
    rex_perm::register('d2u_history[]', rex_i18n::msg('d2u_history_rights'));
    rex_perm::register('d2u_history[edit_data]', rex_i18n::msg('d2u_history_rights_edit_data'), rex_perm::OPTIONS);
    rex_perm::register('d2u_history[edit_lang]', rex_i18n::msg('d2u_history_rights_edit_lang'), rex_perm::OPTIONS);
    rex_perm::register('d2u_history[settings]', rex_i18n::msg('d2u_history_rights_settings'), rex_perm::OPTIONS);

    rex_extension::register('D2U_HELPER_TRANSLATION_LIST', rex_d2u_history_translation_list(...));
    rex_extension::register('CLANG_DELETED', rex_d2u_history_clang_deleted(...));
    rex_extension::register('MEDIA_IS_IN_USE', rex_d2u_history_media_is_in_use(...));
}

/**
 * Deletes language specific configurations and objects.
 * @param rex_extension_point<array<string>> $ep Redaxo extension point
 * @return array<string> Warning message as array
 */
function rex_d2u_history_clang_deleted(rex_extension_point $ep)
{
    $warning = $ep->getSubject();
    $params = $ep->getParams();
    $clang_id = $params['id'];

    // Delete
    $histories = \TobiasKrais\D2UHistory\History::getAll($clang_id, false);
    foreach ($histories as $history) {
        $history->delete(false);
    }

    // Delete language settings
    if (rex_config::has('d2u_history', 'lang_replacement_'. $clang_id)) {
        rex_config::remove('d2u_history', 'lang_replacement_'. $clang_id);
    }
    // Delete language replacements
    \TobiasKrais\D2UHistory\LangHelper::factory()->uninstall($clang_id);

    return $warning;
}

/**
 * Checks if media is used by this addon.
 * @param rex_extension_point<array<string>> $ep Redaxo extension point
 * @return array<string> Warning message as array
 */
function rex_d2u_history_media_is_in_use(rex_extension_point $ep)
{
    $warning = $ep->getSubject();
    $params = $ep->getParams();
    $filename = addslashes($params['filename']);

    // History
    $sql_history = rex_sql::factory();
    $sql_history->setQuery('SELECT history_id, name FROM `' . \rex::getTablePrefix() . 'd2u_history` '
        .'WHERE picture = "'. $filename .'"');

    // Prepare warnings
    // History
    for ($i = 0; $i < $sql_history->getRows(); ++$i) {
        $message = '<a href="javascript:openPage(\'index.php?page=d2u_history/history&func=edit&entry_id='.
            $sql_history->getValue('history_id') .'\')">'. rex_i18n::msg('d2u_history') .' - '. rex_i18n::msg('d2u_history_events') .': '. $sql_history->getValue('name') .'</a>';
        if (!in_array($message, $warning, true)) {
            $warning[] = $message;
        }
        $sql_history->next();
    }

    return $warning;
}

/**
 * Addon translation list.
 * @param rex_extension_point<array<string>> $ep Redaxo extension point
 * @return array<array<string,array<int,array<string,string>>|string>|string> Addon translation list
 */
function rex_d2u_history_translation_list(rex_extension_point $ep) {
    $params = $ep->getParams();
    $source_clang_id = (int) $params['source_clang_id'];
    $target_clang_id = (int) $params['target_clang_id'];
    $filter_type = (string) $params['filter_type'];

    $list = $ep->getSubject();
    $list_entry = [
        'addon_name' => rex_i18n::msg('d2u_history'),
        'pages' => []
    ];

    $history_events = \TobiasKrais\D2UHistory\History::getTranslationHelperObjects($target_clang_id, $filter_type);
    if (count($history_events) > 0) {
        $html_events = '<ul>';
        foreach ($history_events as $event) {
            if ('' === $event->name) {
                $event = new \TobiasKrais\D2UHistory\History($event->history_id, $source_clang_id);
            }
            $html_events .= '<li><a href="'. rex_url::backendPage('d2u_history/history', ['entry_id' => $event->history_id, 'func' => 'edit']) .'">'. $event->name .'</a></li>';
        }
        $html_events .= '</ul>';
        
        $list_entry['pages'][] = [
            'title' => rex_i18n::msg('d2u_history_events'),
            'icon' => 'rex-icon fa-flag',
            'html' => $html_events
        ];
    }

    $list[] = $list_entry;

    return $list;
}