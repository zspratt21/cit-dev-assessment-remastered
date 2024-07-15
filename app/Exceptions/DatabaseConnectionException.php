<?php

namespace App\Exceptions;

use RuntimeException;

class DatabaseConnectionException extends RuntimeException
{
    public function __construct($message = 'Error connecting to the configured database. Please check your database configuration.')
    {
        parent::__construct($message);
    }
}
