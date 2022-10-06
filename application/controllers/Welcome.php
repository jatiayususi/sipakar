<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		// $data['content'] = 'home';
		// $this->load->view('template', $data);
		// Store a string into the variable which 
	// need to be Encrypted 
	$simple_string = "Welcome to GeeksforGeeks\n"; 

	// Display the original string 
	echo "Original String: " . $simple_string; 

	// Store the cipher method 
	$ciphering = "AES-128-CTR"; 

	// Use OpenSSl Encryption method 
	$iv_length = openssl_cipher_iv_length($ciphering); 
	$options = 0; 

	// Non-NULL Initialization Vector for encryption 
	$encryption_iv = '1234567891011121'; 

	// Store the encryption key 
	$encryption_key = "GeeksforGeeks"; 

	// Use openssl_encrypt() function to encrypt the data 
	$encryption = openssl_encrypt($simple_string, $ciphering, 
				$encryption_key, $options, $encryption_iv); 

	// Display the encrypted string 
	echo "Encrypted String: " . $encryption . "\n"; 

	// Non-NULL Initialization Vector for decryption 
	$decryption_iv = '1234567891011121'; 

	// Store the decryption key 
	$decryption_key = "GeeksforGeeks"; 

	// Use openssl_decrypt() function to decrypt the data 
	$decryption=openssl_decrypt ($encryption, $ciphering, 
			$decryption_key, $options, $decryption_iv); 

	// Display the decrypted string 
	echo "Decrypted String: " . $decryption; 
	}
}
