<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function usernameUpdate(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string|unique:users'
        ]);

        $user = User::first();
        if($user->update($data)){
            return User::first();;
        }
        return response(['msg' => 'sorry something went wrong']);
        
    }
}
