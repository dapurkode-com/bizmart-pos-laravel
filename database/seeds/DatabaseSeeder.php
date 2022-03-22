<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => 'Admin',
            'email'     => 'admin@mail.com',
            'username'  => 'admin',
            'privilege_code' => 'OW',
            'password'  => bcrypt('airItuH2O')
        ]);
        // $this->call(UserSeeder::class);
        $this->call(LookUpsSeeder::class);
        $this->call(SystemParamsSeeder::class);
        $this->call(PrevSeeder::class);


    }
}
