<?php

namespace Prodixx\DropzoneFieldForBackpack\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DropzoneRequest extends FormRequest
{
    public function authorize()
    {
        return backpack_auth()->check();
    }

    public function rules()
    {
        return [
            'file' => 'required|image',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'No file specified.',
            'file.image'    => 'Not a valid image.',
        ];
    }
}
