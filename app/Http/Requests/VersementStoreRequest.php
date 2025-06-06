<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VersementStoreRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'date' => ['required', 'date'],
            'montant' => ['required', 'numeric', 'between:-99999999.99,99999999.99'],
            'reference' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'integer'],
        ];
    }
}
