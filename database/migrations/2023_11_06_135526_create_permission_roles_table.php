<?php

use App\Enums\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable(TableEnum::PERMISSION_ROLE)) {
            Schema::create(TableEnum::PERMISSION_ROLE, function (Blueprint $table) {
                $table->id();
                $table->foreignId('role_id')->nullable()->constrained(TableEnum::ROLES);
                $table->foreignId('permission_id')->nullable()->constrained(TableEnum::PERMISSIONS);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists(TableEnum::PERMISSION_ROLE);
    }
};
