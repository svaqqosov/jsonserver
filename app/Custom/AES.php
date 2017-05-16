<?php
/**
 * Created by PhpStorm.
 * User: sardor
 * Date: 3/11/16
 * Time: 4:26 PM
 */

namespace App\Custom;


class AES
{
    // standard const
    const M_CBC = 'cbc';
    const M_CFB = 'cfb';
    const M_ECB = 'ecb';
    const M_NOFB = 'nofb';
    const M_OFB = 'ofb';
    const M_STREAM = 'stream';

    protected $key;
    protected $cipher;
    protected $data;
    protected $mode;
    protected $IV;
    /**
     *
     * @param type $data
     */
    function __construct($key, $mode, $block_size, $iv, $data = null) {
        $this->setKey($key);
        $this->setData($data);
        $this->setBlockSize($block_size);
        $this->setMode($mode);
        $this->setIV($iv);
    }

    /**
     *
     * @param type $data
     */
    public function setData($data) {
        $this->data = $data;
    }
    public function setIV($iv) {
        $this->IV = $iv;
    }
    /**
     *
     * @param type $key
     */
    public function setKey($key) {
        $this->key = $key;
    }

    /**
     *
     * @param type $blockSize
     */
    public function setBlockSize($block_size) {
        $this->block_size = $block_size;
        switch ($this->block_size) {
            case 128:
                $this->cipher = MCRYPT_RIJNDAEL_128;
                break;

            case 192:
                $this->cipher = MCRYPT_RIJNDAEL_192;
                break;

            case 256:
                $this->cipher = MCRYPT_RIJNDAEL_256;
                break;
        }
    }

    /**
     *
     * @param type $mode
     */
    public function setMode($mode) {
        $this->mode = $mode;
        switch ($this->mode) {
            case AES::M_CBC:
                $this->mode = MCRYPT_MODE_CBC;
                break;
            case AES::M_CFB:
                $this->mode = MCRYPT_MODE_CFB;
                break;
            case AES::M_ECB:
                $this->mode = MCRYPT_MODE_ECB;
                break;
            case AES::M_NOFB:
                $this->mode = MCRYPT_MODE_NOFB;
                break;
            case AES::M_OFB:
                $this->mode = MCRYPT_MODE_OFB;
                break;
            case AES::M_STREAM:
                $this->mode = MCRYPT_MODE_STREAM;
                break;
            default:
                $this->mode = MCRYPT_MODE_ECB;
                break;
        }
    }

    /**
     *
     * @return boolean
     */
    public function validateParams() {
        if ($this->data != null) {
            return true;
        } else {
            return FALSE;
        }
    }

    protected function getIV() {
        if ($this->IV == "") {
            $this->IV = mcrypt_create_iv(mcrypt_get_iv_size($this->cipher, $this->mode), MCRYPT_RAND);
        }
        return $this->IV;
    }

    /**
     * @return type
     * @throws Exception
     */
    public function encrypt() {
        if ($this->validateParams()) {
            return trim(bin2hex(
                mcrypt_encrypt(
                    $this->cipher, $this->key, $this->data, $this->mode, $this->getIV())));
        } else {
            throw new Exception('Invlid params!');
        }
    }
    /**
     *
     * @return type
     * @throws Exception
     */
    public function decrypt() {
        if ($this->validateParams()) {
            $data = mcrypt_decrypt(
                $this->cipher, $this->key, hex2bin($this->data), $this->mode, $this->getIV());
            //print_r([$this->cipher, $this->key, $this->data, $this->mode, $this->getIV(), strlen($data), strlen($this->key)]);exit;
            return trim($data);
        } else {
            throw new Exception('Invlid params!');
        }
    }

}