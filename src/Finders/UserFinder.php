<?php

namespace NetworkRailBusinessSystems\Common\Finders;

use AnthonyEdmonds\LaravelFind\Finder;
use NetworkRailBusinessSystems\Common\Models\User;
use NetworkRailBusinessSystems\Common\ResourceCollections\UserCollection;

class UserFinder extends Finder
{
    public const string FILTER_ALL = 'all';

    public const string FILTER_ROLES = 'roles';

    public const string DEFAULT_FILTER = self::FILTER_ROLES;

    public function search(): UserCollection
    {
        return UserCollection::make(
            User::query()
                ->with(['roles'])
                ->index($this->currentSearch, $this->currentFilter)
                ->paginate(),
        );
    }

    public function filterLabel(string $currentFilter): string
    {
        return match ($currentFilter) {
            self::FILTER_ROLES => 'Users with Roles',
            default => 'All Users',
        };
    }

    public function statusLabel(string $currentStatus): string
    {
        return '';
    }

    public function sortLabel(string $currentSort): string
    {
        return '';
    }

    public function listFilters(): array
    {
        return [
            self::FILTER_ALL => 'All Users',
            self::FILTER_ROLES => 'Users with Roles',
        ];
    }

    public function listSearchable(): array
    {
        return [
            'E-mail',
            'ID',
            'Name',
            'Roles',
        ];
    }

    public function listSorts(): array
    {
        return [];
    }

    public function listStatuses(): array
    {
        return [];
    }

    public function route(): string
    {
        return 'admin.users.index';
    }
}
