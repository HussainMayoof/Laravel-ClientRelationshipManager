<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Task;
use App\Models\User;
use App\Models\Client;
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

        User::factory()->count(20)->has(Task::factory()->count(rand(1,10)))->hasAttached(Client::factory()->count(rand(1,10)), function () {
            return [
            'title' => fake()->words(rand(1,4), true),
            'description' => fake()->sentence(rand(3,20)),
            'deadline' => fake()->date(),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
            ];
        })->create();
    }
}
