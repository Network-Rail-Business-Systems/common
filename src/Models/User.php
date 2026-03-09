<?php

namespace NetworkRailBusinessSystems\Common\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;
use Lab404\Impersonate\Models\Impersonate;
use NetworkRailBusinessSystems\Common\Builders\UsersBuilder;
use NetworkRailBusinessSystems\Common\Tests\Enums\Permission;
use NetworkRailBusinessSystems\Entra\EntraAuthenticatable;
use NetworkRailBusinessSystems\Entra\Traits\AuthenticatesWithEntra;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
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
 * @property Carbon $updated_at
 */
class User extends Authenticatable implements EntraAuthenticatable
{
    use HasFactory;
    use HasRoles;
    use SoftDeletes;
    use Impersonate;
    use AuthenticatesWithEntra;

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

    // Utilities
    public function canImpersonate(): bool
    {
        return $this->hasPermissionTo(Permission::Impersonate) === true;
    }

    public function canBeImpersonated(): bool
    {
        return $this->hasPermissionTo(Permission::Impersonate) === false;
    }
}
