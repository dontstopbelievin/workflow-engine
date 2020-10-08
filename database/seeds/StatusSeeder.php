<?php

use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            [
                'name' => 'Заявка у заявителя' //1
            ],
            [
                'name' => 'Отправлено Специалисту Апз' //2
            ],
            [
                'name' => 'Отправлено Специалисту Эскиза Отдела' //3
            ],
            [
                'name' => 'Отправлено Специалисту Гор Арх Эскиза' //4
            ],
            [
                'name' => 'Отправлено Специалисту Зем Проекта' //5
            ],
            [
                'name' => 'Отправлено Специалисту Гор Арх Делимости/Неделимости' //6
            ],
            [
                'name' => 'Отправлено Специалисту Отдела Управления' // 7
            ],
            [
                'name' => 'Отправлено Специалисту Гор Арх' //8
            ],
            [
                'name' => 'Отправлено Специалисту Отдела Апо Гор Арх' //9
            ],
            [
                'name' => 'Отправлено Специалисту Ком Служб' //10
            ],
            [
                'name' => 'Отправлено Начальнику Отдела Управления' //11
            ],
            [
                'name' => 'Отправлено Начальнику Отдела Гор Арх' //12
            ],
            [
                'name' => 'Отправлено Начальнику Отдела Гор Арх Делимости/Неделимости' //13
            ],
            [
                'name' => 'Отправлено Исполнителю Эскиза' //14
            ],
            [
                'name' => 'Отправлено Рук Апо Гор Арх' // 15
            ],
            [
                'name' => 'Отправлено Зам Рук Апо Гор Арх' // 16
            ],
            [
                'name' => 'Отправлено Зам Дир Гор АРх' // 17
            ],
            [
                'name' => 'Отправлено Директору Гор Арх' // 18
            ],
            [
                'name' => 'Отправлено Зам Рук Упр' // 19
            ],
            [
                'name' => 'Отправлено Руководителю управления' // 20
            ],
            [
                'name' => 'Отправлено Заявителю с отказом' // 21
            ],
            [
                'name' => 'Отправлено Заявителю' // 22

            ],
        ]);
    }
}
