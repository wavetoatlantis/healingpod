<?php

namespace Database\Seeders;

use App\Models\UserCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserCategory::factory()->create([
            'nama' => 'Admin',
        ]);

        UserCategory::factory()->create([
            'nama' => 'User',
        ]);
    }
}
