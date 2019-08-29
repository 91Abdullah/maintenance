<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->insert([
            ["key" => "url", "value" => "Bsms.its.com.pk"],
            ["key" => "api_key", "value" => ""],
            ["key" => "username", "value" => ""],
            ["key" => "password", "value" => ""],
        ]);
    }
}
