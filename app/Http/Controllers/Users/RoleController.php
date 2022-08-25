<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public function index()
    {
        return view('users/role_user');
    }

}
