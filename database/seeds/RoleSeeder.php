<?php

use Illuminate\Database\Seeder;
use App\CityManagement;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        // factory(\App\Role::class, 10)->create();

        DB::table('roles')->insert([
            [
                'name' => 'Заявитель',
            ],
            [
                'name' => 'Специалист Апз', //2 управление
//                'city_management_id' => CityManagement::all()->random()->id,
            ],
            [
                'name' => 'Начальник Отдела', //3 управление
//                'city_management_id' => 1,
            ],
            [
                'name' => 'Зам Нач Упр', //4 управление
//                'city_management_id' => 1,
            ],
            [
                'name' => 'Рук Упр', //5 управление
//                'city_management_id' => 1,
            ],
            [
                'name' => 'Специалист Эскиза', //6 управление
//                'city_management_id' => 1,
            ],
            [
                'name' => 'Специалист Гор Арх Эскиза', //7 Гор Арх
//                'city_management_id' => 1,
            ],
            [
                'name' => 'Директор Гор Арх', //8 Гор Арх
//                'city_management_id' => 1,
            ],
            [
                'name' => 'Специалист Зем Проекта', //9 управление
//                'city_management_id' => 1,
            ],
            [
                'name' => 'Начальник Отдела Зем Проекта', //10 управление
//                'city_management_id' => 1,
            ],
            [
                'name' => 'Специалист Гор Арх Делимости/Неделимости', //11 Гор Арх
//                'city_management_id' => 1,
            ],
            [
                'name' => 'Начальник Отдела Гор Арх Делимости/Неделимости', //12 Гор Арх
//                'city_management_id' => 1,
            ],
            [
                'name' => 'Зам Дир Гор Арх', //13 Гор Арх
//                'city_management_id' => 1,
            ],
            [
                'name' => 'Рук Апо Гор Арх', //14 Гор Арх
//                'city_management_id' => 1,
            ],
            [
                'name' => 'Специалист Отдела Апо Гор Арх', //15 Гор Арх
//                'city_management_id' => 1,
            ],
            [
                'name' => 'Зам Рук Апо Гор Арх', //16 Гор Арх
//                'city_management_id' => 1,
            ],
            [
                'name' => 'Специалист Эскиза', //17 Гор Арх
//                'city_management_id' => 1,
            ],
            [
                'name' => 'Зам директора управления архитектуры', //18 Гор Арх
//                'city_management_id' => 1,
            ],
            [
                'name' => 'Директор Управления Архитектуры', //19 Гор Арх
//                'city_management_id' => 1,
            ],
            

        ]);
    }
}
