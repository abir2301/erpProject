<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\models\User ; 

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        User::create([
                      'name'=>'admin',
                      'email'=>'admin@admin.com',
                      'password'=>Hash::make('nachd-it'),
                      'phone_number'=>'12345678',
                      'role_id'=>'1',
                      'verified'=>'1',
                      ]);
    
    }
}
