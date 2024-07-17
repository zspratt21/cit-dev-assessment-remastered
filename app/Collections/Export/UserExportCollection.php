<?php

namespace App\Collections\Export;

use App\User;
use Illuminate\Database\Eloquent\Collection;

class UserExportCollection extends Collection
{
    public function toArray(): array
    {
        return $this->map(function (User $item) {
            return [
                'name' => $item->first_name,
                'surname' => $item->last_name,
                'email' => $item->email,
            ];
        })->all();
    }

    public function toJson($options = JSON_PRETTY_PRINT): false|string
    {
        return json_encode($this->toArray(), $options);
    }

    public function toCsv(): string
    {
        $data = '';
        $users = $this->toArray();
        $data .= 'name,surname,email'.PHP_EOL;
        foreach ($users as $user) {
            $data .= implode(',', $user).PHP_EOL;
        }

        return $data;
    }
}
