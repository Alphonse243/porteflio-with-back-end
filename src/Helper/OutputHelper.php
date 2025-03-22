<?php
namespace App\Helper;

class OutputHelper {
    public static function sanitize($text) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }
}
