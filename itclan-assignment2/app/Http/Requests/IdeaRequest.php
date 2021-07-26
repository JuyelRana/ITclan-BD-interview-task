<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IdeaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->getMethod() == 'POST') {
            return [
                'name' => [
                    'required',
                    'string',
                    'unique:ideas'
                ],
                'email' => [
                    'required',
                    'email',
                    'unique:ideas'
                ],
                'idea' => [
                    'required',
                    'string'
                ]
            ];
        } else {
            return [
                'name' => [
                    'sometimes',
                    'string',
                    Rule::unique('ideas', 'name')->ignore(request()->route('idea'))
                ],
                'email' => [
                    'required',
                    'email',
                    Rule::unique('ideas', 'email')->ignore(request()->route('idea'))
                ],
                'idea' => [
                    'required',
                    'string'
                ]
            ];
        }
    }
}
