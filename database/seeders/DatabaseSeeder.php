<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
        'name' => 'Admin Amikom',
        'email' => 'admin@amikom.ac.id',
        'password' => bcrypt('password'),
        'role' => 'admin'
        ]);
        // =========================
        // 1. USERS
        // =========================
        User::firstOrCreate(
    ['email' => 'admin@amikom.ac.id'],
    [
        'name'     => 'Admin Amikom',
        'password' => Hash::make('password'),
        'role'     => 'admin',
    ]
);

        User::firstOrCreate(
    ['email' => 'test@example.com'],
    [
        'name'     => 'Test User',
        'password' => Hash::make('password'),
        'role'     => 'user',
    ]
);


        // =========================
        // 2. CATEGORIES
        // =========================
        $categoryIT = Category::create([
            'name' => 'Seminar IT',
            'slug' => 'seminar-it',
        ]);

        $categoryEnt = Category::create([
            'name' => 'Entertainment',
            'slug' => 'entertainment',
        ]);


        // =========================
        // 3. EVENTS
        // =========================
        Event::create([
            'category_id' => $categoryEnt->id,
            'title'       => 'Jazz Night 2026',
            'description' => 'Nikmati malam yang indah dengan alunan musik jazz yang merdu.',
            'date'        => '2026-05-10 19:00:00',
            'location'    => 'Amikom Baru',
            'price'       => 50000,
            'stock'       => 100,
            'poster_path' => 'posters/event-1.png',
        ]);

        Event::create([
            'category_id' => $categoryIT->id,
            'title'       => 'Hackathon - Unleash Your Inner Developer',
            'description' => 'Ayo asah skill coding kamu dan ciptakan solusi inovatif untuk tantangan masa depan!',
            'date'        => '2026-05-15 10:00:00',
            'location'    => 'Inkubator Amikom',
            'price'       => 75000,
            'stock'       => 150,
            'poster_path' => 'posters/event-2.png',
        ]);

        Event::create([
            'category_id' => $categoryIT->id,
            'title'       => 'AI & Future Tech Summit 2026',
            'description' => 'Jelajahi tren terkini dalam kecerdasan buatan dan teknologi masa depan bersama para ahli di bidangnya.',
            'date'        => '2026-06-01 13:00:00',
            'location'    => 'Cinema Unit 6',
            'price'       => 100000,
            'stock'       => 200,
            'poster_path' => 'posters/event-3.png',
        ]);
    }
}