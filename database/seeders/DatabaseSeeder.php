<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Seting;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Seting::query()->insert([
            [
                'key' => 'home_title',
                'value' => 'حق لیبل',
            ],
            [
                'key' => 'mid',
                'value' => '9ef7f7f9-2a7d-4284-9c62-2a9393fb8ceb',
            ],
            [
                'key' => 'bg_page',
                'value' => '',
            ],
            [
                'key' => 'description_download',
                'value' => '',
            ],
        ]);
    }
}
