<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    protected function prepareForValidation()
    {
        if ($this->filled(['old_year', 'old_month', 'old_day'])) {
            $this->merge([
                'birth_day' => sprintf('%04d-%02d-%02d', $this->old_year, $this->old_month, $this->old_day)
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'over_name' => ['required', 'string', 'max:10'],
            'under_name' => ['required', 'string', 'max:10'],
            // カタカナのみの判定に正規表現（regex）を使用
            'over_name_kana' => ['required', 'string', 'max:30', 'regex:/^[ア-ンヴー]+$/u'],
            'under_name_kana' => ['required', 'string', 'max:30', 'regex:/^[ア-ンヴー]+$/u'],
            // usersテーブルのmail_addressカラムで重複チェック
            'mail_address' => ['required', 'email', 'unique:users,mail_address', 'max:100'],
            // 1:男性, 2:女性, 3:その他
            'sex' => ['required', 'in:1,2,3'],
            
            // 生年月日の単体チェック（必須かつ数字）
            'old_year' => ['required', 'numeric'],
            'old_month' => ['required', 'numeric'],
            'old_day' => ['required', 'numeric'],
            // 合成した日付のチェック（2000年1月1日〜今日まで ＆ 正しい日付か）
            'birth_day' => ['nullable', 'date', 'after_or_equal:2000-01-01', 'before_or_equal:today'],
            
            // 1:国語, 2:数学, 3:英語, 4:生徒
            'role' => ['required', 'in:1,2,3,4'],
            // confirmed をつけると自動的に password_confirmation と一致するかチェックします
            'password' => ['required', 'string', 'min:8', 'max:30', 'confirmed'],
        ];
    }
}
