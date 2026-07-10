<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; //追記
use Illuminate\Support\Facades\Hash; //追記

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'over_name' => '管理者',
                'under_name' => '太郎',
                'over_name_kana' => 'カンリシャ',
                'under_name_kana' => 'タロウ',
                'mail_address' => 'admin@example.com',
                'sex' => 1, // 男性
                'birth_day' => '1990-01-01',
                'role' => 1, // 教師(国語)
                'password' => Hash::make('password'), // ログイン時のパスワード
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
