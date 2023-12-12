<?php

namespace App\Http\Requests;

use App\Utils\Functions;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use ReflectionException;

class UploadImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
            'model' => [
                'required',
                'string',
                Rule::in(Functions::getAllModelNames())
            ]
        ];
    }
}
