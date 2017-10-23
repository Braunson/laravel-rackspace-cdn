<?php

/**
 * @author Artem Molotov https://github.com/ArtemMolotov
 * @datetime 13.10.2017 20:16
 */

namespace Braunson\LaravelRackspaceCdn;

use Braunson\LaravelRackspaceCdn\LaravelVersion as Version;

class ConfigExt extends \Config
{

    /**
     * Get config value from specified package (Laravel 4.x || 5.x)
     *
     * @param string $package
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getFrom($package, $key, $default = null)
    {
        $version = new Version();

        if ($version->compare('5.0', '>=')){
            return parent::get($package . '.' . $key, $default);
        } else{
            return parent::get($package . '::' . $key, $default);
        }

    }

}
