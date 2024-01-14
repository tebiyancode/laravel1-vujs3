<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AppFont;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AppFontController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getFonts()
    {
        if(!get_permission('appFonts','read')){
            return response()->json([
                'status' => 401,
                'message' => 'You are not allowed to read appFonts',
            ]);
        }

        $appFonts = AppFont::get();
        return response()->json([
            'message' => 'success get appFonts',
            'appFonts' => $appFonts
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


               $file = request()->file('file_font');
        if ($request->id) {
            if(!get_permission('appFonts','update')){
                return response()->json([
                    'status' => 401,
                    'message' => 'You are not allowed to update appFonts',
                ]);
            }
            $request->validate([
                'name_font' => [
                    'required',
                    Rule::unique('app_fonts')->ignore($request->id, 'id'),
                ]
            ]);
            if($file){
                $file_name = $request->name_font. '.' . $file->getClientOriginalExtension();
                $file->move(public_path('app-assets/fonts'), $file_name);
                $path = 'app-assets/fonts/' . $file_name;
            }else{
               $path=$request->path;
            }
            AppFont::find($request->id)->update([
                'name_font' => $request->name_font,
                'path'=> $path,
            ]);

            return response()->json([
                'message' => 'AppFont updated successfully'
            ]);
        }

        $request->validate([
            'name_font' => ['required',]
        ]);
        if(!get_permission('appFonts','create')){
            return response()->json([
                'status' => 401,
                'message' => 'You are not allowed to create appFonts',
            ]);
        }
        $file_name = $request->name_font. '.' . $file->getClientOriginalExtension();
        $file->move(public_path('app-assets/fonts'), $file_name);
        $path = 'app-assets/fonts/' . $file_name;


        AppFont::create([
            'name_font' => $request->name_font,
              'path'=> $path,
        ]);
        return response()->json([

            'message' => 'AppFont created successfully'
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
