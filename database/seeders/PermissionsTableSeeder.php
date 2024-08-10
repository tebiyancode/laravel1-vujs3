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
            // Add more permissions as needed
        ];

        foreach ($permissions as &$permission) {
            $permission['created_at'] = Carbon::now();
            $permission['updated_at'] = Carbon::now();
        }

        DB::table('permissions')->insert($permissions);
    }
}
