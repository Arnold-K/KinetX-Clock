<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
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

    public function update(Request $request, User $user) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required|exists:roles,id'
        ]);
        if($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        $user->update($request->all());
        return redirect( route('user.edit', $user->id) )->with(['updated_success', "User has been updated"]);
    }

    public function destroy(Request $request, User $user) {
        if(auth()->user()->cant('destroy', $user)) {
            abort(403);
        }
        $user->delete();
        return response()->json(['redirect' => url(route('user.index'))], 200);
    }
}
