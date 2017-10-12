<?php

/**
 * @author Artem Molotov https://github.com/ArtemMolotov
 * @datetime 12.10.2017 10:40
 */

namespace Braunson\LaravelRackspaceCdn;

use Braunson\LaravelRackspaceCdn\Exceptions\CantGetVersionException;

class LaravelVersion
{
    /** @var string Laravel version */
    protected $version;

    /**
     * LaravelVersion constructor.
     *
     * @param \Illuminate\Contracts\Foundation\Application | \Illuminate\Foundation\Application $app
     * @throws CantGetVersionException
     */
    public function __construct($app = null)
    {
        if ($app === null) {
            $app = \App::getFacadeApplication();
        } elseif (!is_object($app)) {
            throw new CantGetVersionException();
        }

        // version() isset in Laravel 5.0+
        if (method_exists($app, 'version')) {
            $this->version = $app->version();
        } elseif (defined(get_class($app) . '::VERSION')) {
            $this->version = $app::VERSION;
        } else {
            throw new CantGetVersionException();
        }
    }

    /**
     * Compare App version with custom version
     *
     * @param string $version2
     * @param string $operator
     * @return bool
     */
    public function compare($version2, $operator = '>=')
    {
        return version_compare($this->version, $version2, $operator);
    }
}
