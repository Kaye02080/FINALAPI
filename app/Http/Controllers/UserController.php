<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getUsers(){
    $users = User::with('role', 'userStatus')->get();

    return response()->json(['users' => $users]);
}


    public function addUser(Request $request){
    $request->validate([
        'first_name' => ['required', 'string', 'max:255'],
        'middle_name' => ['nullable', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users'],
        'password' => ['required', 'string', 'min:8'],
        'role_id' => ['required', 'exists:roles,id'],
        'user_status_id' => ['required', 'exists:user_statuses,id'],
        'balance' => ['required', 'numeric', 'min:0'],  // Add balance validation
    ]);

    $user = User::create([
        'first_name' => $request->first_name,
        'middle_name' => $request->middle_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role_id' => $request->role_id,
        'user_status_id' => $request->user_status_id,
        'balance' => $request->balance, // Set balance when creating user
    ]);

    return response()->json(['message' => 'User successfully created!', 'user' => $user]);
}


   public function editUser(Request $request, $id){
    $request->validate([
        'first_name' => ['required', 'string', 'max:255'],
        'middle_name' => ['nullable', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $id],
        'role_id' => ['required', 'exists:roles,id'],
        'user_status_id' => ['required', 'exists:user_statuses,id'],
        'balance' => ['required', 'numeric', 'min:0'],  // Add balance validation
    ]);

    $user = User::find($id);

    if(!$user){
        return response()->json(['message' => 'User not found!'], 404);
    }

    $user->update([
        'first_name' => $request->first_name,
        'middle_name' => $request->middle_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'role_id' => $request->role_id,
        'user_status_id' => $request->user_status_id,
        'balance' => $request->balance,  // Update balance
    ]);

    return response()->json(['message' => 'User successfully edited!', 'user' => $user]);
}


    public function deleteUser($id){
        $user = User::find($id);

        if(!$user){
            return response()->json(['message' => 'User not found!'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User successfully deleted!']);
    }
}
