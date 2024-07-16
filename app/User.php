<?php

namespace App;

use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected function nameAttribute(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: function (string $value) {
                return trim(strtolower($value));
            },
        );
    }

    protected function firstName(): Attribute
    {
        return $this->nameAttribute();
    }

    protected function lastName(): Attribute
    {
        return $this->nameAttribute();
    }

    protected function email(): Attribute
    {
        return Attribute::make(
            set: function (string $value) {
                $cleanedValue = trim(strtolower($value));
                if (! filter_var($cleanedValue, FILTER_VALIDATE_EMAIL)) {
                    throw new InvalidArgumentException("Invalid email: $cleanedValue");
                }
                $existingQuery = User::where('email', $cleanedValue);
                if ($existingQuery->exists() && $existingQuery->first()?->id !== $this->id) {
                    throw new InvalidArgumentException("Email $cleanedValue is already associated with another user.");
                }

                return $cleanedValue;
            },
        );
    }
}
