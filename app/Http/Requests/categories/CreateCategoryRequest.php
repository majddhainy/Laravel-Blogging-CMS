<?php

namespace App\Http\Requests\categories;

use Illuminate\Foundation\Http\FormRequest;


// this was created using php artisan make:request CreateCategoryRequest
// why this is so helpful ? 
// 1. to make methods in controller cleaner we validate data here 
// 2. we know that we can prevent un authinticated users from accessing some views
// by injecting our code @auth HERE @endauth
// but what if we wanna prevent un authinticated users from sending a request POST/PUT/DELETE
// to  a specific endpoint ? here its good to create our own request
// or if u wanna make sure that user is commming from specific domain/country

class CreateCategoryRequest extends FormRequest
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

        // here inside rules we return the array of SERVER SIDE VALIDATION ! 
        return [
            'name' => 'required|unique:categories'
        ];
    }
}
