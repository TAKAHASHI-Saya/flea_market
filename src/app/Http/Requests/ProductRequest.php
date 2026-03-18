<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'product_name' => 'required|max:20',
            'product_image' => 'required|image|mimes:png, jpeg',
            'product_detail' => 'required|max:120',
            'sales_price' => 'required|integer',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'condition_type' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => '商品名を入力してください',
            'product_name.max' => '商品名は20文字以内で入力してください',
            'product_image.required' => '商品画像を登録してください',
            'product_image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'product_detail.required' => '商品説明を入力してください',
            'product_detail.max' => '商品説明は120文字以内で入力してください',
            'sales_price.required' => '販売金額を入力してください',
            'sales_price.integer' => '販売金額は数値で入力してください',
            'categories.required' => 'カテゴリーを選択してください',
            'condition_type.required' => '商品の状態を選択してください',
        ];
    }
}
