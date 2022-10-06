<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 *
 */
class Cipher
{
	private $encryption_iv = '1234567891011121';
	//private $encryption_key = 'T3sT';

	private $ciphering = "AES-128-CTR";
	private $options = 0;

	private $iv = '';
	private $key = '';

	function __construct()
	{
		$this->CI =& get_instance();
        $this->CI->load->model(array('Upload_model'));
	}

	/*public function encrypt($string)
	{
		$encryption = openssl_encrypt($string, $this->ciphering,
					$this->encryption_key, $this->options, $this->encryption_iv);
		return $encryption;
	}*/

	/*public function decrypt($string){
		$decryption = openssl_decrypt ($string, $this->ciphering,
				$this->encryption_key, $this->options, $this->encryption_iv);
		return $decryption;
	}*/

	public function encrypt($string)
	{
		$get = $this->CI->Upload_model->get_encr();
		//$iv  = $get['encryption_iv'];
        $key = $get['encryption_key'];

		$encryption = openssl_encrypt($string, $this->ciphering,
					$key, $this->options, $this->encryption_iv);
		return $encryption;
	}

	public function decrypt($string){

		$get = $this->CI->Upload_model->get_encr();
		//$iv  = $get['encryption_iv'];
        $key = $get['encryption_key'];

		$decryption = openssl_decrypt ($string, $this->ciphering,
				$key, $this->options, $this->encryption_iv);
		return $decryption;
	}
}
