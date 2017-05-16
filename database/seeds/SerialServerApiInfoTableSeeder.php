<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SerialServerApiInfoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('serial_server_api_info')->insert(array(
            [
                'appId' => '100',
                'apiVersion' => 'v1',
                'created_at' => Carbon::now('Asia/Seoul'),
                'updated_at' => Carbon::now('Asia/Seoul'),
            ],
        ));
    }
}
