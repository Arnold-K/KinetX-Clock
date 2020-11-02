<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserPasswordController extends Controller {

    public function __construct() {

    }

    // admin can override any password
    public function overridePassword(Request $request, User $user) {
        if(auth()->user()->cant('change_any_password')) {
            return response()->json([
                "message" => "You are not authorized to change the password for this user!"
            ]);
        }
        $user->password = bcrypt($request->password);
        $user->save();
        return response()->json([
            "message" => "Password has been changed successfully!"
        ]);
    }

    // user chanign their password
    public function changePassword() {

    }

}
