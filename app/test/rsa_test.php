<?php
require_once "../src/rsa.php";

use PHPUnit\Framework\TestCase;

class RSAEncryptionTest extends TestCase
{
    private $plaintext;
    private $p;
    private $q;
    private $keys;

    protected function setUp(): void
    {
        $this->plaintext = "This is the message to be encrypted.";
        $this->p = 11;
        $this->q = 17;
        $this->keys = generateKeys($this->p, $this->q);
    }

    public function testEncryption()
    {
        $ciphertext = encrypt($this->plaintext, $this->keys['public']['e'], $this->keys['public']['n']);
        $this->assertNotEquals($this->plaintext, $ciphertext);
    }

    public function testDecryption()
    {
        $ciphertext = encrypt($this->plaintext, $this->keys['public']['e'], $this->keys['public']['n']);
        $decrypted = decrypt($ciphertext, $this->keys['private']['d'], $this->keys['private']['n']);
        $this->assertEquals($this->plaintext, $decrypted);
    }
}

?>
