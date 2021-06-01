<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'first_name' => 'Жәнібек',
                'sur_name' => '',
                'middle_name' => 'Кенжебекұлы',
                'telephone' => '7074295539',
                'email' => 'Quaresma90@list.ru',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 44,
                'usertype' => 'super_admin'
            ],
        ]);

        DB::table('users')->insert([
            [
                'first_name' => 'Admin',
                'sur_name' => 'Admin',
                'middle_name' => 'Admin',
                'telephone' => '7771234567',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 1,
            ],
            [
                'first_name' => 'Айгерим',
                'sur_name' => 'Альмурзаева',
                'middle_name' => '',
                'telephone' => '7074295539',
                'email' => 'a.almurzayeva@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 44,
            ],
            [
                'first_name' => 'Нуржан',
                'sur_name' => 'Кенжебеков',
                'middle_name' => 'Кенжебекович',
                'telephone' => '7771234567',
                'email' => 'kenzhebekov.nurzhan888@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 25,
            ],
            [
                'sur_name' => 'Сагнаев',
                'first_name' => 'Арман',
                'middle_name' => '',
                'telephone' => '7771234567',
                'email' => 'armansagnayev@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 23,
            ],
            [
                'sur_name' => 'Алтаев',
                'first_name' => 'Данияр',
                'middle_name' => '',
                'telephone' => '7771234567',
                'email' => 'daniyaraltayev@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 20,
            ],
            [
                'sur_name' => 'Уранхаев',
                'first_name' => 'Нурлан',
                'middle_name' => 'Тельманович',
                'telephone' => '7771234567',
                'email' => 'uranhayev.nurlan@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 26,
            ],
            [
                'sur_name' => 'Смагулов',
                'first_name' => 'Аян',
                'middle_name' => '',
                'telephone' => '7771234567',
                'email' => 'smagulov.ayan@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 11,
            ],[
                'sur_name' => 'Кушеров',
                'first_name' => 'Асхат',
                'middle_name' => '',
                'telephone' => '7771234567',
                'email' => 'kusherov.ashat@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 2,
            ],
            [
                'sur_name' => 'Алтаева',
                'first_name' => 'Жулдыз',
                'middle_name' => 'Канатовна',
                'telephone' => '7771234567',
                'email' => 'altayeva_zhuldiz@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 19,
            ],
            [
                'sur_name' => 'Абаев',
                'first_name' => 'Анзор',
                'middle_name' => '',
                'telephone' => '7771234567',
                'email' => 'anzor4eh4@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 17,
            ],
            [
                'sur_name' => 'Бесбаева',
                'first_name' => 'Гульнар',
                'middle_name' => '',
                'telephone' => '7771234567',
                'email' => 'besbayeva.gulnar@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 1,
            ],
            [
                'sur_name' => 'Баймаханов',
                'first_name' => 'Аскер',
                'middle_name' => '',
                'telephone' => '7771234567',
                'email' => 'baimahanov_asker@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 4,
            ],
            [
                'sur_name' => 'Макашева',
                'first_name' => 'Айгуль',
                'middle_name' => '',
                'telephone' => '7771234567',
                'email' => 'zhakupova.aigul01@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 7,
            ],
            [
                'sur_name' => 'Акатаев',
                'first_name' => 'Руслан',
                'middle_name' => '',
                'telephone' => '7771234567',
                'email' => 'akatayev_ruslan@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 8,
            ],
            [
                'sur_name' => 'Шаяхметова',
                'first_name' => 'Бибигуль',
                'middle_name' => '',
                'telephone' => '7771234567',
                'email' => 'shayahmetova_bibigul@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 5,
            ],
            [
                'sur_name' => 'Макатай',
                'first_name' => 'Азат',
                'middle_name' => '',
                'telephone' => '7771234567',
                'email' => 'makatai_azat@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 6,
            ],
            [
                'sur_name' => 'Жакупова',
                'first_name' => 'Айгуль',
                'middle_name' => 'Ильясовна',
                'telephone' => '7771234567',
                'email' => 'zhakupova.ai@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 18,
            ],
            [
                'sur_name' => 'Ескендирова',
                'first_name' => 'Махаббат',
                'middle_name' => '',
                'telephone' => '7771234567',
                'email' => 'yeskendirova.m@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 9,
            ],
            [
                'sur_name' => 'Санабаева',
                'first_name' => 'Альмира',
                'middle_name' => '',
                'telephone' => '7771234567',
                'email' => 'sanbayevaalmira@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 21,
            ],
            [
                'sur_name' => 'Аяпова',
                'first_name' => 'Альбина',
                'middle_name' => '',
                'telephone' => '7771234567',
                'email' => 'ayapova.albina@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 22,
            ],
            [
                'sur_name' => 'Сабыркулов',
                'first_name' => 'Асылбек',
                'middle_name' => 'Тулемисович',
                'telephone' => '7771234567',
                'email' => 'sabyrkulov.asylbek@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 23,
            ],
            [
                'sur_name' => 'Серикбаев',
                'first_name' => 'Нурхан',
                'middle_name' => 'Жандосович',
                'telephone' => '7771234567',
                'email' => 'serikbayev.nurhan@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 10,
            ],
            [
                'sur_name' => 'Аяпбергенов',
                'first_name' => 'Султан',
                'middle_name' => 'Зейнуллович',
                'telephone' => '7771234567',
                'email' => 'ayapbergenov.sultan@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 12,
            ],
            [
                'sur_name' => 'Алкуатова',
                'first_name' => 'Сауле',
                'middle_name' => 'Алкуатовна',
                'telephone' => '7771234567',
                'email' => 'alkuatova.saule@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 13,
            ],
            [
                'sur_name' => 'Жакупов',
                'first_name' => 'Руслан',
                'middle_name' => 'Ергалиевич',
                'telephone' => '7771234567',
                'email' => 'zhakupov.ruslan01@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 14,
            ],
            [
                'sur_name' => 'Балабеков',
                'first_name' => 'Бауржан',
                'middle_name' => 'Жаксылыкович',
                'telephone' => '7771234567',
                'email' => 'balabekov.baurzhan@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 15,
            ],
            [
                'sur_name' => 'Ғалымжан',
                'first_name' => 'Нұрәділ',
                'middle_name' => 'Болатұлы',
                'telephone' => '7771234567',
                'email' => 'galymzhan.nuradil@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 16,
            ],
            [
                'sur_name' => 'Тажбен',
                'first_name' => 'Ерсаин',
                'middle_name' => 'Ерғалиұлы',
                'telephone' => '7771234567',
                'email' => 'tazhben.yersayin@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 3,
            ],
            [
                'sur_name' => 'Жанбыршы',
                'first_name' => 'Алмас',
                'middle_name' => 'Маликович',
                'telephone' => '7771234567',
                'email' => 'Zhanbyrshy7@gmail.com',
                'password' => Hash::make('123123Aa@'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'role_id' => 24,
            ],


        ]);


    }
}
