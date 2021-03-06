<?php

namespace App\Http\Requests\posts;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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
        return [
            
            //when u say unique specify the table
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'published_at' => 'required|date',
            'image' => 'image',
            'category' => 'required'
        ];
    }
}
