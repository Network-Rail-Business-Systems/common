<?php

namespace NetworkRailBusinessSystems\Common\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use NetworkRailBusinessSystems\Common\Finders\UserFinder;
use NetworkRailBusinessSystems\Common\Interfaces\RoleInterface;
use NetworkRailBusinessSystems\Common\Models\User;

/**
 * @method ?User first()
 * @method User firstOrFail()
 * @method Collection<int, User> get()
 */
class UsersBuilder extends Builder
{
    public function byEmail(string $email): self
    {
        return $this->where('email', 'LIKE', "$email%");
    }

    public function byName(string $name): self
    {
        return $this->where(function (UsersBuilder $query) use ($name) {
            $term = "$name%";

            $query
                ->where('name', 'LIKE', $term)
                ->orWhere('first_name', 'LIKE', $term)
                ->orWhere('last_name', 'LIKE', $term);
        });
    }

    public function hasRoles(): self
    {
        return $this->whereHas('roles');
    }

    public function byRole(RoleInterface|string $role): self
    {
        return $this->whereHas('roles', function (Builder $query) use ($role) {
            $query->where('name', '=', $role);
        });
    }

    public function index(string $term, string $filter): self
    {
        return $this
            ->byFilter($filter)
            ->search($term);
    }

    public function byFilter(string $filter): self
    {
        return match ($filter) {
            UserFinder::FILTER_ALL => $this,
            default => $this->hasRoles(),
        };
    }

    public function search(string $term): self
    {
        if (empty($term) === true) {
            return $this;
        }

        return $this->where(function (UsersBuilder $query) use ($term) {
            $fuzzyTerm = "$term%";

            $query
                ->where('id', '=', $term)
                ->orWhere('email', 'LIKE', $fuzzyTerm)
                ->orWhere('name', 'LIKE', $fuzzyTerm)
                ->orWhere('first_name', 'LIKE', $fuzzyTerm)
                ->orWhere('last_name', 'LIKE', $fuzzyTerm)
                ->orWhereHas('roles', function (Builder $query) use ($fuzzyTerm) {
                    $query->where('name', 'LIKE', $fuzzyTerm);
                });
        });
    }
}
