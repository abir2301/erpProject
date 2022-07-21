<?php

use Illuminate\Database\Seeder;
use App\models\PaperType ;

class PaperTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaperType::create([
            'paper_type'=> "update",
            'is_renewing' => 1
            ]);
        PaperType::create([
            'paper_type'=> "maintenance",
            'is_renewing' => 1
            ]);
        PaperType::create([
               'paper_type'=> "hosting",
               'is_renewing' => 1
               ]);
        PaperType::create([
            'paper_type'=> "purchase order",
               ]);


        PaperType::create([
                'paper_type'=> "quote"
            ]);


    }
}
