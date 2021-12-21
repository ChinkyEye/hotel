<?php

use Illuminate\Database\Seeder;
use App\Usertype;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usertypes = [
            [
               'name' => 'ADMIN',
               'slug' => 'ADMIN',
               'discount' => '0',
               'type_id' => '0',
               'level_id' => '1',
               'is_salary' => '0',
               'date' => date('Y-m-d'),
               'date_np' => date('Y-m-d'),
               'time' => date('H:i:s'),
           ],
           [
               'name' => 'WAITER',
               'slug' => 'WAITER',
               'discount' => '0',
               'type_id' => '0',
               'level_id' => '5',
               'is_salary' => '0',
               'date' => date('Y-m-d'),
               'date_np' => date('Y-m-d'),
               'time' => date('H:i:s'),
           ],
           [
               'name' => 'Manager',
               'slug' => 'Manager',
               'discount' => '0',
               'type_id' => '0',
               'level_id' => '2',
               'is_salary' => '0',
               'date' => date('Y-m-d'),
               'date_np' => date('Y-m-d'),
               'time' => date('H:i:s'),
           ],
           [
              'name' => 'COUNTER',
              'slug' => 'COUNTER',
              'discount' => '0',
              'type_id' => '0',
              'level_id' => '4',
              'is_salary' => '0',
              'date' => date('Y-m-d'),
              'date_np' => date('Y-m-d'),
              'time' => date('H:i:s'),
          ],
          [
              'name' => 'Kitchen',
              'slug' => 'Kitchen',
              'discount' => '0',
              'type_id' => '0',
              'level_id' => '6',
              'is_salary' => '0',
              'date' => date('Y-m-d'),
              'date_np' => date('Y-m-d'),
              'time' => date('H:i:s'),
          ],
          [
              'name' => 'Bar',
              'slug' => 'Bar',
              'discount' => '0',
              'type_id' => '0',
              'level_id' => '7',
              'is_salary' => '0',
              'date' => date('Y-m-d'),
              'date_np' => date('Y-m-d'),
              'time' => date('H:i:s'),
          ],
          [
              'name' => 'Online Customer',
              'slug' => 'online_customer',
              'discount' => '0',
              'type_id' => '0',
              'level_id' => '8',
              'is_salary' => '0',
              'date' => date('Y-m-d'),
              'date_np' => date('Y-m-d'),
              'time' => date('H:i:s'),
          ],

          [
              'name' => 'Physical Customer',
              'slug' => 'Physical_customer',
              'discount' => '0',
              'type_id' => '0',
              'level_id' => '9',
              'is_salary' => '0',
              'date' => date('Y-m-d'),
              'date_np' => date('Y-m-d'),
              'time' => date('H:i:s'),
          ]
        ];

       foreach ($usertypes as $usertype) {
           Usertype::create($usertype);
        }
    }
}
