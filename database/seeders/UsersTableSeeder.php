<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) { // Genera 50 registros ficticios
            DB::table('users')->insert([
                'name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'email' => $faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => '$2y$10$JF9gdWkYAcXeWTHzyiHLs.chiKPXQQpXpnitgTaZ0EQep31.ikFgK', // Establece una contraseña ficticia
                'remember_token' => '3kbxZdHUib4bmGPAXygviWjUSRD74zddPMeloIw5xO1xHy0FC6STCXxwfF1j',
                'created_at' => now(),
                'updated_at' => now(),
                'roles_id' => $faker->randomElement([2, 3]),  // Establece el valor de roles_id
                'deleted_at' => null, // No se elimina ningún registro ficticio
            ]);
        }
    }
}
