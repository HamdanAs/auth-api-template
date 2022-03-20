<?php

namespace App\Service;

use App\Models\Address;
use App\Models\Person;
use App\Models\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthService
{

    public function storeUser(array $data)
    {
        $user = User::create([
            'username'  => $data['username'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password'])
        ]);

        $person = $user->person()->create();

        return sendResult(false, ['User' => $user, 'person' => $person]);
    }

    public function check(array $data)
    {
        if(!Auth::attempt($data)){
            return sendResult(true, "Login gagal! silahkan cek email dan password anda");
        }

        $user = User::query()->where('email', $data['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return sendResult(false, $token);
    }
}
