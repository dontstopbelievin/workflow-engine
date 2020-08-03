<?php

use Illuminate\Database\Seeder;

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
            ],
            [
                'name' => 'Начальник Отдела', //3 управление
            ],
            [
                'name' => 'Зам Нач Упр', //4 управление
            ],
            [
                'name' => 'Рук Упр', //5 управление
            ],
            [
                'name' => 'Специалист Эскиза', //6 управление
            ],
            [
                'name' => 'Специалист Гор Арх Эскиза', //7 Гор Арх
            ],
            [
                'name' => 'Директор Гор Арх', //8 Гор Арх
            ],
            [
                'name' => 'Специалист Зем Проекта', //9 управление
            ],
            [
                'name' => 'Начальник Отдела Зем Проекта', //10 управление
            ],
            [
                'name' => 'Специалист Гор Арх Делимости/Неделимости', //11 Гор Арх
            ],
            [
                'name' => 'Начальник Отдела Гор Арх Делимости/Неделимости', //12 Гор Арх
            ],
            [
                'name' => 'Зам Дир Гор Арх', //13 Гор Арх
            ],
            [
                'name' => 'Рук Апо Гор Арх', //14 Гор Арх
            ],
            [
                'name' => 'Специалист Отдела Апо Гор Арх', //15 Гор Арх
            ],
            [
                'name' => 'Зам Рук Апо Гор Арх', //16 Гор Арх
            ],
            

        ]);
    }
}
