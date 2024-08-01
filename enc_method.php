<?php
function d_Encrypt($plaintext, $keyword, $shift) {
    // Step 1: Apply Caesar Cipher shift
    $d_cipher = '';
    $len = strlen($plaintext);
    for ($i = 0; $i < $len; $i++) {
        $char = $plaintext[$i];
        $d_cipher .= chr(ord($char) + $shift); // Apply shift
    }
    
    // Step 2: Create mixed alphabet based on keyword
    $mixedAlphabet = '';
    $used = [];
    $keyword = strtoupper($keyword);
    
    foreach (str_split($keyword) as $char) {
        if (!isset($used[$char])) {
            $mixedAlphabet .= $char;
            $used[$char] = true;
        }
    }
    
    for ($i = ord('A'); $i <= ord('Z'); $i++) {
        $char = chr($i);
        if (!isset($used[$char])) {
            $mixedAlphabet .= $char;
        }
    }
    
    // Step 3: Apply Keyword Cipher substitution
    $ciphertext = '';
    $len = strlen($d_cipher);
    for ($i = 0; $i < $len; $i++) {
        $char = $d_cipher[$i];
        if (ctype_alpha($char)) {
            $index = ord(strtoupper($char)) - ord('A');
            $substitutedChar = $mixedAlphabet[$index];
            $ciphertext .= ctype_upper($char) ? $substitutedChar : strtolower($substitutedChar);
        } else {
            $ciphertext .= $char; // Non-alphabetic characters remain unchanged
        }
    }
    
    return $ciphertext;
}

function d_Decrypt($ciphertext, $keyword, $shift) {
    // Reverse Step 3: Reverse Keyword Cipher substitution
    $decrypted = '';
    $keyword = strtoupper($keyword);
    
    $mixedAlphabet = '';
    $used = [];
    
    foreach (str_split($keyword) as $char) {
        if (!isset($used[$char])) {
            $mixedAlphabet .= $char;
            $used[$char] = true;
        }
    }
    
    for ($i = ord('A'); $i <= ord('Z'); $i++) {
        $char = chr($i);
        if (!isset($used[$char])) {
            $mixedAlphabet .= $char;
        }
    }
    
    $len = strlen($ciphertext);
    for ($i = 0; $i < $len; $i++) {
        $char = $ciphertext[$i];
        if (ctype_alpha($char)) {
            $index = strpos($mixedAlphabet, strtoupper($char));
            $originalChar = chr($index + ord('A'));
            $decrypted .= ctype_upper($char) ? $originalChar : strtolower($originalChar);
        } else {
            $decrypted .= $char; // Non-alphabetic characters remain unchanged
        }
    }
    
    // Reverse Step 1: Reverse Caesar Cipher shift
    $d_Plain = '';
    $len = strlen($decrypted);
    for ($i = 0; $i < $len; $i++) {
        $char = $decrypted[$i];
        $d_Plain .= chr(ord($char) - $shift); // Reverse shift
    }
    
    return $d_Plain;
}


?>