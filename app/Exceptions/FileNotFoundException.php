<?php

namespace App\Exceptions;

use RuntimeException;

class FileNotFoundException extends RuntimeException
{
    public function __construct(string $file_path)
    {
        $message = "File $file_path does not exist.";
        parent::__construct($message);
    }
}
