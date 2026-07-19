<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
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
        // 投稿機能・編集機能で共通のバリデーションルール
        $rules = [
            'post_title' => 'required|string|max:100',
            'post_body' => 'required|string|max:2000',
        ];

        // 新規投稿時（フォームから post_category_id が送られてきている場合）のみルールを追加
        if ($this->has('post_category_id')) {
            $rules['post_category_id'] = 'required|exists:sub_categories,id';
        }

        return $rules;
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array
     */
    public function messages(){
        return [
            'post_title.required' => 'タイトルは必ず入力してください。',
            'post_title.string' => 'タイトルは文字列である必要があります。',
            'post_title.max' => 'タイトルは100文字以内で入力してください。',
            'post_body.required' => '内容は必ず入力してください。',
            'post_body.string' => '内容は文字列である必要があります。',
            'post_body.max' => '最大文字数は2000文字です。',
            
            // サブカテゴリー用のエラーメッセージを追加
            'post_category_id.required' => 'カテゴリーは必ず選択してください。',
            'post_category_id.exists' => '登録されているサブカテゴリーを選択してください。',
        ];
    }
}