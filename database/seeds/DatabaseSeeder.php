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
        $this->call(EntrepriseSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(HoraireSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PointageSeeder::class);
        $this->call(DemandeSeeder::class);
    }
}
