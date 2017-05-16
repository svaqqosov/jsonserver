<?php

/**
 * Created by PhpStorm.
 * User: sardor
 * Date: 4/20/17
 * Time: 11:34 AM
 */
namespace App\Custom;


class CustomEncryptor {

    private $dictionaryForBase26;
    private $manufacturer;

    public function __construct($hardware_manufacturer = null){
        $this->manufacturer = ($hardware_manufacturer) ? $hardware_manufacturer : config('settings.hardware_manufacturer');
        $this->dictionaryForBase26 = config('settings.dictionary_for_base_26');
    }

    public function decimal_to_base_26($n) {
        static $base26_digits = '0123456789abcdefjhijklmnop';
        return strtr(base_convert($n, 10, 26), $base26_digits, $this->dictionaryForBase26);
    }

    public function base_26_to_decimal($n) {
        static $base26_digits = '0123456789abcdefjhijklmnop';
        $base11 = strtr($n, $this->dictionaryForBase26, $base26_digits);
        return base_convert($base11, 26, 10);
    }

    public function decimal_to_base_custom_dictionary($n) {
        static $dictionary = 'A&d%E56789';
        static $base10_digits = '0123456789';
        return strtr(base_convert($n, 10, 10), $base10_digits, $dictionary);
    }

    public function custom_dictionary_to_decimal($n) {
        static $dictionary = 'A&d%E56789';
        static $base10_digits = '0123456789';
        $base11 = strtr($n, $dictionary, $base10_digits);
        return base_convert($base11, 10, 10);
    }

    public function generateRandomString()
    {
        $length = config('settings.key_length') - 5;
        $int_ran = rand(1, 6);
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $string = $this->decimal_to_base_26(round(microtime(true) * 1000));
        for ($i = 0; $i < $length + $int_ran; $i++) {
            $string .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $string;
    }
    public function makeSerialNumber($serialDigit, $key){
        $data = $this->formatSerialNumber($this->padDigit($serialDigit, 15));
        //print_r($data);exit;
        $block_size = config('settings.encrypt_block_size');
        $mode = config('settings.encrypt_mode');
        $iv = config('settings.encrypt_iv');


        $aes = new AES($key, $mode, $block_size, $iv, $data);

        return $aes->encrypt();

    }

    private function formatSerialNumber($serialDigit){
        $year = $this->makeYear();
        $month = $this->makeMonth();
        $day = $this->makeDay();

        return $this->manufacturer.$year.$month.$day.$serialDigit;
    }

    private function makeYear(){
        $year = date('Y', time());

        return $this->decimal_to_base_26($year);
    }

    private function makeMonth(){
        $m = date('m', time());

        return $this->decimal_to_base_26($m);
    }
    /**
     * Generates day for serial number from current time
     * In order to make the day two letters always we gonna add 26 to the real day
     * @return string
     */
    private function makeDay(){
        $d = date('d', time()) + 26;

        return $this->decimal_to_base_26($d);
    }
    /**
     * Formats a number with leading zeros
     * @param $digit
     * @return string
     */
    private function padDigit($digit, $length){
        return str_pad($digit, $length, '0', STR_PAD_LEFT);
    }
    public function decodeSerial($serial){
        /*
         *  Example serial number is UVRjrEvYB000000000000003
         *  First 3 letters are manufacturer
         *  Next 3 letters are year
         *  Next 1 letter is for month
         *  Next 2 letters are day
         *
        */
        //print_r($serial);exit;
        $manufacturer = substr($serial, 0, 3);
        $year = substr($serial, 3, 3);
        $month = substr($serial, 6, 1);
        $day = substr($serial, 7, 2);
        $number = substr($serial, 9, 15);

        $year = (int) $this->base_26_to_decimal($year);
        $month = (int) $this->base_26_to_decimal($month);
        // Day contains 2 letters in order to make it two we have added 26 for real day.
        $day = (int) $this->base_26_to_decimal($day) - 26;

        $data['raw'] = $serial;
        $data['decoded']['manufacturer'] = $manufacturer;
        $data['decoded']['year'] = $year;
        $data['decoded']['month'] = $month;
        $data['decoded']['day'] = $day;
        $data['decoded']['serial'] = $number;

        return $data;

    }

    public function makeKeyFromQrString($string){
        $default_key_length = config('settings.key_length');
        $length = strlen($string);
        $key = '';
        for($i = $length-1; $i >= 0; $i--){
            $key .= $string[$i];
            $key .= $string[$length - $i - 1];

            if(strlen($key) == $default_key_length)
                break;
        }
        return $key;
    }

}