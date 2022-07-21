<?php

use Illuminate\Database\Seeder;
use App\models\Action ;
class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Action::create(
           [
                'action_name'=>'read'
            ]
        );
        Action::create(
            [
                 'action_name'=>'create'
             ]
         );
         Action::create(
            [
                 'action_name'=>'update'
             ]
         );
         Action::create(
            [
                 'action_name'=>'delete'
             ]
         );
    }
}
