<?php

if (\rex::isBackend()) {
    echo '<h1>History Timeline</h1>';
    echo '<br />';
} else {
    // FRONTEND
    $sprog = rex_addon::get('sprog');
    $tag_open = $sprog->getConfig('wildcard_open_tag');
    $tag_close = $sprog->getConfig('wildcard_close_tag');

    $last_on_top = 'REX_VALUE[1]' == 'true' ? true : false;

    $history_events = \TobiasKrais\D2UHistory\History::getAll(rex_clang::getCurrentId(), true);
    if ($last_on_top) {
        $history_events = array_reverse($history_events);
    }

    $spacer = '<div class="col-sm"></div>';

    // History Events
    echo '<div class="container py-2 mt-4 mb-4 history-event">';

    $counter = 0;
    foreach ($history_events as $event) {

        $timeline = '<div class="col-sm-1 text-center flex-column d-none d-sm-flex">'
            .'<div class="row h-50">'
                .'<div class="col'. (0 == $counter ? '' : ' border-right') .'">&nbsp;</div>'
                .'<div class="col">&nbsp;</div>'
            .'</div>'
            .'<h5 class="m-2">'
                .'<span class="badge badge-pill bg-light border">&nbsp;</span><span class="d-none">'. $event->year .'</span>'
            .'</h5>'
            .'<div class="row h-50">'
                .'<div class="col'. ($counter == count($history_events) - 1 ? '' : ' border-right') .'">&nbsp;</div>'
                .'<div class="col">&nbsp;</div>'
            .'</div>'
            .'</div>';

        echo '<div class="row no-gutters">';
        if (0 == $counter % 2) {
            echo $spacer;
            echo $timeline;
        }

        echo '<div class="col-sm py-2">';
        echo '<div class="card">';
        echo '<div class="card-body'. (1 == $counter % 2 ? ' left-card' : '') .'">';
        echo '<h4 class="card-title">'. $event->year .'</h4>';
        echo '<p class="card-text">'. TobiasKrais\D2UHelper\FrontendHelper::prepareEditorField($event->description) .'</p>';
        echo '</div>';
        echo '</div>';
        echo '</div>';

        if (1 == $counter % 2) {
            // Spacer
            echo $timeline;
            echo $spacer;
        }
        echo '</div>';
        ++$counter;
    }

    echo '</div>';
}
