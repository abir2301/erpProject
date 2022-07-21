<?php

use Illuminate\Database\Seeder;
use App\models\Space ;
class SpaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Space::create([
            'space_name'=>'client',
        ]
        );
        Space::create([
            'space_name'=>'project',
        ]
        );
        Space::create([
            'space_name'=>'user',
        ]
        );
        Space::create([
            'space_name'=>'paper',
        ]
        );
        Space::create([
            'space_name'=>'paperType',
        ]
        ); 
        Space::create([
            'space_name'=>'role',
        ]);
        Space::create([
            'space_name'=>'bill',
        ]);
        Space::create([
            'space_name'=>'quote',
        ]);
    }
}
