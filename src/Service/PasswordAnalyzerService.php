<?php

namespace App\Service;

class PasswordAnalyzerService
{
    public function evaluate(string $password): array
    {
        $score = 0;
        $length = mb_strlen($password);

        // 1. Critère de longueur
        if ($length >= 8) $score += 20;
        if ($length >= 12) $score += 20;
        if ($length >= 16) $score += 10;

        // 2. Présence de minuscules et majuscules
        if (preg_match('/[a-z]/', $password) && preg_match('/[A-Z]/', $password)) {
            $score += 20;
        }

        // 3. Présence de chiffres
        if (preg_match('/[0-9]/', $password)) {
            $score += 15;
        }

        // 4. Présence de caractères spéciaux
        if (preg_match('/[^a-zA-Z0-9]/', $password)) {
            $score += 15;
        }

        // Détermination du niveau (Du plus faible au plus élevé)
        $level = 'Très faible';
        if ($score >= 40) $level = 'Faible';
        if ($score >= 60) $level = 'Moyen';
        if ($score >= 80) $level = 'Fort';
        if ($score >= 100) $level = 'Très fort';

        return [
            'score' => min($score, 100),
            'level' => $level
        ];
    }
}