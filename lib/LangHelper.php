<?php
namespace TobiasKrais\D2UHistory;

use rex_clang;
use rex_config;

/**
 * Offers helper functions for language issues.
 */
class LangHelper extends \TobiasKrais\D2UHelper\ALangHelper
{
    /**
     * @var array<string,string> Array with english replacements. Key is the wildcard,
     * value the replacement.
     */
    public $replacements_english = [
        'd2u_history_interactive_time_travel' => 'Interactive Time Travel',
    ];

    /**
     * @var array<string,string> Array with german replacements. Key is the wildcard,
     * value the replacement.
     */
    protected array $replacements_german = [
        'd2u_history_interactive_time_travel' => 'Interaktive Zeitreise',
    ];

    /**
     * @var array<string,string> Array with french replacements. Key is the wildcard,
     * value the replacement.
     */
    protected array $replacements_french = [
        'd2u_history_interactive_time_travel' => 'Voyage interactif dans le temps',
    ];

    /**
     * @var array<string,string> Array with spanish replacements. Key is the wildcard,
     * value the replacement.
     */
    protected array $replacements_spanish = [
        'd2u_history_interactive_time_travel' => 'Viaje interactivo en el tiempo',
    ];

    /**
     * @var array<string,string> Array with russian replacements. Key is the wildcard,
     * value the replacement.
     */
    protected array $replacements_russian = [
        'd2u_history_interactive_time_travel' => 'Интерактивное путешествие во времени',
    ];

    /**
     * @var array<string,string> Array with chinese replacements. Key is the wildcard,
     * value the replacement.
     */
    protected array $replacements_chinese = [
        'd2u_history_interactive_time_travel' => '互动时间旅行',
    ];

    /**
     * Factory method.
     * @return d2u_immo_lang_helper Object
     */
    public static function factory()
    {
        return new self();
    }

    /**
     * Installs the replacement table for this addon.
     */
    public function install(): void
    {
        foreach ($this->replacements_english as $key => $value) {
            foreach (rex_clang::getAllIds() as $clang_id) {
                $lang_replacement = rex_config::get('d2u_history', 'lang_replacement_'. $clang_id, '');

                // Load values for input
                if ('chinese' === $lang_replacement && isset($this->replacements_chinese) && isset($this->replacements_chinese[$key])) {
                    $value = $this->replacements_chinese[$key];
                } elseif ('french' === $lang_replacement && isset($this->replacements_french) && isset($this->replacements_french[$key])) {
                    $value = $this->replacements_french[$key];
                } elseif ('german' === $lang_replacement && isset($this->replacements_german) && isset($this->replacements_german[$key])) {
                    $value = $this->replacements_german[$key];
                } elseif ('russian' === $lang_replacement && isset($this->replacements_russian) && isset($this->replacements_russian[$key])) {
                    $value = $this->replacements_russian[$key];
                } else {
                    $value = $this->replacements_english[$key];
                }

                $overwrite = 'true' === rex_config::get('d2u_history', 'lang_wildcard_overwrite', false) ? true : false;
                parent::saveValue($key, $value, $clang_id, $overwrite);
            }
        }
    }
}
