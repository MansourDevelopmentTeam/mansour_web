<?php

namespace App\Rules\Admin;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\Rule;

class Slug implements Rule
{
    /**
     * Table name.
     *
     * @var string
     */
    protected $table;
    /**
     * The id of the record.
     *
     * @var int|null
     */
    protected $ignore_id;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(string $table, $ignore_id = null)
    {
        $this->table = $table;
        $this->ignore_id = $ignore_id;
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
        $slug = Str::slug($value, '-');

        $unique = DB::table($this->table);

        if ($this->ignore_id) {
            $unique = $unique->where('id', '!=', $this->ignore_id);
        }
        
        return $unique->where('slug', $slug)->doesntExist();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The slug attribute is already exists in {$this->table} table";
    }
}
