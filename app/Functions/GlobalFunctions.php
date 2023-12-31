<?php

use App\Models\Page;

    function get_permission($pages, $permission)
    {
        $page_id =Page::where('page',$pages)->value('id');
      return auth()->user()->role->permissions()
        ->where('page_id', $page_id)
        ->where($permission,1)
        ->exists();
    }

