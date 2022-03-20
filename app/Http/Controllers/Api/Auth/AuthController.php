<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Service\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    private AuthService $service;

    public function __construct()
    {
        $this->service = new AuthService;
    }

    public function registerUser(Request $request)
    {
        $user = $request->only(
            'cooperative_id',
            'phone',
            'username',
            'email',
            'roleId',
            'password',
            'password_confirmation'
        );

        $data = $this->service->createUser($user);

        if ($data->error) {
            return $this->sendError($data, 422);
        }

        return $this->sendResponse($data);
    }

    public function registerPerson(Request $request)
    {
        $person = $request->only(
            'fullName',
            'nik',
            'phone',
            'gender',
            'userId',
            'addressId'
        );

        $data = $this->service->createPerson($person);

        if ($data->error) {
            return $this->sendError($data, 406);
        }

        return $this->sendResponse($data);
    }

    public function registerAddress(Request $request)
    {
        $address = $request->only(
            'province',
            'district',
            'city',
            'village',
            'postCode',
            'fullAddress'
        );

        $data = $this->service->createAddress($address);

        if ($data->error) {
            return $this->sendError($data, 406);
        }

        return $this->sendResponse($data);
    }

    public function save(Request $request)
    {
        $userData = $request->only('cooperative_id', 'username', 'email', 'roleId', 'password', 'password_confirmation');
        $addressData = $request->only('province', 'district', 'city', 'village', 'postCode', 'fullAddress');
        $personData = $request->only('fullName', 'nik', 'phone', 'gender', 'birthdate');

        $data = array_merge($userData, $addressData, $personData);

        $user = $this->service->storeUser($data);

        if ($user->error) {
            return $this->sendError($user, 422);
        }

        return $this->sendResponse($user);
    }

    public function auth(Request $request)
    {
        $token = $this->service->check($request->only('email', 'password'));

        if ($token->error) {
            return $this->sendError($token->result, 404, "Login gagal");
        }

        return $this->sendResponse($token->result, 200, "Login berhasil!");
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return $this->sendResponse("Berhasil Logout");
    }
}
