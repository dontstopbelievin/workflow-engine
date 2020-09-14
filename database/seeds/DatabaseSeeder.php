<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(InputTypeSeeder::class);
        $this->call(InsertTypeSeeder::class);
        // $this->call(CityManagementSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(TemplateSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(SelectOptionSeeder::class);

    }
}
