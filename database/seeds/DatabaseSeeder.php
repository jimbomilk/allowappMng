<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->truncateTables();
        $this->call('MainSeeder');
    }


    public function truncateTables()
    {
        $tables = array();
        $this->dbForeign(false);
        foreach ($tables as $table) {
            DB::table($table)->truncate();
        }

        $this->dbForeign(true);
    }

    public function dbForeign($activate)
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = ' . ($activate ? '1' : '0'));
    }
}