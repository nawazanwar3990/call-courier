<?php

namespace App\Providers;
use App\Enums\RoleEnum;
use App\Enums\TableEnum;
use App\Models\GiftCard;
use App\Models\Inventory;
use App\Models\PasswordReset;
use App\Models\Redeem;
use App\Models\Type;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Submission;
use App\Models\Branch;
use App\Models\User;
use App\Policies\GiftCardPolicy;
use App\Policies\InventoryPolicy;
use App\Policies\PasswordResetPolicy;
use App\Policies\RedeemPolicy;
use App\Policies\TypePolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\SubmissionPolicy;
use App\Policies\TaskPolicy;
use App\Policies\UserPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Paginator::useBootstrapFive();

        Password::defaults(function () {
            return Password::min(6)
                ->letters()
                ->numbers()
                ->symbols()
                ->mixedCase();
        });

        //Register policies
        $this->registerPolicies();
        //Register gates
        $this->registerGates();

        //Database Blueprint Macro
        Blueprint::macro('auditFields', function (bool $softDelete = true) {
            $this->foreignId('created_by')->nullable()->constrained(TableEnum::USERS);
            $this->foreignId('updated_by')->nullable()->constrained(TableEnum::USERS);
            if ($softDelete) {
                $this->foreignId('deleted_by')->nullable()->constrained(TableEnum::USERS);
            }
            $this->timestamps();
            if ($softDelete) {
                $this->softDeletes();
            }
        });
        Model::shouldBeStrict(! $this->app->isProduction());
    }

    private function registerPolicies(): void
    {
        Gate::policy(Role::class, RolePolicy::class);
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Permission::class, PermissionPolicy::class);
        Gate::policy(Branch::class, TaskPolicy::class);
        Gate::policy(Type::class, TypePolicy::class);
        Gate::policy(GiftCard::class, GiftCardPolicy::class);
        Gate::policy(Submission::class, SubmissionPolicy::class);
        Gate::policy(Inventory::class, InventoryPolicy::class);
        Gate::policy(Redeem::class, RedeemPolicy::class);
        Gate::policy(PasswordReset::class, PasswordResetPolicy::class);
    }

    private function registerGates(): void
    {
        Gate::define('hasAccess', function ($user, $permission) {
            return RoleEnum::checkPermission($user, $permission);
        });
    }
}
