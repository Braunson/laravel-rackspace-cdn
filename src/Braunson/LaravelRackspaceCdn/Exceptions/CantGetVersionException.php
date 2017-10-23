<?php

/**
 * @author Artem Molotov https://github.com/ArtemMolotov
 * @datetime 12.10.2017 14:27
 */

namespace Braunson\LaravelRackspaceCdn\Exceptions;

use \Exception;

class CantGetVersionException extends Exception
{
    protected $message = 'Can\'t get version from object';
}
