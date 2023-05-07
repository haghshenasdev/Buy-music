<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Music;
use App\Models\Seting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
                'name' => 'home_title',
                'value' => 'حق لیبل',
            ],
            [
                'name' => 'mid',
                'value' => '9ef7f7f9-2a7d-4284-9c62-2a9393fb8ceb',
            ],
            [
                'name' => 'bg_page',
                'value' => 'http://localhost:8000/storage/photos/4/photo3707907175.jpg',
            ],
            [
                'name' => 'description_download',
                'value' => null,
            ],
            [
                'name' => 'presell_mail_subject',
                'value' => '',
            ],
            [
                'name' => 'presell_mail_content',
                'value' => '',
            ],
            [
                'name' => 'min_amount',
                'value' => '10000',
            ],
        ]);

        User::query()->insert([
            [
                'email' => 'mhgorgab@gmail.com',
                'name' => 'حق شناس',
                'is_admin' => 1,
                'password' => Hash::make('@123456789'),
            ],
            [
                'email' => 'user@gmail.com',
                'name' => 'کاربر',
                'is_admin' => null,
                'password' => Hash::make('@123456789'),
            ]
        ]);

        Music::query()->insert([
            'slug' => 'tst',
            'title' => 'تست',
            'is_active' => 1,
            'presell' => 1,
            'description' => '<p>jsj</p>',
            'bg_page' => 'http://localhost:8000/storage/photos/4/photo3707907175.jpg',
            'cover' => 'http://localhost:8000/storage/photos/4/photo3708112877.jpg',
        ]);
    }
}
