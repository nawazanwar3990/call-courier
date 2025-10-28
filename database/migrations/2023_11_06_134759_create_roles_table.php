<?php

use App\Enums\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable(TableEnum::ROLES)) {
            Schema::create(TableEnum::ROLES, function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('label');
                $table->auditFields();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists(TableEnum::ROLES);
    }
};
