<?php

use Illuminate\Database\Seeder;
use App\models\Role ; 

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'role_name'=>'admin',
            
            ]);
    }
}
