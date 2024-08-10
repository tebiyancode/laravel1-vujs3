<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert(
            [
            'id' => '1',
            'page' => 'cpanel',
            'icon' => 'fa fa-list-alt',
            'path' => '#',
            'order' => '1',
            'page_id' => '0',
        ],
            [
            'id' => '2',
            'page' => 'pages',
            'icon' => 'fa fa-file',
            'path' => '/pages',
            'order' => '3',
            'page_id' => '1',
        ],
            [
                'id' => '3',
            'page' => 'users',
            'icon' => 'fa fa-user-circle',
            'path' => '/users',
            'order' => '2',
            'page_id' => '1',
        ],
            [
                'id' => '4',
            'page' => 'roles',
            'icon' => 'fa fa-user-plus',
            'path' => '/roles',
            'order' => '3',
            'page_id' => '1',
        ],
            [
                'id' => '5',
            'page' => 'permissions',
            'icon' => 'fa fa-receipt',
            'path' => '/permissions',
            'order' => '5',
            'page_id' => '1',
        ],
            [
                'id' => '6',
            'page' => 'translates',
            'icon' => 'fa fa-language',
            'path' => '/translates',
            'order' => '7',
            'page_id' => '5',
        ],
            [
                'id' => '7',
            'page' => 'GeneralSettings',
            'icon' => 'fa fa-gears',
            'path' => '/general-settings',
            'order' => '1',
            'page_id' => '1',
        ],
            [
                'id' => '8',
            'page' => 'appFonts',
            'icon' => 'fa fa-font',
            'path' => '/app-fonts',
            'order' => '6',
            'page_id' => '1',
        ],
    );
    }
}
