<?php

use App\Enums\PasswordResetStatusEnum;
use App\Enums\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable(TableEnum::PASSWORD_RESETS)) {
            Schema::create(TableEnum::PASSWORD_RESETS, function (Blueprint $table) {
                $table->id();
                $table->enum('status', PasswordResetStatusEnum::getValues())->default(PasswordResetStatusEnum::REQUESTED);
                $table->auditFields();
            });
        }
    }
    public function down(): void
    {
        Schema::dropIfExists(TableEnum::PASSWORD_RESETS);
    }
};
