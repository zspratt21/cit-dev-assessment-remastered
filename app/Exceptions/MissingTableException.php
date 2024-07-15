<?php

namespace App\Exceptions;

use RuntimeException;

class MissingTableException extends RuntimeException
{
    public function __construct($table)
    {
        $message = "Table $table does not exist. Please run migrations.";
        parent::__construct($message);
    }
}
