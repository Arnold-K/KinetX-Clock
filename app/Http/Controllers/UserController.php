<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller {
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        if(!auth()->user()->hasRole('superadmin')){
            abort(403);
        }
        $data['users'] = User::whereHas('employee')->with('employee')->get();
        return view('pages.users.index')->with($data);
    }

    public function show(Request $request, User $user) {
        if(!auth()->user()->hasRole('superadmin')){
            abort(403);
        }
    }

    public function edit(Request $request, User $user) {
        if(!auth()->user()->hasRole('superadmin')){
            abort(403);
        }
        return view('pages.users.edit')->with(['user' => $user, 'roles' => Role::all()]);
    }
}
