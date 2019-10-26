<?php

use Illuminate\Database\Seeder;

class PointageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Pointage::class,40)->create();
    }
}
