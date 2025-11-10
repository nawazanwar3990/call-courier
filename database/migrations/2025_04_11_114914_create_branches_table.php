<?php
use App\Enums\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable(TableEnum::BRANCHES)) {
            Schema::create(TableEnum::BRANCHES, function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->boolean('active')->default(true);
                $table->auditFields();
            });
        }
    }
    public function down(): void
    {
        Schema::dropIfExists(TableEnum::BRANCHES);
    }
};
