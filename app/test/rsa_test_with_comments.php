<?php
require_once "path/to/rsa.php";

use PHPUnit\Framework\TestCase;

/**
 * Class RSAEncryptionTest
 *
 * This class tests the RSA encryption functions to ensure they work correctly
 */
class RSAEncryptionTest extends TestCase
{
    private $plaintext;
    private $p;
    private $q;
    private $keys;

    /**
     * Setting up the initial variables for the test
     */
    protected function setUp(): void
    {
        $this->plaintext = "This is the message to be encrypted.";
        $this->p = 11;
        $this->q = 17;
        $this->keys = generateKeys($this->p, $this->q);
    }

    /**
     * Test the encrypt function
     */
    public function testEncryption()
    {
        $ciphertext = encrypt($this->plaintext, $this->keys['public']['e'], $this->keys['public']['n']);
        $this->assertNotEquals($this->plaintext, $ciphertext);
    }

    /**
     * Test the decrypt function
     */
    public function testDecryption()
    {
        $ciphertext = encrypt($this->plaintext, $this->keys['public']['e'], $this->keys['public']['n']);
        $decrypted = decrypt($ciphertext, $this->keys['private']['d'], $this->keys['private']['n']);
        $this->assertEquals($this->plaintext, $decrypted);
    }
}
