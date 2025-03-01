<?php

namespace App\Api\V1\Book\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;

class BookUpdatePartialRequest extends BookRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = array_filter(parent::rules(), function ($rule, $filedName){
            return $this->has($filedName);
        }, ARRAY_FILTER_USE_BOTH);
        if (empty($rules))
        {
            throw new \InvalidArgumentException('The request does not contain any of the fields ' . implode(', ', array_keys($rules)));
        }

        return $rules;
    }

}
