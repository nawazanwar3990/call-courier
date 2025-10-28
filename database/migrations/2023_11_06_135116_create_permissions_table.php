<?php
use App\Enums\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable(TableEnum::PERMISSIONS)) {
            Schema::create(TableEnum::PERMISSIONS, function (Blueprint $table) {
                $table->id();
                $table->string('name')->unique()->nullable();
                $table->string('label')->nullable();
                $table->auditFields(softDelete: false);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists(TableEnum::PERMISSIONS);
    }
};
