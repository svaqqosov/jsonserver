<?php

namespace App\Console\Commands;

use App\Custom\CustomEncryptor;
use App\SerialNumber;
use Illuminate\Console\Command;

class DecodeSerial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serial:decode {serial}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Decodes serial number';

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
        $serial = $this->argument('serial');
        if (is_numeric($serial)) {
            $data = SerialNumber::whereId($serial)->first();
        } else {
            $data = SerialNumber::where("qr_string", $serial)->first();
        }
        if ($data) {
            $encryptor = new CustomEncryptor();
            $serial_number = $data->decodeSerialNumber();
            $decrypted_serial = $encryptor->decodeSerial($serial_number);

            dd($decrypted_serial);
        }else{
            echo "\nNot found\n\n";
        }

    }
}
