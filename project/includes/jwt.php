<?php
require_once '../vendor/autoload.php'; // Подключаем библиотеку Firebase JWT

use Firebase\JWT\JWT;

class JWTHandler {
    private static $secret_key = SECRET_KEY;
    private static $algorithm = 'HS256';

    public static function generateToken($data) {
        $issued_at = time();
        $expiration_time = $issued_at + 60 * 60; // Токен действителен 1 час

        $token = JWT::encode(
            array(
                'iat' => $issued_at,
                'exp' => $expiration_time,
                'data' => $data
            ),
            self::$secret_key,
            self::$algorithm
        );

        return $token;
    }

    public static function decodeToken($token) {
        try {
            $decoded = JWT::decode($token, self::$secret_key, array(self::$algorithm));
            return $decoded->data;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function isTokenBlacklisted($token) {
        // Загрузите черный список из файла
        $blacklist = file('../includes/blacklist.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    
        // Проверка, не является ли токен частью черного списка
        return in_array($token, $blacklist);
    }
}
?>
