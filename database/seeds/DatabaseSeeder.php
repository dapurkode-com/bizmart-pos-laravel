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
        // $this->call(UserSeeder::class);
        // factory(App\Item::class, 5)->create();
        $this->call(LookUpsSeeder::class);
        $this->call(SystemParamsSeeder::class);

        User::create([
            'name'      => 'Admin',
            'email'     => 'admin@mail.com',
            'username'  => 'admin',
            'privilege_code' => 'OW',
            'password'  => bcrypt('airItuH2O')
        ]);
    }
}
