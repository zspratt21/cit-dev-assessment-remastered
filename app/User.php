<?php

namespace App;

use App\Collections\Export\UserExportCollection;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

class User extends CLIModel
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
    ];

    public function full_name(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    protected function nameAttribute(string $field): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: function (string $value) use ($field) {
                if (empty($value)) {
                    throw new InvalidArgumentException("$field cannot be empty");
                }

                return trim(strtolower($value));
            },
        );
    }

    protected function firstName(): Attribute
    {
        return $this->nameAttribute('name');
    }

    protected function lastName(): Attribute
    {
        return $this->nameAttribute('surname');
    }

    protected function email(): Attribute
    {
        return Attribute::make(
            set: function (string $value) {
                $cleanedValue = trim(strtolower($value));
                if (! filter_var($cleanedValue, FILTER_VALIDATE_EMAIL)) {
                    throw new InvalidArgumentException("Invalid email: $cleanedValue");
                }
                $existingQuery = $this->where('email', $cleanedValue);
                if ($existingQuery->exists() && $existingQuery->first()?->id !== $this->id) {
                    throw new InvalidArgumentException("Email $cleanedValue is already associated with another user.");
                }

                return $cleanedValue;
            },
        );
    }

    public static function export(Collection $models): UserExportCollection
    {
        return new UserExportCollection($models->all());
    }

    public static function importFromJson(string $json): array
    {
        $decoded_json = json_decode($json, true);
        if (! $decoded_json) {
            throw new InvalidArgumentException('Invalid JSON data. Please check your JSON file.');
        }

        return $decoded_json;
    }

    public static function importFromCsv(string $csv): array
    {
        $lines = explode(PHP_EOL, $csv);
        $users = [];
        $header = str_getcsv(array_shift($lines));
        foreach ($lines as $line) {
            if (! empty($line)) {
                $fields = str_getcsv($line);
                $user = [
                    $header[0] => $fields[0],
                    $header[1] => $fields[1],
                    $header[2] => $fields[2],
                ];
                $users[] = $user;
            }
        }
        if (empty($users)) {
            throw new InvalidArgumentException('No valid data found in CSV file.');
        }

        return $users;
    }
}
