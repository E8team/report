<?php

namespace App\Auth;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Str;

class StudentProvider extends EloquentUserProvider
{
    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials)) {
            return;
        }
        // First we will add each credential element to the query as a where clause.
        // Then we can execute the query and, if we found a user, return it in a
        // Eloquent User "model" that will be utilized by the Guard instances.
        $query = $this->createModel()->newQuery();
        foreach ($credentials as $key => $value) {
            if (!Str::contains($key, 'password') && !Str::contains($key, 'id_card')) {
                $query->where($key, $value);
            }
        }
        $user = $query->first();
        if (is_null($user)) {
            throw new ModelNotFoundException();
        }
        return $user;
    }
}