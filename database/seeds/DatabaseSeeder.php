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
       	$this->call(CityManagementSeeder::class);
        $this->call(InputTypeSeeder::class);
        $this->call(InsertTypeSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(TemplateSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(SelectOptionSeeder::class);
        $this->call(ProcessSeeder::class);
        $this->call(DictionarySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(EgknServiceSeeder::class);

    }
}
