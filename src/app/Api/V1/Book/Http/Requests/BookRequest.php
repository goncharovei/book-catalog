<?php

namespace App\Api\V1\Book\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Illuminate\Contracts\Validation\ValidationRule;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isbnUniqueRule = Rule::unique('books')
            ->where(function (Builder $query) {
                $query->where('publisher_id', $this->user()->id);
            });

        return [
            'isbn' => ['required', 'string', 'min:10', 'max:20', $isbnUniqueRule],
            'name' => 'required|string|min:2|max:255',
            'author_names' => 'required|array|min:1|max:5',
            'author_names.*' => 'string|min:5|max:50',
            'year_publication' => 'required|date_format:Y|after_or_equal:1900|before_or_equal:' . now()->year,
            'detail_link' => 'required|url|max:255'
        ];
    }

    public function validated($key = null, $default = null): array
    {
        return array_rename_keys(
            data: parent::validated(),
            oldKeys: ['author_names'],
            newKeys: ['authors']
        );
    }
}
