<?php

use Illuminate\Database\Seeder;
use App\models\Company ;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create(
            [
                 'name'=>'Nachd-IT',
                 'local'=>'espace incubateur ISSAT Sousse, Rue Ibn Kholdoun, cité Tafféla, sousse 4003',
                 'email'=>'contact@nachd-it.com',
                 'logo'=>'files/files/std.png',
                 'domaine' => 'conception et réalisation des application web, mobile et desktop et services informatique',
                 'bank' => 'Tijari Bank 04500043005296886489',
                 'mat_fiscal' => '1530684/Y/A/M/00',
                 'phone_number'=>'27751305',
                 'tax' => '0.700',
                 'tva' => '19',


             ]
         );

    }
}
