<?php

namespace Database\Seeders;
use App\Enums\TableEnum;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use function Laravel\Prompts\progress;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table(TableEnum::USERS)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $records = [
            [
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'active' => true,
                'created_at' => Carbon::now()
            ],
            [
                'username' => 'test_user',
                'password' => Hash::make('test123'),
                'normal_password'=>'test123',
                'active' => true,
                'branch_id'=>1,
                'created_at' => Carbon::now()
            ],
        ];

        progress(
            label: 'Seeding users...',
            steps: $records,
            callback: function ($record) {
                $user = User::create($record);
                $user->copyMedia(public_path('assets/img/user-picture.jpg'))
                    ->usingName('picture')
                    ->toMediaCollection('picture');
            }
        );
    }
}
