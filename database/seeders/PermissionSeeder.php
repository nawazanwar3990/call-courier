<?php

namespace Database\Seeders;

use App\Enums\PermissionEnum;
use App\Enums\TableEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table(TableEnum::PERMISSIONS)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        PermissionEnum::syncPermission();
    }
}
