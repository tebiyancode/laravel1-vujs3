<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            ['role_id' => 1, 'page_id' => 1, 'read' => true, 'edit' => true, 'create' => true, 'update' => true, 'delete' => true],
            ['role_id' => 1, 'page_id' => 2, 'read' => true, 'edit' => true, 'create' => true, 'update' => true, 'delete' => true],
            ['role_id' => 1, 'page_id' => 3, 'read' => true, 'edit' => true, 'create' => true, 'update' => true, 'delete' => true],
            ['role_id' => 1, 'page_id' => 4, 'read' => true, 'edit' => true, 'create' => true, 'update' => true, 'delete' => true],
            ['role_id' => 1, 'page_id' => 5, 'read' => true, 'edit' => true, 'create' => true, 'update' => true, 'delete' => true],
            ['role_id' => 1, 'page_id' => 6, 'read' => true, 'edit' => true, 'create' => true, 'update' => true, 'delete' => true],
            ['role_id' => 1, 'page_id' => 7, 'read' => true, 'edit' => true, 'create' => true, 'update' => true, 'delete' => true],
            ['role_id' => 1, 'page_id' => 8, 'read' => true, 'edit' => true, 'create' => true, 'update' => true, 'delete' => true],
            ['role_id' => 2, 'page_id' => 2, 'read' => true, 'edit' => false, 'create' => false, 'update' => false, 'delete' => false],
            // Add more permissions as needed
        ];

        foreach ($permissions as &$permission) {
            $permission['created_at'] = Carbon::now();
            $permission['updated_at'] = Carbon::now();
        }

        DB::table('permissions')->insert($permissions);
    }
}
