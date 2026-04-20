<?php
namespace TobiasKrais\D2UHistory;

/**
 * Class managing modules published by www.design-to-use.de.
 *
 * @author Tobias Krais
 */
class Module
{
    /**
     * Get modules offered by this addon.
     * @return array<int,\TobiasKrais\D2UHelper\Module> Modules offered by this addon
     */
    public static function getModules()
    {
        $modules = [];
        $modules[] = new \TobiasKrais\D2UHelper\Module('21-1',
            'D2U History - Timeline (BS4, deprecated)',
            2);
        $modules[] = new \TobiasKrais\D2UHelper\Module('21-2',
            'D2U History - Timeline (BS5)',
            1);
        return $modules;
    }
}
