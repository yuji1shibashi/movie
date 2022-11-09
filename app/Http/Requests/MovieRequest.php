<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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
            'name' => ['required', 'max:100'],
            'category_id' => ['required', 'numeric'],
            'image' => ['file', 'image', 'mimes:jpg,png'],
            'comment' => ['max:1000'],
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
            'name.required' => '映画名の入力は必須です',
            'name.max' => '映画名は100文字以内で入力してください',
            'category_id.required' => 'カテゴリの入力は必須です',
            'category_id.numeric' => 'カテゴリは数値で入力してください',
            'image.file' => '画像ファイルが不正です',
            'image.image' => '画像ファイル以外の形式がアップロードされています',
            'image.mimes' => '画像ファイルはjpg、png形式でアップロードしてください',
            'comment.max' => '備考は1000文字以内で入力してください'
        ];
    }
}
