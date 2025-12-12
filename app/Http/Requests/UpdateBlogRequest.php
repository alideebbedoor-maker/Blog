<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true ;
    }

   public function rules()
    {
     return [
     'title' => 'sometimes|required|string|max:255',
      'content' => 'sometimes|required|string',
      'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
    'category_ids' => 'array|exists:categories,id',
 ];
    }
}
