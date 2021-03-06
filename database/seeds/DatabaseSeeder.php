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
       	$this->call(Organizations::class);
        $this->call(InputTypeSeeder::class);
        $this->call(InsertTypeSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(TemplateSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(DictionarySeeder::class);
        $this->call(SelectOptionSeeder::class);
        $this->call(ProcessSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(TemplateDocSeeder::class);
        $this->call(EgknServiceSeeder::class);
        $this->call(RoleStatusesSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(FileCategorySeeder::class);
        $this->call(ProcessScript::class);
    }
}
