<?php

use Illuminate\Database\Seeder;

class RoleStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	//1-odobril 2-otkazal 3-podpisal 4-otrpavelno
        DB::table('role_statuses')->insert([
        	[
                'status_id' => 4,
                'role_name' => 'Заявитель',
                'string' => 'Отправлено специалистом Айкала',
            ],
            [
                'status_id' => 1,
                'role_name' => 'Специалист Айкала',
                'string' => 'Одобрено специалистом Айкала',
            ],
            [
                'status_id' => 2,
                'role_name' => 'Специалист Айкала',
                'string' => 'Отклонено специалистом Айкала',
            ],
            [
                'status_id' => 3,
                'role_name' => 'Специалист Айкала',
                'string' => 'Подписано специалистом Айкала',
            ],
            [
                'status_id' => 4,
                'role_name' => 'Специалист Айкала',
                'string' => 'Отправлено специалистом Айкала',
            ],
        ]);
    }
}
