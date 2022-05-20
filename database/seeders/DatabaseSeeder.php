<?php

namespace Database\Seeders;

use Domain\Auth\Models\User;
use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade as Bouncer;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
             'email' => 'matthewhall9999@gmail.com'
        ]);

        Bouncer::role()->firstOrCreate([
            'name' => 'hr',
            'title' => 'HR',
        ]);

        Bouncer::role()->firstOrCreate([
            'name' => 'manager',
            'title' => 'Manager',
        ]);

        Bouncer::role()->firstOrCreate([
            'name' => 'department-head',
            'title' => 'Head of Department',
        ]);
    }
}
