<?php

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Enums\TableEnum;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use function Laravel\Prompts\progress;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table(TableEnum::ROLES)->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $records = collect(RoleEnum::getTranslationKeys())
            ->map(function ($record, $key) {
                return [
                    'name' => $record,
                    'label' => $key,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
            })->toArray();

        progress(
            label: 'Seeding roles...',
            steps: $records,
            callback: function ($record) {
                Role::create($record);
            }
        );
    }
}
