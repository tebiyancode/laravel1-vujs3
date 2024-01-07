<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function indexUsers(Request $request)
    {
        if(!get_permission('users','read')){
            return response()->json([
                'status' => 401,
                'message' => 'You are not allowed to read users',
            ]);
        }

        if($request->search){
            $users = User::where('id', '=',$request->search)->orWhere('name', 'like', "%{$request->search}%")
            ->with('role')->paginate(10);
        }else{
            $users = User::with('role')->paginate(10);
        }

        return response()->json([
            'message' => 'success get users',
            'users' => $users
        ]);
    }
    public function store(Request $request)
    {
       if($request->id){
        if(!get_permission('users','update')){
            return response()->json([
                'status' => 401,
                'message' => 'You are not allowed to update users',
            ]);
        }
        User::find($request->id)->update([
            'name' => $request->name,
            'father_name' => $request->father_name,
            'name' => $request->name,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'role_id' => $request->role_id,
        ]);
        return response()->json([
            'message' => 'success update user',

        ]);
       }
       if(!get_permission('users','create')){
        return response()->json([
            'status' => 401,
            'message' => 'You are not allowed to create users',
        ]);
    }
        User::create([
         'name' => $request->name,
         'father_name' => $request->father_name,
         'name' => $request->name,
         'gender' => $request->gender,
         'date_of_birth' => $request->date_of_birth,
         'mobile' => $request->mobile,
         'email' => $request->email,
         'role_id' => $request->role_id,
          'password' => bcrypt($request->password),

        ]);

        return response()->json([
            'message' => 'success create user',

        ]);
    }
}
