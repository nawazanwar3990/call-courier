<?php

use App\Enums\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable(TableEnum::ROLE_USER)) {
            Schema::create(TableEnum::ROLE_USER, function (Blueprint $table) {
                $table->id();
                $table->foreignId('role_id')->nullable()->constrained(TableEnum::ROLES);
                $table->foreignId('user_id')->nullable()->constrained(TableEnum::USERS);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists(TableEnum::ROLE_USER);
    }
};
