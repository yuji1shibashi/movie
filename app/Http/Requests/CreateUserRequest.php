<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('App\Models\User')->ignore($this->id)],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'is_admin' => ['required', 'boolean']
        ];
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'ユーザー名の入力は必須です',
            'name.string' => 'ユーザー名はの形式が不正です',
            'name.max' => 'ユーザー名は255文字以内で入力してください',
            'email.required' => 'メールアドレスの入力は必須です',
            'email.string' => 'メールアドレスが不正です',
            'email.email' => 'メールアドレスの形式で入力してください',
            'email.max' => 'メールアドレスは255文字以内で入力してください',
            'email.unique' => 'メールアドレスが別のユーザーで使用されています',
            'password.required' => 'パスワードの入力は必須です',
            'password.confirmed' => 'パスワードが一致しません',
            'password.string' => 'パスワードが不正です',
            'password.min' => 'パスワードは8文字以上で入力してください',
            'is_admin.required' => '権限の入力は必須です',
            'is_admin.boolean' => '権限の値が不正です'
        ];
    }
}
