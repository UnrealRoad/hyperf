<?php

declare(strict_types=1);

namespace App\Request;

use Hyperf\Validation\Request\FormRequest;

class BlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            //
            'title' => 'required',
            'desc' => 'required',
            'content' => 'required'
        ];
    }

    public function attributes() : array
    {
        return [
            'title' => '标题',
            'desc' => '描述',
            'content' => '内容'
        ];
    }
}
