<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $templates = [];
        for ($i = 1; $i <= 11; $i++) {
            $templates[] = [
                'id'          => $i,
                'name'        => "Mẫu Thiệp Cưới {$i}",
                'slug'        => "mau-{$i}",
                'description' => "Thiết kế mẫu thiệp cưới số {$i}",
                'thumbnail'   => "templates/sample{$i}.jpg",
                'view'        => "templates.sample{$i}",
                'is_active'   => 1,
                'sort_order'  => $i,
                'created_at'  => now(),
                'updated_at'  => now(),
            ];
        }

        DB::table('templates')->insertOrIgnore($templates);
    }
}