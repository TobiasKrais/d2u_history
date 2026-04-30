<?php

if (\rex::isBackend()) {
    echo '<h1>History Timeline</h1>';
    if ('REX_VALUE[2]' !== '') { /** @phpstan-ignore-line */
        echo 'Media Manager Typ fuer Event-Bilder: REX_VALUE[2]<br>'; /** @phpstan-ignore-line */
    }
    echo '<br />';
} else {
    // FRONTEND

    $last_on_top = 'REX_VALUE[1]' === 'true';
    $media_manager_type = 'REX_VALUE[2]'; /** @phpstan-ignore-line */

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
                .'<div class="col'. (0 == $counter ? '' : ' border-end') .'">&nbsp;</div>'
                .'<div class="col">&nbsp;</div>'
            .'</div>'
            .'<h5 class="m-2">'
                .'<span class="badge rounded-pill bg-light border">&nbsp;</span><span class="d-none">'. (int) $event->year .'</span>'
            .'</h5>'
            .'<div class="row h-50">'
                .'<div class="col'. ($counter == count($history_events) - 1 ? '' : ' border-end') .'">&nbsp;</div>'
                .'<div class="col">&nbsp;</div>'
            .'</div>'
            .'</div>';

        echo '<div class="row g-0">';
        if (0 == $counter % 2) {
            echo $spacer;
            echo $timeline;
        }

        echo '<div class="col-sm py-2">';
        echo '<div class="card">';
        if ('' !== $event->picture && \rex_media::get($event->picture) instanceof \rex_media) {
            $image_attributes = \TobiasKrais\D2UHelper\FrontendHelper::getResponsiveImageAttributes($media_manager_type, $event->picture, '(min-width: 576px) 50vw, 100vw');
            $alt = '' !== $event->name ? $event->name : (string) $event->year;
            echo '<div class="history-event-image">';
            echo '<img src="'. $image_attributes['src'] .'"'. $image_attributes['srcset_attr'] . $image_attributes['sizes_attr'] .' alt="'. rex_escape($alt) .'">';
            echo '</div>';
        }
        echo '<div class="card-body'. (1 == $counter % 2 ? ' left-card' : '') .'">';
        echo '<h4 class="card-title">'. (int) $event->year .'</h4>';
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
