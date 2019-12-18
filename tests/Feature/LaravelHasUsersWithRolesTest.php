<?php

namespace OwowAgency\LaravelHasUsersWithRoles\Tests\Feature;

use Spatie\Permission\Models\Role;
use Illuminate\Foundation\Testing\TestResponse;
use OwowAgency\LaravelHasUsersWithRoles\Tests\TestCase;
use OwowAgency\LaravelHasUsersWithRoles\Tests\Support\Models\User;
use OwowAgency\LaravelHasUsersWithRoles\Tests\Support\Models\Company;
use OwowAgency\LaravelHasUsersWithRoles\Tests\Support\Models\CompanyUser;

class LaravelHasUsersWithRolesTest extends TestCase
{
    /** @test */
    public function company_can_attach_a_user_with_a_role()
    {
        [$company, $user, $role] = $this->prepare();
        
        $company->attachUser($user, $role);

        // Assert relation has been made between company and user.
        $companyUserWhere = [
            'company_id' => $company->id,
            'user_id' => $user->id,
        ];

        $this->assertDatabaseHas('company_user', $companyUserWhere);

        // Assert that the company user has the correct role assigned.
        $companyUser = CompanyUser::where($companyUserWhere)->first();

        $this->assertDatabaseHas('model_has_roles', [
            'model_type' => $companyUser->getMorphClass(),
            'model_id' => $companyUser->id,
            'role_id' => $role->id,
        ]);
    }

    /**
     * Prepares for tests.
     * 
     * @return array
     */
    protected function prepare(): array
    {
        $company = Company::create([]);

        $user = User::create([]);

        $role = Role::create(['name' => 'admin']);

        return [$company, $user, $role];
    }
}
