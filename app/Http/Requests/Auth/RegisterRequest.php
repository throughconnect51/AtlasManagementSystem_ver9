<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    /**
     * バリデーションの準備段階でのデータ処理
     */
    protected function prepareForValidation()
    {
        $year = $this->old_year !== 'none' ? $this->old_year : null;
        $month = $this->old_month !== 'none' ? $this->old_month : null;
        $day = $this->old_day !== 'none' ? $this->old_day : null;

        $this->merge([
            'birth_date' => ($year && $month && $day) ? "{$year}-{$month}-{$day}" : null,
        ]);
    }

    /**
     * バリデーションルール
     */
    public function rules()
    {
        $today = Carbon::today()->format('Y-m-d');

        return [
            'over_name'       => 'required|string|max:10',
            'under_name'      => 'required|string|max:10',
            'over_name_kana'  => 'required|string|regex:/^[ア-ンヴー]+$/u|max:30',
            'under_name_kana' => 'required|string|regex:/^[ア-ンヴー]+$/u|max:30',
            'mail_address'    => 'required|email|unique:users,mail_address|max:100',
            'sex'             => 'required|in:1,2,3', // 1:男性, 2:女性, 3:その他
            'old_year'        => 'required|not_in:none',
            'old_month'       => 'required|not_in:none',
            'old_day'         => 'required|not_in:none',
            'birth_date'      => "nullable|date|after_or_equal:2000-01-01|before_or_equal:{$today}",
            'role'            => 'required|in:1,2,3,4', // 1~3:教師, 4:生徒
            'password'        => 'required|string|min:8|max:30|confirmed', // confirmedによりpassword_confirmationと一致するかチェック
        ];
    }

    /**
     * エラーメッセージ
     */
    public function messages()
    {
        return [
            // 姓・名・カナ
            'over_name.required' => '姓を入力してください。',
            'over_name.max' => '姓は10文字以内で入力してください。',
            'under_name.required' => '名を入力してください。',
            'under_name.max' => '名は10文字以内で入力してください。',
            'over_name_kana.required' => 'セイを入力してください。',
            'over_name_kana.regex' => '姓カナはカタカナで入力してください。',
            'over_name_kana.max' => 'セイは30文字以内で入力してください。',
            'under_name_kana.required' => 'メイを入力してください。',
            'under_name_kana.regex' => '名カナはカタカナで入力してください。',
            'under_name_kana.max' => 'メイは30文字以内で入力してください。',

            // メールアドレス
            'mail_address.required' => 'メールアドレスを入力してください。',
            'mail_address.email' => '正しいメールアドレスの形式で入力してください。',
            'mail_address.unique' => 'このメールアドレスは既に登録されています。',
            'mail_address.max' => 'メールアドレスは100文字以内で入力してください。',

            // 性別・役職
            'sex.required' => '性別を選択してください。',
            'sex.in' => '正しい性別を選択してください。',
            'role.required' => '役職を選択してください。',
            'role.in' => '正しい役職を選択してください。',

            // 生年月日
            'old_year.not_in' => '年を選択してください。',
            'old_month.not_in' => '月を選択してください。',
            'old_day.not_in' => '日を選択してください。',
            'birth_date.date' => '正しい日付を入力してください。',
            'birth_date.after_or_equal' => '生年月日は2000年1月1日以降の日付を選択してください。',
            'birth_date.before_or_equal' => '生年月日は今日までの日付を選択してください。',

            // パスワード
            'password.required' => 'パスワードを入力してください。',
            'password.min' => 'パスワードは8文字以上で入力してください。',
            'password.max' => 'パスワードは30文字以内で入力してください。',
            'password.confirmed' => 'パスワードが確認用パスワードと一致しません。',
        ];
    }
}