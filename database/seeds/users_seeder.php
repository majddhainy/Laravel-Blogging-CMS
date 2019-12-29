<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class users_seeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // CREATE 1 ADMIN IN OUR SITE .. 
        $user = User::where('email' , 'admin@admin.com')->first();

        if(!$user){
            User::create([
                'name' =>'Admin',
                'email' => 'admin@admin.com',
                'role' =>  'admin',
                'password' => Hash::make('password')
            ]);
            
        }
    }
}
