<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TodoStoreUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Sem restrição de usuário para realizar requisições.
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // Regras para a validação de dados recebidos pelo usuário
        return [
            'title' => 'required|max:255',
            'description' => 'required',
            'done' => 'boolean|required',
            'due_date' => 'nullable'
        ];
    }
}
