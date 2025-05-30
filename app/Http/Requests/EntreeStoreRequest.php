<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EntreeStoreRequest extends FormRequest
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
            'montant' => ['required', 'numeric', 'between:0,99999999999.99'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'integer'],
        ];
    }
}
