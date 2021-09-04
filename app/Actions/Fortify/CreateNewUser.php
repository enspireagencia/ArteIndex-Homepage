<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\PrivateRoom;
use App\Models\PrivateRoomUsers;
use App\Models\MyProfile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'user_role' => $input['user_role'],
            'user_status_id' => $input['user_role'],
            'user_unique_id' => 'test-'.time().uniqid('-', false).uniqid('-', false),
        ]);

        //My Profile
        MyProfile::create([
            'name' => $input['name'],
            'user_id' => $user->id,
        ]);
        return $user;
    }
}
