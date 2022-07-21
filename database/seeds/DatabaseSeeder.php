<?php

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
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ActionSeeder::class);
        $this->call(SpaceSeeder::class);
        $this->call(ActivityTypeSeeder::class);
        $this->call(PaperTypeSeeder::class);
        $this->call(CompanySeeder::class);


    }
}
