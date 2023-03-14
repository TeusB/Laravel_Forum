<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;


class UniqueCustom implements ValidationRule
{

    private string $table;
    private string $column;

    public function __construct(string $table, string $column)
    {
        $this->table = $table;
        $this->column = $column;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (DB::table($this->table)->where($this->column, $value)->count()) {
            throw ValidationException::withMessages([$attribute => 'the ' . $attribute . ' is already taken'])->status(409);
        }
    }
}
