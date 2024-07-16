<?php

namespace App\Handlers\File;


use App\Exceptions\FileNotFoundException;

class FileHandler
{
    protected string $file_path;

    public function __construct(string $filePath)
    {
        $this->file_path = $filePath;
    }

    public function read(): string
    {
        if (! file_exists($this->file_path)) {
            throw new FileNotFoundException($this->file_path);
        }

        return file_get_contents($this->file_path);
    }

    public function write(string $content): void
    {
        file_put_contents($this->file_path, $content);
    }

}
