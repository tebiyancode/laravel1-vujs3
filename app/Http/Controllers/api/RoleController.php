<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    public function getRoles()
    {
        if(!get_permission('roles','read')){
            return response()->json([
                'status' => 401,
                'message' => 'You are not allowed to read roles',
            ]);
        }

        $roles = Role::get();
        return response()->json([
            'message' => 'success get roles',
            'roles' => $roles
        ]);
    }


    public function store(Request $request)
    {
        if ($request->id) {
            if(!get_permission('roles','update')){
                return response()->json([
                    'status' => 401,
                    'message' => 'You are not allowed to update roles',
                ]);
            }
            $request->validate([
                'name_role' => [
                    'required',
                    Rule::unique('roles')->ignore($request->id, 'id'),
                ]
            ]);

            Role::find($request->id)->update([
                'name_role' => $request->name_role,

            ]);

            return response()->json([
                'message' => 'Role updated successfully'
            ]);
        }

        $request->validate([
            'name_role' => ['required',]
        ]);
        if(!get_permission('roles','create')){
            return response()->json([
                'status' => 401,
                'message' => 'You are not allowed to create roles',
            ]);
        }
        Role::create([
            'name_role' => $request->name_role,

        ]);
        return response()->json([

            'message' => 'Role created successfully'
        ]);
    }
}
