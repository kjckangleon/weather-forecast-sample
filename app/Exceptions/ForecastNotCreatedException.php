<?php

namespace App\Exceptions;

use Exception;

class ForecastNotCreatedException extends Exception
{
    /**
     * ForecastNotCreatedException Constructor
     *
     * @param string $message
     */
    public function __construct($message = 'Unable to save forecast')
    {
        parent::__construct($message);
    }
}
