<?php

namespace App\Console\Commands;

use App\Custom\CustomEncryptor;
use App\SerialNumber;
use Illuminate\Console\Command;

class CreateSerial extends Command
{
    public static $EXIT_CODE = [
        'FAILED'=>-1,
        'USER_OR_PROJECT_NOT_FOUND'=>0,
        'SUCCESS'=>1
    ];
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serial:create {number}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates serial numbers';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $number = $this->argument('number');
        if($this->isNullOrEmptyString($number)){
            echo 'You need to specify user as a param. e.g. serial:create 10';
            return self::$EXIT_CODE['FAILED'];
        }
        $encryptor = new CustomEncryptor();

        for($i = 1; $i <= $number; $i ++){
            $serial_num_model = new SerialNumber();
            $random_str = $encryptor->generateRandomString();
            $key = $encryptor->makeKeyFromQrString($random_str);
            $serial_num_model->qr_string = $random_str;
            $serial_num_model->key = $key;

            $serial_num_model->serial_number = $encryptor->makeSerialNumber($i, $key);
            $serial_num_model->save();
            echo $i . " => " .$serial_num_model->qr_string."\n";
        }
        echo "\n SERIAL NUMBERS ARE ADDED\n";
        return self::$EXIT_CODE['SUCCESS'];
    }
    private function isNullOrEmptyString($question){
        return (!isset($question) || trim($question)==='');
    }
}
