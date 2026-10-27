<?php

namespace App\Service;

class EncryptionService
{
    // Clé secrète récupérée depuis le fichier .env (à définir plus tard)
    private string $key;

    public function __construct()
    {
        // Pour l'instant, on génère une clé de secours ou on prend une variable d'environnement
        // En prod, il faudra la stocker proprement dans .env.local
        $this->key = hash('sha256', 'VaultGuardSecretKeyChangeMe', true);
    }

    public function encrypt(string $plainPassword): string
    {
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $ciphertext = sodium_crypto_secretbox($plainPassword, $nonce, $this->key);
        
        // On combine le nonce et le texte chiffré pour pouvoir déchiffrer plus tard
        return base64_encode($nonce . $ciphertext);
    }

    public function decrypt(string $encryptedPassword): string
    {
        $decoded = base64_decode($encryptedPassword);
        $nonceKeysize = SODIUM_CRYPTO_SECRETBOX_NONCEBYTES;
        
        $nonce = mb_substr($decoded, 0, $nonceKeysize, '8bit');
        $ciphertext = mb_substr($decoded, $nonceKeysize, null, '8bit');

        $plain = sodium_crypto_secretbox_open($ciphertext, $nonce, $this->key);
        
        if ($plain === false) {
            throw new \Exception('Erreur lors du déchiffrement du mot de passe.');
        }

        return $plain;
    }
}