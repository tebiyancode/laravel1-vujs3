<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
     public function getPages(){
        $page_id =Page::where('page','pages')->value('id');
        if(!auth()->user()->role->permissions()
        ->where('page_id', $page_id)
        ->where('read',1)
        ->exists()){
            return response()->json([
                'status' => 401,
                'message' => 'You are not allowed to read permissions',
            ]);
        }
        $pages = Page::with(['pages','page_name','permissions'])
        ->orderBy('order', 'asc')
        ->get();
        return response()->json([
            'pages' => $pages,
            'message' => 'Pages  get successfully'
        ]);
     }

     public function store(Request $request){
        $page_id =Page::where('page','pages')->value('id');

if($request->id){
    if(!auth()->user()->role->permissions()
->where('page_id', $page_id)
->where('update',1)
->exists()){
    return response()->json([
        'status' => 401,
        'message' => 'You are not allowed to update permissions',
    ]);
}
    $request->validate([
        'page'=>['required',
        Rule::unique('pages')->ignore($request->id,'id'),
        ]
    ]);

    Page::find($request->id)->update([
        'page' => $request->page,
        'icon' => $request->icon,
        'path' => $request->path,
        'order' => $request->order,
        'page_id' => $request->page_id,
    ]);

    return response()->json([
        'message' => 'Page updated successfully'
    ]);
}

$request->validate([
    'page'=>['required',]
]);
if(!auth()->user()->role->permissions()
->where('page_id', $page_id)
->where('create',1)
->exists()){
    return response()->json([
        'status' => 401,
        'message' => 'You are not allowed to update permissions',
    ]);
}
        $page = Page::create([
            'page' => $request->page,
            'icon' => $request->icon,
            'path' => $request->path,
            'order' => $request->order,
            'page_id' => $request->page_id,
        ]);
        return response()->json([
            'page' => $page,
            'message' => 'Page created successfully'
        ]);
     }
}
