<?php

// Function for RSA encryption


function gcd($a, $b) {
    return $b == 0 ? $a : gcd($b, $a % $b);
}

function modInverse($a, $m) {
    $m0 = $m;
    $y = 0;
    $x = 1;

    if ($m == 1)
        return 0;

    while ($a > 1) {
        $q = floor($a / $m);
        $t = $m;
        $m = $a % $m;
        $a = $t;
        $t = $y;
        $y = $x - $q * $y;
        $x = $t;
    }

    if ($x < 0)
        $x = $x + $m0;

    return $x;
}

function encrypt($plaintext, $e, $n) {
    $ciphertext = array();

    for ($i = 0; $i < strlen($plaintext); $i++) {
        $ciphertext[] = (ord($plaintext[$i]) ** $e) % $n;
    }

    return implode(",", $ciphertext);
}

function decrypt($ciphertext, $d, $n) {
    $plaintext = "";

    $ciphertext = explode(",", $ciphertext);

    foreach ($ciphertext as $c) {
        $plaintext .= chr(($c ** $d) % $n);
    }

    return $plaintext;
}

function generateKeys($p, $q) {
    $n = $p * $q;
    $phi = ($p - 1) * ($q - 1);

    $e = 2;

    while (gcd($e, $phi) != 1) {
        $e++;
    }

    $d = modInverse($e, $phi);

    return array("public" => array("e" => $e, "n" => $n),
        "private" => array("d" => $d, "n" => $n));
}

// Get the plaintext from an input field
//$plaintext = $_POST['plaintext'];
$plaintext = "Ferjem_irta_a_szakdogam";

$p = 11;
$q = 17;

$keys = generateKeys($p, $q);

$ciphertext = encrypt($plaintext, $keys['public']['e'], $keys['public']['n']);

$decrypted = decrypt($ciphertext, $keys['private']['d'], $keys['private']['n']);

echo "Original: " . $plaintext . "\n";
echo "Encrypted: " . $ciphertext . "\n";
echo "Decrypted: " . $decrypted . "\n";
//echo "Public Key: (" . $keys['public']['e'] . ", " . $keys['public']['n'] . ")";
//echo "Private Key: (" . $keys['private']['d'] . ", " . $keys['private']['n'] . ")";

?>
