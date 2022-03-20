<?php

namespace App\Http\Controllers\Api;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends BaseController
{
    public function getProfile()
    {
        $user = User::query()->with(['role', 'person'])->findOrFail(auth()->user()->id);

        if(!$user){
            return $this->sendError("Data tidak ditemukan!");
        }

        return $this->sendResponse($user);
    }
}
