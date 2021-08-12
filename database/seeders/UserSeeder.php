<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => '$2a$12$fV1Tw8R72Hc1VOutkgtvWuPgNjx17SfqnnfVGkKmMiSpgtH/7FgzW', // 123456789
            'roles' => 'admin'
        ]);

        User::factory()
            ->count(50)
            ->create(); 
    }
}
