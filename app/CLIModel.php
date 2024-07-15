<?php

namespace App;

use App\Exceptions\DatabaseConnectionException;
use App\Exceptions\MissingTableException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use PDOException;
use RuntimeException;

class CLIModel extends Model
{
    /**
     * @throws RuntimeException
     */
    public function __construct(array $attributes = [])
    {
        try {
            Schema::getConnection()->getPdo();
        } catch (PDOException) {
            throw new DatabaseConnectionException();
        }

        if (! Schema::hasTable($this->getTable())) {
            throw new MissingTableException($this->getTable());
        }

        parent::__construct($attributes);
    }
}
