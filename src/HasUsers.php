<?php

namespace App\Library\Database\Concerns;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasUsers
{
    /**
     * The belongs to many relationship to users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            ->using($this->getUsersPivotClass())
            ->withPivot('id');
    }

    /**
     * Attach a user to model with the given role.
     *
     * @param  \App\Models\Users\User|int  $user
     * @param  array|string|\Spatie\Permission\Contracts\Role  $roles
     * @return void
     */
    public function attachUser($user, $roles = []): void
    {
        // If just the user id is given, find the user model
        if (! $user instanceof User) {
            $user = User::findOrFail($user);
        }

        $pivotKey = $this->users()->getForeignPivotKeyName();
        $pivot = $this->getUsersPivotClass();
        
        $modelUser = $pivot::create([
            $pivotKey => $this->id,
            'user_id' => $user->id,
        ]);

        // If role is empty, user is just a basic member of the model
        // and has no special role (e.g. admin)
        if (! empty($roles)) {
            $modelUser->assignRole($roles);
        }
    }
    
    /**
     * Sync all users of the model with given users data.
     *
     * @param  array  $users
     * @return void
     */
    public function syncUsers(array $users): void
    {
        $pivotKey = $this->users()->getForeignPivotKeyName();
        $pivot = $this->getUsersPivotClass();

        // Get all old modelUsers
        $modelUsers = $pivot::where($pivotKey, $this->id)->get();

        // Remove old modelUsers' roles
        foreach ($modelUsers as $modelUser) {
            $modelUser->roles()->detach();
        }

        // Detach old users
        $this->users()->detach();

        // Attach new users
        foreach ($users as $user) {
            $this->attachUser(
                data_get($user, 'user_id'),
                data_get($user, 'role')
            );
        }
    }

    /**
     * Determine if the given user is in the current model.
     *
     * @param  \App\Models\Users\User|int|string  $user
     * @return bool
     */
    public function hasUser($user): bool
    {
        $userId = $user instanceof Model ? $user->id : $user;

        return $this->users()->where('users.id', $userId)->exists();
    }

    /**
     * Scope a query to restrict the query to return models that have the
     * specified users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  \App\Models\User  $user
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasUser(Builder $query, User $user): Builder
    {
        return $query->whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        });
    }

    /**
     * Determine if the user has permissions for a given model.
     *
     * @param  \App\Models\Users\User|int  $user
     * @param  string|int|array|\Spatie\Permission\Contracts\Role|\Illuminate\Support\Collection  $roles
     * @return bool
     */
    public function hasUserWithRole($user, $roles): bool
    {
        // If just the user id is given, find the user model
        if (! $user instanceof User) {
            $user = User::findOrFail($user);
        }

        $pivotKey = $this->users()->getForeignPivotKeyName();
        $pivot = $this->getUsersPivotClass();

        $modelUser = $pivot::with('roles')
            ->where([
                $pivotKey => $this->id,
                'user_id' => $user->id,
            ])
            ->first();

        if (is_null($modelUser)) {
            return false;
        }

        return $modelUser->hasRole($roles);
    }

    /**
     * Return the users relation pivot class.
     *
     * @return string
     */
    public function getUsersPivotClass(): string
    {
        return Pivot::class;
    }
}
