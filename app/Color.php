<?php

namespace App;

use Illuminate\Database\Eloquent\Casts\Attribute;
use InvalidArgumentException;

class Color extends CLIModel
{
    protected $fillable = [
        'name',
        'hex',
    ];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: function (string $value) {
                $cleanedValue = trim(strtolower($value));
                $existingColor = Color::where('name', $cleanedValue)->first();
                if ($existingColor?->id !== $this->id) {
                    $print_name = ucfirst($cleanedValue);
                    throw new InvalidArgumentException("Color with name $print_name already exists");
                }

                return $cleanedValue;
            },
        );
    }

    protected function hex(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => '#'.$value,
            set: function (string $value) {
                $cleanedValue = ltrim($value, '#');
                if (! preg_match('/^[a-f0-9]{6}$/i', $cleanedValue)) {
                    throw new InvalidArgumentException("Invalid hex value: $cleanedValue");
                }

                return $cleanedValue;
            },
        );
    }
}
