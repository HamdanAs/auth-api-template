<?php

namespace App\Traits;

trait EnsureHasRole {

    public function hasRole($role)
    {
        if($this->role()->where('name', $role)->first()){
            return true;
        }

        return false;
    }

}
