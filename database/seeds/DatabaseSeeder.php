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
        // DONT FORRGET TO UN COMMENT THIS LINE TO LET SEEDER RUN !
        $this->call(users_seeder::class);
    }
}
