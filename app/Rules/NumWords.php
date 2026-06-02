<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;
 
class NumWords implements Rule
{
    private $attribute;
    private $expected;
    
    public function __construct(int $expected)
    {
        $this->expected = $expected;
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
        $this->attribute = $attribute;
        $trimmed = trim($value);
        $numWords = count(explode(' ', $trimmed));
        // dd($numWords,$trimmed,$value,$this->expected);
        return $numWords >= $this->expected;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {

        return 'يجب ان يكون الاسم رباعي   ';
    }
}
