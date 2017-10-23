<?php

/**
 * @author Artem Molotov https://github.com/ArtemMolotov
 * @datetime 12.10.2017 13:15
 */

namespace Braunson\LaravelRackspaceCdn\Exceptions;

use \Exception;

class IncorrectAppVersionException extends Exception
{
    protected $message = 'Incorrect application version';
}
