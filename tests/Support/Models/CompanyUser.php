<?php

namespace OwowAgency\LaravelHasUsersWithRoles\Tests\Support\Models;

use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Relations\Pivot;
use OwowAgency\LaravelHasUsersWithRoles\Tests\Support\Models\User;
use OwowAgency\LaravelHasUsersWithRoles\Tests\Support\Models\Company;

class CompanyUser extends Pivot
{
    use HasRoles;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'company_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'user_id',
    ];

    /**
     * The name of the guard that is being used.
     *
     * @var string
     */
    protected $guard_name = 'web';

    /**
     * The user relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The company relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
