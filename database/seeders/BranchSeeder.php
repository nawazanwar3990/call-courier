<?php

namespace Database\Seeders;

use App\Enums\TableEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        DB::table(TableEnum::BRANCHES)->insert([
            'name' => 'Test Branch',
            'active' => true,
            'created_at' => now(),
            'updated_at' => now(),
            'created_by' => 1,
            'updated_by' => 1
        ]);
    }
}
