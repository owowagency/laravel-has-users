<?php

namespace OwowAgency\LaravelHasUsersWithRoles\Tests\Support\Models;

use Illuminate\Database\Eloquent\Model;
use OwowAgency\LaravelHasUsersWithRoles\HasUsersWithRoles;
use OwowAgency\LaravelHasUsersWithRoles\Tests\Support\Models\CompanyUser;

class Company extends Model
{
    use HasUsersWithRoles;

    /**
     * Return the users relation pivot class.
     *
     * @return string
     */
    public function getUsersPivotClass(): string
    {
        return CompanyUser::class;
    }
}
