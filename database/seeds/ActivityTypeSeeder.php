<?php

use Illuminate\Database\Seeder;
use App\models\ActivityType ;

class ActivityTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        ActivityType::create([
            'type_name'=>'Create',
             ]);

        ActivityType::create([
                'type_name'=>'Update',
                 ]);
        ActivityType::create([
                    'type_name'=>'Delete',
                ]);

    }
}
