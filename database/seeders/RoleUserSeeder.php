<?php

namespace Database\Seeders;

use App\Enums\TableEnum;
use App\Models\RoleUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\progress;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table(TableEnum::ROLE_USER)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $records = [
            [
                'role_id' => 1, //Super Admin
                'user_id' => 1, //Super Admin
            ],
            [
                'role_id' => 2, //User
                'user_id' => 2, //User
            ],
        ];

        progress(
            label: 'Seeding user roles...',
            steps: $records,
            callback: function ($record) {
                RoleUser::create($record);
            }
        );
    }
}
