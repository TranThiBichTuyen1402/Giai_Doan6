<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 7; $i++) {
    \App\Models\Template::create([
        'name' => 'Mẫu thiệp ' . $i,
        'description' => 'Mô tả mẫu thiệp ' . $i,
    ]);
}
    }
}
