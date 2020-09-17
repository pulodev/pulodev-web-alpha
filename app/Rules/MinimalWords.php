<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MinimalWords implements Rule
{

    protected $minWord;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($minWord)
    {
        $this->minWord = $minWord;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return str_word_count($value) >= $this->minWord;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Minimal ' . $this->minWord . ' kata';
    }
}
