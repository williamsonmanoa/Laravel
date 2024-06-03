<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $listUsers = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' =>  Hash::make('admin@gmail.com')
            ],
            [
                'name' => 'Equipe',
                'email' => 'admmin-equipe@gmail.com',
                'password' =>  Hash::make('admmin-equipe@gmail.com')
            ]
        ];

        // create or update users
        foreach ($listUsers as $item){
            $user = User::where('email',$item['email'])->first();
            if($user){
                $user->update($item);
            }else{
                User::factory()->create($item);
            }
        }
    }
}
