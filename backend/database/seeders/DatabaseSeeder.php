<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        // User::delete();

        $user = User::create([
            'name' => 'hatem',
            'email' => 'admin@yahoo.com',
            'password' => bcrypt('123456')
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
