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
                'email' => 'admon@callcourier.com',
                'mobile' => '03' . rand(0, 4) . rand(10000000, 99999999),
                'password' => Hash::make('admin123'),
                'active' => true,
                'created_at' => Carbon::now()
            ],
            [
                'username' => 'testuser',
                'email' => 'user@callcourier.com',
                'mobile' => '03' . rand(0, 4) . rand(10000000, 99999999),
                'password' => Hash::make('user123'),
                'active' => true,
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
