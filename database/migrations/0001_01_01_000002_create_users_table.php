<?php

use App\Enums\TableEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        if (!Schema::hasTable(TableEnum::USERS)) {
            Schema::create(TableEnum::USERS, function (Blueprint $table) {
                $table->id();
                $table->string('username')->unique()->nullable();
                $table->string('email')->unique()->nullable();
                $table->string('mobile')->unique()->nullable();
                $table->string('password');
                $table->boolean('active')->default(true);
                $table->integer('total_coins')->nullable()->default(0);
                $table->boolean('privacy_policy')->nullable()->default(0);
                $table->rememberToken();
                $table->auditFields();
            });
        }
        if (!Schema::hasTable(TableEnum::PASSWORD_RESET_TOKENS)) {
            Schema::create(TableEnum::PASSWORD_RESET_TOKENS, function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });
        }
        if (!Schema::hasTable(TableEnum::SESSIONS)) {
            Schema::create(TableEnum::SESSIONS, function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(TableEnum::USERS);
        Schema::dropIfExists(TableEnum::PASSWORD_RESET_TOKENS);
        Schema::dropIfExists(TableEnum::SESSIONS);
    }
};
