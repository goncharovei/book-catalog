<?php

namespace App\Front\Book\Http\Requests;

use App\Front\Book\Service\BookDataTable\BookDataTableFilterDto;
use Illuminate\Foundation\Http\FormRequest;

class BookSearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'search.value' => 'string|min:2|max:128|nullable'
        ];
    }

    public function getDto(): BookDataTableFilterDto
    {
        return BookDataTableFilterDto::fromArray($this->validated());
    }

    public function validated($key = null, $default = null): array
    {
        return [
            'search' => parent::validated('search.value')
        ];
    }
}
