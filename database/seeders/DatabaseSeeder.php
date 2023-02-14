<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         for ($i=0; $i<100; $i++) {
             User::create([
                 'name' => Str::random(10),
                 'email' => Str::random(12).'@gmail.com',
                 'email_verified_at' => now(),
                 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                 'remember_token' => Str::random(10),
                 'user_code' => 'U' . sprintf('%08d', $i)
             ]);
         }
    }
}
