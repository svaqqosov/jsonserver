<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MobileAppsInfoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mobile_apps_info')->insert(array(
            [
                'appId' => '100',
                'region' => 'us',
                'host' => 'https://youvr.io',
                'apiVersion' => 'v1',
                'analytics' => json_encode(['host' => 'https://analytics.imsv.io', 'siteId' => '1', 'token' => '16bbd847926c91426d2b4557e4f2f722']),
                'created_at' => Carbon::now('Asia/Seoul'),
                'updated_at' => Carbon::now('Asia/Seoul'),
            ],
            [
                'appId' => '100',
                'region' => 'kr',
                'host' => 'https://youvr.kr',
                'apiVersion' => 'v1',
                'analytics' => json_encode(['host' => 'https://analytics.imsv.io', 'siteId' => '1', 'token' => '16bbd847926c91426d2b4557e4f2f722']),
                'created_at' => Carbon::now('Asia/Seoul'),
                'updated_at' => Carbon::now('Asia/Seoul'),
            ],
            [
                'appId' => '100',
                'region' => 'cn',
                'host' => 'https://cn.imsv.io',
                'apiVersion' => 'v1',
                'analytics' => json_encode(['host' => 'https://analytics.imsv.io', 'siteId' => '1', 'token' => '16bbd847926c91426d2b4557e4f2f722']),
                'created_at' => Carbon::now('Asia/Seoul'),
                'updated_at' => Carbon::now('Asia/Seoul'),
            ],
            [
                'appId' => '100',
                'region' => 'dev',
                'host' => 'https://dev.imsv.io',
                'apiVersion' => 'v1',
                'analytics' => json_encode(['host' => 'https://analytics.imsv.io', 'siteId' => '1', 'token' => '16bbd847926c91426d2b4557e4f2f722']),
                'created_at' => Carbon::now('Asia/Seoul'),
                'updated_at' => Carbon::now('Asia/Seoul'),
            ],
        ));
    }
}
