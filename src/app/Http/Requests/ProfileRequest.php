<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'profile_image' => 'nullable|image|mimes:png,jpeg',
            'username' => 'required|max:20',
            'postcode' => 'required|string|size:8|regex:/\A\d{3}-\d{4}\z/',
            'address' => 'required|string',
            'building' => 'nullable|string',
        ];
    }
    public function messages()
    {
        return [
            'profile_image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'username.required' => 'お名前を入力してください',
            'username.max' => '20文字以内で入力してください',
            'postcode.required' => '郵便番号を入力してください',
            'postcode.size' => 'ハイフンを含む8文字以内で入力してください',
            'address.required' => '住所を入力してください',
            'address.string' => '住所は文字列で入力してください',
            'building.string' => '建物名は文字列で入力してください',
        ];
    }
}
