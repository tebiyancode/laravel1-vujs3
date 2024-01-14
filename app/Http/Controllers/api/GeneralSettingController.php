<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GeneralSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if(!get_permission('GeneralSettings','read')){
            return response()->json([
                'status' => 401,
                'message' => 'You are not allowed to read GeneralSettings',
            ]);
        }

        $GeneralSettings = GeneralSetting::get();
        return response()->json([
            'message' => 'success get GeneralSettings',
            'GeneralSettings' => $GeneralSettings
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
           $file = request()->file('file_image');

        if ($request->id) {
            if(!get_permission('GeneralSettings','update')){
                return response()->json([
                    'status' => 401,
                    'message' => 'You are not allowed to update GeneralSettings',
                ]);
            }
            $request->validate([
                'name' => [
                    'required',
                    Rule::unique('general_settings')->ignore($request->id, 'id'),
                ]
            ]);
            if($file){
                $file_name = $request->name. '.' . $file->getClientOriginalExtension();
                $file->move(public_path('app-assets/images'), $file_name);
                $logo = 'app-assets/images/' . $file_name;
            }else{
               $logo=$request->logo;
            }
            GeneralSetting::find($request->id)->update([
                'name' => $request->name,
                'font_id' => $request->font_id,
                'font_size' => $request->font_size,
                'email' => $request->email,
                'facebook' => $request->facebook,
                'youtube' => $request->youtube,
                  'logo'=> $logo,
            ]);

            return response()->json([
                'message' => 'GeneralSetting updated successfully'
            ]);
        }

        $request->validate([
            'name' => ['required',]
        ]);
        if(!get_permission('GeneralSettings','create')){
            return response()->json([
                'status' => 401,
                'message' => 'You are not allowed to create GeneralSettings',
            ]);
        }
        $file_name = $request->name. '.' . $file->getClientOriginalExtension();
        $file->move(public_path('app-assets/images'), $file_name);
        $logo = 'app-assets/images/' . $file_name;


        GeneralSetting::create([
            'name' => $request->name,
            'font_id' => $request->font_id,
            'font_size' => $request->font_size,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'youtube' => $request->youtube,
              'logo'=> $logo,
        ]);
        return response()->json([

            'message' => 'GeneralSetting created successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
