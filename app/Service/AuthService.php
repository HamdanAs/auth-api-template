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

    public function createUser(array $data)
    {
        $validator = $this->validateUser($data);

        if ($validator->fails()) {
            return sendResult(true, $validator->errors());
        }

        return sendResult(false, $data);
    }

    public function createPerson(array $data)
    {
        $validator = $this->validatePerson($data);

        if ($validator->fails()) {
            return sendResult(true, $validator->errors());
        }

        return sendResult(false, $data);
    }

    public function createAddress(array $data)
    {
        $validator = $this->validateAddress($data);

        if ($validator->fails()) {
            return sendResult(true, $validator->errors());
        }

        return sendResult(false, $data);
    }

    public function storeUser(array $data)
    {
        $userValidator = $this->validateUser($data);
        $personValidator = $this->validatePerson($data);
        $addressValidator = $this->validateAddress($data);

        if($userValidator->fails() || $personValidator->fails() || $addressValidator->fails()){
            return sendResult(true, [
                "UserError"     => $userValidator->errors(),
                "PersonError"   => $personValidator->errors(),
                "AddressError"  => $addressValidator->errors()
            ]);
        }

        $user = User::create([
            'username'  => $data['username'],
            'email'     => $data['email'],
            'role_id'   => $data['roleId'],
            'password'  => Hash::make($data['password'])
        ]);

        $person = $user->person()->create([
            'full_name'   => $data['fullName'],
            'nik'         => $data['nik'],
            'birthdate'   => $data['birthdate'],
            'gender'      => $data['gender'],
        ]);

        $personAddress = new Address([
            'phone'         => $data['phone'],
            'province'      => $data['province'],
            'district'      => $data['district'],
            'city'          => $data['city'],
            'village'       => $data['village'],
            'post_code'     => $data['postCode'],
            'full_address'  => $data['fullAddress']
        ]);

        $address = $person->address()->save($personAddress);

        $storage = $person->storage()->create();

        $storageAddress = new Address([
            'phone'         => $data['phone'],
            'province'      => $data['province'],
            'district'      => $data['district'],
            'city'          => $data['city'],
            'village'       => $data['village'],
            'post_code'     => $data['postCode'],
            'full_address'  => $data['fullAddress']
        ]);

        $storage = $storage->address()->save($storageAddress);

        $result = [
            "user"      => $user,
            "address"   => $address,
            "person"    => $person,
            "storage"   => $storage
        ];

        return sendResult(false, $result);
    }

    public function check(array $data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return sendResult(true, $validator->errors());
        }

        if(!Auth::attempt($data)){
            return sendResult(true, "Login gagal! silahkan cek email dan password anda");
        }

        $user = User::query()->where('email', $data['email'])->firstOrFail();

        $token = $user->createToken('auth_token')->plainTextToken;

        return sendResult(false, $token);
    }

    private function validateUser(array $data)
    {
        return Validator::make($data, [
            'cooperative_id'    => 'nullable',
            'username'          => 'required|string|min:6|max:15|unique:users,username',
            'email'             => 'email|required|unique:users,email',
            'roleId'            => 'required|numeric',
            'password'          => 'required|confirmed'
        ]);
    }

    private function validatePerson(array $data)
    {
        return Validator::make($data, [
            'fullName'  => 'required|string',
            'nik'       => 'required|string|min:16|unique:people,nik',
            'birthdate' => 'required|date|date_format:Y-m-d',
            'gender'    => ['required', Rule::in(['L', 'P'])]
        ]);
    }

    private function validateAddress(array $data)
    {
        return Validator::make($data, [
            'phone'         => 'numeric|required|unique:addresses,phone',
            'province'      => 'required',
            'district'      => 'required',
            'city'          => 'required',
            'village'       => 'required',
            'postCode'      => 'required',
            'fullAddress'   => 'required'
        ]);
    }
}
