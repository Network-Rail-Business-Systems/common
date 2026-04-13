<?php

namespace NetworkRailBusinessSystems\Common\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Lab404\Impersonate\Models\Impersonate;
use NetworkRailBusinessSystems\ActivityLog\Interfaces\Actioned;
use NetworkRailBusinessSystems\ActivityLog\Interfaces\Actioner;
use NetworkRailBusinessSystems\ActivityLog\Traits\HasActions;
use NetworkRailBusinessSystems\ActivityLog\Traits\HasActivities;
use NetworkRailBusinessSystems\Common\Builders\UsersBuilder;
use NetworkRailBusinessSystems\Common\Factories\UserFactory;
use NetworkRailBusinessSystems\Common\Traits\ImprovedHasAttribute;
use NetworkRailBusinessSystems\Entra\EntraAuthenticatable;
use NetworkRailBusinessSystems\Entra\Traits\AuthenticatesWithEntra;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property bool $active
 * @property string $azure_id
 * @property Carbon $created_at
 * @property ?Carbon $deleted_at
 * @property string $email
 * @property string $first_name
 * @property int $id
 * @property string $last_name
 * @property string $name
 * @property string $remember_token
 * @property Collection<Role> $roles
 * @property string $short_email
 * @property Carbon $updated_at
 */
class User extends Authenticatable implements EntraAuthenticatable, Actioner, Actioned
{
    use AuthenticatesWithEntra;
    use CausesActivity;
    use HasActions;
    use HasActivities;
    use HasFactory;
    use HasRoles;
    use Impersonate;
    use ImprovedHasAttribute;
    use LogsActivity;
    use SoftDeletes;

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
    ];

    protected $guarded = [
        'azure_id',
        'created_at',
        'deleted_at',
        'id',
        'name',
        'remember_token',
        'updated_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'deleted_at' => 'datetime',
        'id' => 'int',
        'updated_at' => 'datetime',
    ];

    protected $hidden = [
        'remember_token',
    ];

    protected $with = [
        'roles',
    ];

    protected string $guard_name = 'web';

    protected $perPage = 10;

    // Setup
    protected static function booted(): void
    {
        parent::booted();

        static::addGlobalScope('orderByName', function (Builder $query) {
            $query->orderBy('name');
        });
    }

    public function newEloquentBuilder($query): UsersBuilder
    {
        return new UsersBuilder($query);
    }

    public static function query(): UsersBuilder
    {
        /** @var UsersBuilder $query */
        $query = parent::query();
        return $query;
    }

    protected static function newFactory(): UserFactory
    {
        return new UserFactory();
    }

    // Getters
    public function getActiveAttribute(): bool
    {
        return $this->trashed() === false;
    }

    public function getShortEmailAttribute(): string
    {
        return explode('@', $this->email, 2)[0];
    }

    // ActivityLog
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->dontSubmitEmptyLogs()
            ->logOnlyDirty()
            ->logFillable();
    }

    public function backRoute(): string
    {
        return route('admin.users.show', $this);
    }

    public function label(): string
    {
        return $this->name;
    }

    public function permission(): string
    {
        return config('common.permissions.manage_users')->value;
    }

    // Impersonation
    public function canImpersonate(): bool
    {
        return Gate::check('impersonate', $this) === true;
    }

    public function canBeImpersonated(): bool
    {
        return Gate::check('beImpersonated', $this) === true;
    }
}
