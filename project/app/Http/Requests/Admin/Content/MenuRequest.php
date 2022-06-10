<?php

namespace App\Http\Requests\Admin\Content;

use Illuminate\Foundation\Http\FormRequest;

class MenuRequest extends FormRequest
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
        // dd("hi");
        return [
            'name'=>'required|max:100|min:3|regex:/^[ا-یa-zA-Z0-9\-۰-۹ء-ي.,><?؟\/;\n\r& ]+$/u',
            'url'=>'required|max:500|min:5|regex:/^[a-zA-Z0-9][a-zA-Z0-9-]{1,61}[a-z-A-Z-0-9]\.[a-zA-Z]{2,}$/u',
            'status'=>'required|numeric|in:0,1',
            'parent_id'=>'nullable|min:1|max:100000000|regex:/^[0-9]+$/u|exists:menus,id',
        ];
    }
}
