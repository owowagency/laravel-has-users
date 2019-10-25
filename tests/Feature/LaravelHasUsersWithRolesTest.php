<?php

namespace OwowAgency\LaravelHasUsersWithRoles\Tests\Feature;

use Illuminate\Foundation\Testing\TestResponse;
use OwowAgency\LaravelHasUsersWithRoles\Tests\TestCase;
use OwowAgency\LaravelHasUsersWithRoles\Tests\Support\Models\User;
use OwowAgency\LaravelHasUsersWithRoles\Tests\Support\Models\Company;
use OwowAgency\LaravelHasUsersWithRoles\Tests\Support\Models\CompanyUser;

class LaravelHasUsersWithRolesTest extends TestCase
{
    /** @test */
    public function company_can_attach_user()
    {
        [$company, $user] = $this->prepare();

        $company->attachUser($user);

        $this->assertDatabaseHas('company_user', [
            'company_id' => $company->id,
            'user_id' => $user->id,
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

        return [$company, $user];
    }
}
