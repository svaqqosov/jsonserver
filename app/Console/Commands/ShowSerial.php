<?php

namespace App\Console\Commands;

use App\Custom\CustomEncryptor;
use App\SerialNumber;
use Illuminate\Console\Command;

class ShowSerial extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'serial:show {id=all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Shows serial number(s)';

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
        $id = $this->argument('id');
        if($id == "all"){
            $data = SerialNumber::all();
            foreach($data as $i => $d){
                echo $i . " => " .$d->qr_string."\n\n";
            }
        }else{
            $data = SerialNumber::whereId($id)->first();
            if($data)
                echo $data->qr_string."\n";
            else
                echo "\nNot found\n\n";
        }

    }
}
