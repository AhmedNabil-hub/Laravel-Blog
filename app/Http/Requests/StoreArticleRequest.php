<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'title' => 'required|max:100|string',
            'body' => 'required|string',
            'image' => 'required',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'required'
        ];
    }
}
